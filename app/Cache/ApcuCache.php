<?php
namespace App\Cache;

use TikScraper\Interfaces\ICache;

class ApcuCache implements ICache {
    function __construct() {
        if (!(extension_loaded('apcu') && apcu_enabled())) {
            throw new \Exception('APCu not enabled');
        }
    }

    public function get(string $cache_key): ?object {
        $data = apcu_fetch($cache_key);
        return $data !== false ? json_decode($data) : null;
    }

    public function exists(string $cache_key): bool {
        return apcu_exists($cache_key);
    }

    public function set(string $cache_key, string $data, int $timeout = 3600): void {
        apcu_store($cache_key, $data, $timeout);
    }
}
