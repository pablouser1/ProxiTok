<?php
namespace App\Helpers;

class Misc {
    public static function getCursor(): int {
        return isset($_GET['cursor']) && is_numeric($_GET['cursor']) ? (int) $_GET['cursor'] : 0;
    }

    public static function getTtwid(): string {
        return isset($_GET['cursor']) ? $_GET['cursor'] : '';
    }

    public static function url(string $endpoint = ''): string {
        return self::env('APP_URL', '') . $endpoint;
    }

    public static function env(string $key, $default_value) {
        return $_ENV[$key] ?? $default_value;
    }

    /**
     * Returns absolute path for view
     */
    public static function getView(string $template): string {
        return __DIR__ . "/../../templates/views/{$template}.latte";
    }

    public static function getScraperOptions(): array {
        $debug = self::env('APP_DEBUG', false);
        $url = self::env('API_CHROMEDRIVER', 'http://localhost:4444');
        $verifyFp = self::env('API_VERIFYFP', '');
        $device_id = self::env('API_DEVICE_ID', '');
        $ua = self::env('USER_AGENT', '');

        $options = [
            'debug' => $debug,
            'browser' => [
                'url' => $url,
                'close_when_done' => false
            ],
            'verify_fp' => $verifyFp,
            'device_id' => $device_id,
            'user_agent' => $ua
        ];

        $proxy = Misc::env('PROXY', '');

        if ($proxy !== '') {
            $options['proxy'] = $proxy;
        }

        return $options;
    }

    /**
     * Common method for rss feeds
     */
    public static function rss(string $title) {
        header('Content-Type: application/rss+xml');
        header('Content-Disposition: attachment; filename="' . $title . '.rss' . '"');
    }
}
