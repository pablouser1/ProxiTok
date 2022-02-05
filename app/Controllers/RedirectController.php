<?php
namespace App\Controllers;
use App\Helpers\Misc;

/**
 * Used to be compatible with HTML forms
 */
class RedirectController {
    static public function redirect() {
        $endpoint = '';
        if (isset($_GET['user'])) {
            $endpoint = '/@' . $_GET['user'];
        } else if (isset($_GET['tag'])) {
            $endpoint = '/tag/' . $_GET['tag'];
        } else if (isset($_GET['music'])) {
            $endpoint = '/music/' . $_GET['music'];
        } else if (isset($_GET['video'])) {
            $endpoint = '/video/' . $_GET['video'];
        }

        $url = Misc::url($endpoint);
        header("Location: {$url}");
    }
}
