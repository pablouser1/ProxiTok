<?php
namespace App\Controllers;

use App\Helpers\Misc;
use App\Helpers\Cookies;
use App\Helpers\Wrappers;
use App\Models\SettingsTemplate;

class SettingsController {
    static public function index() {
        Wrappers::latte('settings', new SettingsTemplate());
    }

    static public function general() {
        if (isset($_POST['theme'])) {
            $theme = $_POST['theme'];
            Cookies::set('theme', $theme);
        }
        self::redirect();
    }

    static public function api() {
        // TODO, ADD COUNT
        if (isset($_POST['api-test_endpoints'])) {
            $test_endpoints = $_POST['api-test_endpoints'];
            Cookies::set('api-test_endpoints', $test_endpoints);
        }

        if (isset($_POST['api-downloader'])) {
            $downloader = $_POST['api-downloader'];
            Cookies::set("api-downloader", $downloader);
        }
        self::redirect();
    }

    static private function redirect() {
        $url = Misc::url('/settings');
        header("Location: {$url}");
    }
}
