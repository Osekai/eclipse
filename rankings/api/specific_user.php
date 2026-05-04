<?php


require_once($_SERVER['DOCUMENT_ROOT'] . "/global/php/functions.php");
// report errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    if (isset($_GET['id'])) {
        $UserWithRank = Database::execSelect("
            SELECT ranked.*
            FROM (
                SELECT @r := @r + 1 AS `rank`, t1.*
                FROM (
                    SELECT *
                    FROM Ranking
                    ORDER BY stdev_pp DESC, total_pp DESC
                ) AS t1, (SELECT @r := 0) AS vars
            ) AS ranked
            WHERE ranked.`id` = ?
            LIMIT 1
        ", "i", [$_GET['id']]);

        echo json_encode($UserWithRank);
    } else {
        echo json_encode(["error" => "missing id"]);
    }
} catch (Exception $e) {
    echo json_encode([
        "error" => "exception occurred",
        "message" => $e->getMessage()
    ]);
}

