<?php
namespace App\Cache;

class RedisCache {
    private \Redis $client;
    function __construct(string $host, int $port, ?string $password) {
        $this->client = new \Redis();
        if (!$this->client->connect($host, $port)) {
            throw new \Exception('REDIS: Could not connnect to server');
        }
        if ($password) {
            if (!$this->client->auth($password)) {
                throw new \Exception('REDIS: Could not authenticate');
            }
        }
    }

    function __destruct() {
        $this->client->close();
    }

    public function get(string $cache_key): ?object {
        $data = $this->client->get($cache_key);
        if ($data) {
            return json_decode($data);
        }
        return null;
    }

    public function set(string $cache_key, mixed $data, $timeout = 3600) {
        $this->client->set($cache_key, json_encode($data), $timeout);
    }
}
