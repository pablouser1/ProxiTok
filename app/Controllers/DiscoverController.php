<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Models\DiscoverTemplate;

class DiscoverController {
    static public function get() {
        $api = Misc::api();
        $feed = $api->getDiscover();
        if ($feed->meta->success) {
            $latte = Misc::latte();
            $latte->render(Misc::getView('discover'), new DiscoverTemplate($feed));
        } else {
            ErrorHandler::show($feed->meta);
        }
    }
}
