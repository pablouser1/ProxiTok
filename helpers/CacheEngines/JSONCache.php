<?php
namespace Helpers\CacheEngines;

class JSONCache {
    const CACHE_PATH = __DIR__ . '/../../cache/api/';
    public function get(string $cache_key): object|false {
        if (is_file(self::CACHE_PATH . $cache_key . '.json')) {
            $time = time();
            $json_string = file_get_contents(self::CACHE_PATH . $cache_key . '.json');
            $element = json_decode($json_string);
            if ($time < $element->expires) {
                return $element->data;
            }
            // Remove file if expired
            unlink(self::CACHE_PATH . $cache_key . '.json');
        }
        return false;
    }

    public function set(string $cache_key, mixed $data, $timeout = 3600) {
        file_put_contents(self::CACHE_PATH . $cache_key . '.json', json_encode([
            'data' => $data,
            'expires' => time() + $timeout
        ]));
    }
}
