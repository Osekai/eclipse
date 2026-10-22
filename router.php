<?php
function eclipse_send_log($body, $attributes, $severity = 'INFO') {
    $now = (int)(microtime(true) * 1e9);

    $otelAttributes = [];
    foreach ($attributes as $key => $value) {
        $otelAttributes[] = ['key' => $key, 'value' => ['stringValue' => (string)$value]];
    }

    $payload = [
        'resourceLogs' => [[
            'resource' => [
                'attributes' => [
                    ['key' => 'service.name', 'value' => ['stringValue' => 'eclipse']],
                ],
            ],
            'scopeLogs' => [[
                'logRecords' => [[
                    'timeUnixNano' => (string)$now,
                    'observedTimeUnixNano' => (string)$now,
                    'severityText' => $severity,
                    'body' => ['stringValue' => $body],
                    'attributes' => $otelAttributes,
                ]],
            ]],
        ]],
    ];

    $json = json_encode($payload);
    if ($json === false) return; // nothing sensible we can do here

    $ch = curl_init('http://vero.untone.uk:4328/v1/logs');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $json,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT_MS => 300,
        CURLOPT_CONNECTTIMEOUT_MS => 300,
    ]);
    curl_exec($ch);
    curl_close($ch);
}

// common request context, reused by both request and error logs
function eclipse_request_context() {
    $fullUri = $_SERVER['REQUEST_URI'] ?? '';
    return [
        'url' => strtok($fullUri, '?'), // path only, no query string
        'params' => $_SERVER['QUERY_STRING'] ?? '',
        'method' => $_SERVER['REQUEST_METHOD'] ?? '',
        'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    ];
}

function eclipse_log_request($duration = null, $status = null) {
    $attributes = eclipse_request_context();
    if ($duration !== null) $attributes['duration'] = round($duration, 2);
    if ($status !== null) $attributes['status'] = $status;
    eclipse_send_log('eclipse.request', $attributes);
}

// non-fatal errors, warnings, notices
function eclipse_error_handler($severity, $message, $file, $line) {
    $attributes = eclipse_request_context();
    $attributes['error_message'] = $message;
    $attributes['error_file'] = $file;
    $attributes['error_line'] = $line;
    $attributes['error_severity'] = $severity;

    eclipse_send_log('eclipse.error', $attributes, 'ERROR');

    return false; // let php's normal handler run too
}

// fatal errors, caught on shutdown
function eclipse_shutdown_handler() {
    $error = error_get_last();
    if ($error === null) return;
    if (!in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) return;

    $attributes = eclipse_request_context();
    $attributes['error_message'] = $error['message'];
    $attributes['error_file'] = $error['file'];
    $attributes['error_line'] = $error['line'];
    $attributes['error_severity'] = $error['type'];

    eclipse_send_log('eclipse.fatal', $attributes, 'FATAL');
}

// uncaught exceptions
function eclipse_exception_handler($exception) {
    $attributes = eclipse_request_context();
    $attributes['error_message'] = $exception->getMessage();
    $attributes['error_file'] = $exception->getFile();
    $attributes['error_line'] = $exception->getLine();
    $attributes['error_class'] = get_class($exception);

    eclipse_send_log('eclipse.exception', $attributes, 'ERROR');
}

set_error_handler('eclipse_error_handler');
set_exception_handler('eclipse_exception_handler');
register_shutdown_function('eclipse_shutdown_handler');

$route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (str_ends_with($route, '.php')) {
    $targetFile = $_SERVER['DOCUMENT_ROOT'] . $route;
} else {
    $targetFile = $_SERVER['DOCUMENT_ROOT'] . rtrim($route, '/') . '.php';
    if (!is_file($targetFile)) {
        $targetFile = $_SERVER['DOCUMENT_ROOT'] . rtrim($route, '/') . '/index.php';
    }
}

if (!is_file($targetFile)) {
    eclipse_log_request(null, 404);
    include($_SERVER['DOCUMENT_ROOT'] . '/404/index.php');
    exit;
}

$start = microtime(true);
include $targetFile;
$duration = (microtime(true) - $start) * 1000;
eclipse_log_request($duration, http_response_code());