<?php
namespace App\Cache;

use App\Helpers\Misc;

class JSONCache {
    private string $cache_path = '';

    function __construct() {
        $this->cache_path = Misc::env('API_CACHE_JSON', __DIR__ . '/../../cache/api');
    }

    public function get(string $cache_key): ?object {
        $filename = $this->cache_path . '/' . $cache_key . '.json';
        if (is_file($filename)) {
            $json_string = file_get_contents($filename);
            $element = json_decode($json_string);
            return $element;
        }
        return null;
    }

    public function exists(string $cache_key): bool  {
        $filename = $this->cache_path . '/' . $cache_key . '.json';
        return is_file($filename);
    }

    public function set(string $cache_key, string $data, $timeout = 3600) {
        file_put_contents($this->cache_path . '/' . $cache_key . '.json', $data);
    }
}
