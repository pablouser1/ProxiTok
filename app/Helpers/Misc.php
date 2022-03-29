<?php
namespace App\Helpers;

class Misc {
    static private function isSecure() {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    }

    static public function getCursor(): int {
        return isset($_GET['cursor']) && is_numeric($_GET['cursor']) ? (int) $_GET['cursor'] : 0;
    }

    static public function getTtwid(): string {
        return isset($_GET['cursor']) ?  $_GET['cursor'] : '';
    }

    static public function url(string $endpoint = ''): string {
        $protocol = self::isSecure() ? 'https' : 'http';
        $root = $protocol . '://' . $_SERVER['HTTP_HOST'];
        return $root . self::env('APP_PATH', '') . $endpoint;
    }

    static public function env(string $key, $default_value) {
        return $_ENV[$key] ?? $default_value;
    }

    /**
     * Returns absolute path for view
     */
    static public function getView(string $template): string {
        return __DIR__ . "/../../views/{$template}.latte";
    }
}
