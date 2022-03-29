<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Models\FeedTemplate;
use App\Models\RSSTemplate;

class TagController {
    static public function get(string $name) {
        $cursor = Misc::getCursor();
        $api = Wrappers::api();
        $feed = $api->getHashtagFeed($name, $cursor);
        if ($feed->meta->success) {
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('tag'), new FeedTemplate('Tag', $feed));
        } else {
            ErrorHandler::show($feed->meta);
        }
    }

    static public function rss(string $name) {
        $api = Wrappers::api();
        $feed = $api->getHashtagFeed($name);
        if ($feed->meta->success) {
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('rss'), new RSSTemplate($name, $feed->info->detail->desc, "/tag/{$name}", $feed->items));
        }
    }
}
