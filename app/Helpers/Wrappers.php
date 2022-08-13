<?php
namespace App\Helpers;

use App\Cache\JSONCache;
use App\Cache\RedisCache;
use App\Constants\CacheMethods;

class Wrappers {
    /**
     * Setup of Latte template engine
     */
    static public function latte(): \Latte\Engine {
        $latte = new \Latte\Engine;
        $cache_path = Misc::env('LATTE_CACHE', __DIR__ . '/../../cache/latte');
        $latte->setTempDirectory($cache_path);

        // -- CUSTOM FUNCTIONS -- //
        // Get URL with optional endpoint
        $latte->addFunction('path', function (string $endpoint = ''): string {
            return Misc::url($endpoint);
        });
        // Version being used
        $latte->addFunction('version_frontend', function (): string {
            return \Composer\InstalledVersions::getVersion('pablouser1/proxitok');
        });
        $latte->addFunction('version_scraper', function (): string {
            return \Composer\InstalledVersions::getVersion('pablouser1/tikscraper');
        });
        $latte->addFunction('theme', function(): string {
            return Cookies::theme();
        });
        // https://stackoverflow.com/a/36365553
        $latte->addFunction('number', function (float $x) {
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

    /**
     * Setup of TikTok Api wrapper
     */
    static public function api(): \TikScraper\Api {
        $method = Misc::env('API_SIGNER', '');
        $url = Misc::env('API_SIGNER_URL', '');
        if (!$method) {
            // Legacy support
            $browser_url = Misc::env('API_BROWSER_URL', '');
            if ($url) {
                $method = 'remote';
            } elseif ($browser_url) {
                $url = $browser_url;
                $method = 'browser';
            }
        }

        $options = [
            'use_test_endpoints' => Misc::env('API_TEST_ENDPOINTS', false) || isset($_COOKIE['api-test_endpoints']) && $_COOKIE['api-test_endpoints'] === 'yes',
            'signer' => [
                'method' => $method,
                'url' => $url,
                'close_when_done' => false
            ]
        ];
        // Cache config
        $cacheEngine = null;
        if (isset($_ENV['API_CACHE'])) {
            switch ($_ENV['API_CACHE']) {
                case CacheMethods::JSON:
                    $cacheEngine = new JSONCache();
                    break;
                case CacheMethods::REDIS:
                    if (!(isset($_ENV['REDIS_URL']) || isset($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']))) {
                        throw new \Exception('You need to set REDIS_URL or REDIS_HOST and REDIS_PORT to use Redis Cache!');
                    }

                    if (isset($_ENV['REDIS_URL'])) {
                        $url = parse_url($_ENV['REDIS_URL']);
                        $host = $url['host'];
                        $port = $url['port'];
                        $password = $url['pass'] ?? null;
                    } else {
                        $host = $_ENV['REDIS_HOST'];
                        $port = (int) $_ENV['REDIS_PORT'];
                        $password = isset($_ENV['REDIS_PASSWORD']) ? $_ENV['REDIS_PASSWORD'] : null;
                    }
                    $cacheEngine = new RedisCache($host, $port, $password);
                    break;
            }
        }

        return new \TikScraper\Api($options, $cacheEngine);
    }
}
