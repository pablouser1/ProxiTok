<?php
namespace App\Controllers;

use App\Helpers\Misc;
use App\Helpers\Cookies;
use App\Helpers\Following;
use App\Models\SettingsTemplate;

class SettingsController {
    static public function index() {
        $latte = Misc::latte();
        $latte->render(Misc::getView('settings'), new SettingsTemplate());
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

    static public function following() {
        $following = Following::getUsers();
        if (!isset($_POST['mode']) || empty($_POST['mode'])) {
            die('You need to send a mode');
        }

        switch ($_POST['mode']) {
            case 'add':
                // Add following
                array_push($following, $_POST['account']);
                break;
            case 'remove':
                // Remove following
                $index = array_search($_POST['account'], $following);
                if ($index !== false) {
                    unset($following[$index]);
                }
                break;
            default:
                // Invalid
                die('Invalid mode');
        }

        // Build string
        $following_string = implode(',', $following);
        Cookies::set('following', $following_string);
        $url = Misc::url('/settings');
        header("Location: {$url}");
    }
}
