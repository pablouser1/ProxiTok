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
        $cursor = Misc::getTtwid();

        $trending = $api->trending();
        $trending->feed($cursor);

        $feed = $trending->getFeed();
        if ($feed && $feed->meta->success) {
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('trending'), new FeedTemplate('Trending', $feed));
        } else {
            ErrorHandler::show($trending->error());
        }
    }

    static public function rss() {
        $api = Wrappers::api();
        $trending = $api->trending();
        $trending->feed();

        $feed = $trending->getFeed();
        if ($feed && $feed->meta->success) {
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('rss'), new RSSTemplate('Trending', 'Trending on TikTok', '/trending', $feed->items));
        }
    }
}
