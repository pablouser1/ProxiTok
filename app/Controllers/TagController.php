<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\RSS;
use App\Models\FeedTemplate;

class TagController {
    static public function get(string $name) {
        $cursor = Misc::getCursor();
        $api = Misc::api();
        $feed = $api->getChallengeFeed($name, $cursor);
        if ($feed->meta->success) {
            $latte = Misc::latte();
            $latte->render(Misc::getView('tag'), new FeedTemplate('Tag', $feed));
        } else {
            ErrorHandler::show($feed->meta);
        }
    }

    static public function rss(string $name) {
        $api = Misc::api();
        $feed = $api->getChallengeFeed($name);
        if ($feed->meta->success) {
            $feed = RSS::build("/tag/{$name}", "{$name} Tag", $feed->info->detail->challenge->desc, $feed->items);
            // Setup headers
            RSS::setHeaders('tag.rss');
            echo $feed;
        }
    }
}
