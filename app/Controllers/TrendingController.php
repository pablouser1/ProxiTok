<?php
namespace App\Controllers;

use App\Helpers\Misc;
use App\Models\FeedTemplate;
use App\Helpers\ErrorHandler;
use App\Helpers\RSS;

class TrendingController {
    static public function get() {
        $cursor = Misc::getTtwid();
        $page = $_GET['page'] ?? 0;
        $api = Misc::api();
        $feed = $api->getTrending($cursor, $page);
        if ($feed->meta->success) {
            $latte = Misc::latte();
            $latte->render(Misc::getView('trending'), new FeedTemplate('Trending', $feed));
        } else {
            ErrorHandler::show($feed->meta);
        }
    }

    static public function rss() {
        $api = Misc::api();
        $feed = $api->getTrending();
        if ($feed->meta->success) {
            $feed = RSS::build('/trending', 'Trending', 'Tiktok trending', $feed->items);
            // Setup headers
            RSS::setHeaders('trending.rss');
            echo $feed;
        }
    }
}
