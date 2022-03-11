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

    static public function proxy() {
        if (in_array(Cookies::PROXY, $_POST)) {
            foreach (Cookies::PROXY as $proxy_element) {
                Cookies::set($proxy_element, $_POST[$proxy_element]);
            }
        }
        $url = Misc::url('/settings');
        header("Location: {$url}");
    }

    static public function api() {
        $_POST['legacy'] ?? Cookies::set('api-legacy', '1');
        $url = Misc::url('/settings');
        header("Location: {$url}");
    }
}
