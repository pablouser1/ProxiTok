<?php

use Helpers\Following;
use Helpers\Settings;
use Helpers\Misc;
use Steampixel\Route;

Route::add("/settings", function () {
    $latte = Misc::latte();
    $latte->render(Misc::getView('settings'), ["proxy_elements" => Settings::$proxy, "following" => Following::get()]);
});

Route::add("/settings/proxy", function () {
    if (in_array(Settings::$proxy, $_POST)) {
        foreach (Settings::$proxy as $proxy_element) {
            Settings::set($proxy_element, $_POST[$proxy_element]);
        }
    }
    http_response_code(302);
	header('Location: ./home');
}, 'POST');


Route::add("/settings/following", function () {
    $following = Following::get();

    if (isset($_POST['add'])) {
        // Add following
        array_push($following, $_POST['account']);
    } elseif (isset($_POST['remove'])) {
        $index = array_search($_POST['account'], $following);
        if ($index !== false) {
            unset($following[$index]);
        }
    } else {
        return 'You need to send a mode!';
    }

    // Build string
    $following_string = implode(',', $following);
    Settings::set('following', $following_string);
    header('Location: ../settings');
}, 'POST');
