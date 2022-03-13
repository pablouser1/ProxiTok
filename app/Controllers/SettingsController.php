<?php
namespace App\Controllers;

use App\Helpers\Misc;
use App\Helpers\Cookies;
use App\Models\SettingsTemplate;

class SettingsController {
    static public function index() {
        $latte = Misc::latte();
        $latte->render(Misc::getView('settings'), new SettingsTemplate);
    }

    static private function redirect() {
        $url = Misc::url('/settings');
        header("Location: {$url}");
    }

    static public function proxy() {
        if (in_array(Cookies::PROXY, $_POST)) {
            foreach (Cookies::PROXY as $proxy_element) {
                Cookies::set($proxy_element, $_POST[$proxy_element]);
            }
        }
        self::redirect();
    }

    static public function api() {
        $legacy = 'off';
        if (isset($_POST['api-legacy'])) {
            $legacy = 'on';
        }
        Cookies::set('api-legacy', $legacy);
        self::redirect();
    }
}
