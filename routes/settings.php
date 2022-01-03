<?php
require __DIR__ . "/../helpers/settings_elements.php";
use Steampixel\Route;

Route::add("/settings", function () use ($proxy_elements) {
    $latte = getLatte();
    $latte->render(getView('settings'), ["proxy_elements" => $proxy_elements]);
});

Route::add("/settings", function () use ($proxy_elements) {
    if (in_array($proxy_elements, $_POST)) {
        foreach ($proxy_elements as $proxy_element) {
            setcookie($proxy_element, $_POST[$proxy_element], time()+60*60*24*30, '/', '', true, true);
        }
    }
    http_response_code(302);
	header('Location: ./home');
}, 'POST');
