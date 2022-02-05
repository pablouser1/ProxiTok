<?php
namespace App\Helpers;

use App\Cache\JSONCache;
use App\Cache\RedisCache;

class Misc {
    static public function getCursor(): int {
        return isset($_GET['cursor']) && is_numeric($_GET['cursor']) ? (int) $_GET['cursor'] : 0;
    }

    static public function url(string $endpoint = '') {
        return self::env('APP_URL', '') . $endpoint;
    }

    static public function env(string $key, string $default_value): string {
        return isset($_ENV[$key]) && !empty($_ENV[$key]) ? $_ENV[$key] : $default_value;
    }

    /**
     * Returns absolute path for view
     */
    static public function getView(string $template): string {
        return __DIR__ . "/../../views/{$template}.latte";
    }

    /**
     * Setup of TikTok Api wrapper
     */
    static public function api(): \Sovit\TikTok\Api {
        $options = [];
        $cacheEngine = false;
        // Proxy config
        foreach(Cookies::PROXY as $proxy_element) {
            if (isset($_COOKIE[$proxy_element])) {
                $options['proxy'][$proxy_element] = $_COOKIE[$proxy_element];
            }
        }
        // Cache config
        if (isset($_ENV['API_CACHE'])) {
            switch ($_ENV['API_CACHE']) {
                case 'json':
                    $cacheEngine = new JSONCache();
                    break;
                case 'redis':
                    if (!isset($_ENV['REDIS_URL'])) {
                        throw new \Exception('You need to set REDIS_URL to use Redis Cache!');
                    }

                    $url = parse_url($_ENV['REDIS_URL']);
                    $host = $url['host'];
                    $port = $url['port'];
                    $password = $url['pass'] ?? null;
                    $cacheEngine = new RedisCache($host, $port, $password);
                    break;
            }
        }
        $api = new \Sovit\TikTok\Api($options, $cacheEngine);
        return $api;
    }

    /**
     * Setup of Latte template engine
     */
    static public function latte(): \Latte\Engine {
        $latte = new \Latte\Engine;
        $cache_path = self::env('LATTE_CACHE', __DIR__ . '/../../cache/latte');
        $latte->setTempDirectory($cache_path);

        // -- CUSTOM FUNCTIONS -- //
        // Get URL with optional endpoint
        $latte->addFunction('path', function (string $endpoint = ''): string {
            return self::url($endpoint);
        });
        // Version being used
        $latte->addFunction('version', function (): string {
            return \Composer\InstalledVersions::getVersion('pablouser1/proxitok');
        });
        // https://stackoverflow.com/a/36365553
        $latte->addFunction('number', function (int $x) {
            if($x > 1000) {
                $x_number_format = number_format($x);
                $x_array = explode(',', $x_number_format);
                $x_parts = array('K', 'M', 'B', 'T');
                $x_count_parts = count($x_array) - 1;
                $x_display = $x;
                $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
                $x_display .= $x_parts[$x_count_parts - 1];
                return $x_display;
            }
            return $x;
        });
        return $latte;
    }
}
