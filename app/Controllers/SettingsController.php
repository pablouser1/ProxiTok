<?php
namespace App\Controllers;

use App\Helpers\Misc;
use App\Helpers\Cookies;
use App\Helpers\Wrappers;
use App\Models\BaseTemplate;

class SettingsController {
    static public function index() {
        $latte = Wrappers::latte();
        $latte->render(Misc::getView('settings'), new BaseTemplate('Settings'));
    }

    static private function redirect() {
        $url = Misc::url('/settings');
        header("Location: {$url}");
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
        self::redirect();
    }
}
