<?php
namespace Helpers\CacheEngines;

class JSONCache {
    private string $cache_path = __DIR__ . '/../../cache/api';

    function __construct() {
        if (isset($_ENV['API_CACHE_JSON']) && !empty($_ENV['API_CACHE_JSON'])) {
            $this->cache_path = $_ENV['API_CACHE_JSON'];
        }
    }
    public function get(string $cache_key): object|false {
        $filename = $this->cache_path . '/' . $cache_key . '.json';
        if (is_file($filename)) {
            $time = time();
            $json_string = file_get_contents($filename);
            $element = json_decode($json_string);
            if ($time < $element->expires) {
                return $element->data;
            }
            // Remove file if expired
            unlink($filename);
        }
        return false;
    }

    public function set(string $cache_key, mixed $data, $timeout = 3600) {
        file_put_contents($this->cache_path . '/' . $cache_key . '.json', json_encode([
            'data' => $data,
            'expires' => time() + $timeout
        ]));
    }
}
