<?php
namespace App\Helpers;

use App\Constants\Themes;

class Cookies {
    public static function get(string $name, string $default_value = ''): string {
        if (isset($_COOKIE[$name]) && !empty($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return $default_value;
    }

    public static function theme(): string {
        $theme = self::get('theme');
        $ref = new \ReflectionClass(Themes::class);
        $themes = $ref->getConstants();
        if ($theme && in_array($theme, $themes)) {
            return $theme;
        }
        return 'default';
    }

    public static function downloader(): string {
        $downloader = self::get('api-downloader', 'default');
        return $downloader;
    }

    public static function exists(string $name): bool {
        return isset($_COOKIE[$name]);
    }

    public static function check(string $name, string $value): bool {
        return self::exists($name) && $_COOKIE[$name] === $value;
    }

    public static function set(string $name, string $value) {
        setcookie($name, $value, time()+60*60*24*30, '/', '', isset($_SERVER['HTTPS']), true);
    }
};
