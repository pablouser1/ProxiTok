<?php
namespace App\Helpers;

class Cookies {
    const PROXY = ['proxy-host', 'proxy-port', 'proxy-username', 'proxy-password'];

    static public function get(string $name): string {
        if (isset($_COOKIE[$name]) && !empty($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return '';
    }

    static public function exists(string $name): bool {
        return isset($_COOKIE[$name]);
    }

    static public function set(string $name, string $value) {
        setcookie($name, $value, time()+60*60*24*30, '/', '', isset($_SERVER['HTTPS']), true);
    }
};
