<?php
namespace App\Helpers;

class Cookies {
    const ALLOWED_THEMES = ['default', 'card'];

    static public function get(string $name, string $default_value = ''): string {
        if (isset($_COOKIE[$name]) && !empty($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return $default_value;
    }

    static public function theme(): string {
        $theme = self::get('theme');
        if ($theme && in_array($theme, self::ALLOWED_THEMES)) {
            return $theme;
        }
        return 'default';
    }

    static public function exists(string $name): bool {
        return isset($_COOKIE[$name]);
    }

    static public function check(string $name, string $value): bool {
        return self::exists($name) && $_COOKIE[$name] === $value;
    }

    static public function set(string $name, string $value) {
        setcookie($name, $value, time()+60*60*24*30, '/', '', isset($_SERVER['HTTPS']), true);
    }
};
