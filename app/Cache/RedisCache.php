<?php
namespace App\Cache;

use TikScraper\Interfaces\ICache;

class RedisCache implements ICache {
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
        return $data ? json_decode($data) : null;
    }

    public function exists(string $cache_key): bool {
        return $this->client->exists($cache_key);
    }

    public function set(string $cache_key, string $data, int $timeout = 3600) {
        $this->client->set($cache_key, $data, $timeout);
    }
}
