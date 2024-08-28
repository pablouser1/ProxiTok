<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Models\FeedTemplate;
use App\Models\RSSTemplate;

class ForYouController {
    public static function get() {
        $api = Wrappers::api();
        $fyp = $api->foryou();
        $fyp->feed();
        if ($fyp->ok()) {
            $feed = $fyp->getFeed();
            Wrappers::latte('foryou', new FeedTemplate('For you', $feed));
        } else {
            ErrorHandler::showMeta($fyp->error());
        }
    }

    public static function rss() {
        $api = Wrappers::api();
        $fyp = $api->foryou();
        $fyp->feed();
        if ($fyp->ok()) {
            $feed = $fyp->getFeed();
            Misc::rss('For you');
            Wrappers::latte('rss', new RSSTemplate('For you', 'For you Page', '', Misc::url('/foryou'), $feed->items));
        }
    }
}
