<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Models\FeedTemplate;

class DiscoverController {
    static public function get() {
        $api = Wrappers::api();
        $feed = $api->discover();
        if ($feed->meta->success) {
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('discover'), new FeedTemplate('Discover', $feed));
        } else {
            ErrorHandler::show($feed->meta);
        }
    }
}
