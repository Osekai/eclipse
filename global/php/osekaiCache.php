<?php

class Caching
{
    private static $memcached = null;
    private static $available = null;

    private static function connect()
    {
        if (self::$available !== null) return self::$available;

        if (!class_exists('Memcached')) {
            self::$available = false;
            return false;
        }

        try {
            self::$memcached = new Memcached();
            self::$memcached->addServer('127.0.0.1', 11211);

            // addServer is lazy, so probe before trusting the connection
            $stats = self::$memcached->getStats();
            self::$available = ($stats !== false && count(array_filter($stats)) > 0);
        } catch (Exception $e) {
            self::$available = false;
        }

        return self::$available;
    }

    // tracks keys under a prefix so wipeCacheFromPrefix can find them later
    private static function indexKey($name)
    {
        if (!self::connect()) return;

        // index bucket is the portion before the first separator, if any
        $prefix = self::prefixOf($name);
        if ($prefix === null) return;

        $indexName = 'idx:' . $prefix;
        $index = self::$memcached->get($indexName);
        if (!is_array($index)) $index = [];

        if (!in_array($name, $index, true)) {
            $index[] = $name;
            self::$memcached->set($indexName, $index, 0);
        }
    }

    private static function prefixOf($name)
    {
        foreach (['_', ':', '-'] as $sep) {
            $pos = strpos($name, $sep);
            if ($pos !== false) return substr($name, 0, $pos + 1);
        }
        return null;
    }

    public static function getCache($name)
    {
        if (!self::connect()) return null;

        $value = self::$memcached->get($name);
        if (self::$memcached->getResultCode() !== Memcached::RES_SUCCESS) return null;

        return $value;
    }

    public static function saveCache($name, $expiry, $data)
    {
        if (!self::connect()) return;

        if (is_numeric($expiry)) {
            // preserved from the original class, which doubled numeric expiries
            $ttl = (int)($expiry * 2);
        } else {
            // date string - convert to seconds from now
            $ttl = strtotime($expiry) - time();
            if ($ttl === false || $ttl < 0) $ttl = 0;
        }

        // memcached reads ttl > 30 days as an absolute timestamp, so clamp
        if ($ttl > 2592000) $ttl = 2592000;

        self::$memcached->set($name, $data, $ttl);
        self::indexKey($name);
    }

    public static function cleanCache()
    {
        // no-op: memcached expires entries on its own
    }

    public static function wipeCache($cacheName)
    {
        if (!self::connect()) return;
        self::$memcached->delete($cacheName);
    }

    public static function wipeCacheFromPrefix($prefix)
    {
        if (!self::connect()) return;

        $indexName = 'idx:' . $prefix;
        $index = self::$memcached->get($indexName);
        if (!is_array($index)) return;

        foreach ($index as $key) {
            self::$memcached->delete($key);
        }
        self::$memcached->delete($indexName);
    }

    // true if memcached is reachable - use this to verify setup
    public static function isAvailable()
    {
        return self::connect();
    }
}
?>