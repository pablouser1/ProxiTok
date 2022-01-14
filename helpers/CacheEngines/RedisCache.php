<?php
namespace Helpers\CacheEngines;

class RedisCache {
    private \Redis $client;
    function __construct(string $host, int $port, ?string $password) {
        $this->client = new \Redis();
        $this->client->connect($host, $port);
        if ($password) {
            $this->client->auth($password);
        }
    }

    function __destruct() {
        $this->client->close();
    }

    public function get(string $cache_key): object|false {
        if ($this->client->exists($cache_key)) {
            $data_string = $this->client->get($cache_key);
            return json_decode($data_string);
        }
        return false;
    }

    public function set(string $cache_key, mixed $data, $timeout = 3600) {
        $this->client->set($cache_key, json_encode($data), $timeout);
    }
}
