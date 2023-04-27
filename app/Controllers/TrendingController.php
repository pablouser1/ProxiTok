<?php
namespace App\Controllers;

use App\Helpers\Misc;
use App\Models\FeedTemplate;
use App\Helpers\ErrorHandler;
use App\Helpers\Wrappers;
use App\Models\RSSTemplate;

class TrendingController {
    public static function get() {
        $api = Wrappers::api();
        $cursor = Misc::getTtwid();

        $trending = $api->trending();
        $trending->feed($cursor);

        $feed = $trending->getFeed();
        if ($feed && $feed->meta->success) {
            Wrappers::latte('trending', new FeedTemplate('Trending', $feed));
        } else {
            ErrorHandler::showMeta($trending->error());
        }
    }

    public static function rss() {
        $api = Wrappers::api();
        $trending = $api->trending();
        $trending->feed();

        $feed = $trending->getFeed();
        if ($feed && $feed->meta->success) {
            Misc::rss('Trending');
            Wrappers::latte('rss', new RSSTemplate('Trending', 'Trending on TikTok', Misc::url('/trending'), $feed->items));
        }
    }
}
