<?php
namespace App\Controllers;

use App\Helpers\Misc;
use App\Models\FeedTemplate;
use App\Helpers\ErrorHandler;
use App\Helpers\Wrappers;
use App\Models\RSSTemplate;

class TrendingController {
    static public function get() {
        $api = Wrappers::api();

        // Ttwid if standard, cursor if legacy
        if ($api::MODE === 'STANDARD') {
            $cursor = Misc::getTtwid();
        } else {
            $cursor = Misc::getCursor();
        }
        $feed = $api->getTrending($cursor);
        if ($feed->meta->success) {
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('trending'), new FeedTemplate('Trending', $feed));
        } else {
            ErrorHandler::show($feed->meta);
        }
    }

    static public function rss() {
        $api = Wrappers::api();
        $feed = $api->getTrending();
        if ($feed->meta->success) {
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('rss'), new RSSTemplate('Trending', 'Trending on TikTok', '/trending', $feed->items));
        }
    }
}
