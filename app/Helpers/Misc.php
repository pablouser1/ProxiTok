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

    /**
     * Common method for rss feeds
     */
    public static function rss(string $title) {
        header('Content-Type: application/rss+xml');
        header('Content-Disposition: attachment; filename="' . $title . '.rss' . '"');
    }
}
