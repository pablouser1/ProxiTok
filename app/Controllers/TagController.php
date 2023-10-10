<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\UrlBuilder;
use App\Helpers\Wrappers;
use App\Models\FullTemplate;
use App\Models\RSSTemplate;

class TagController {
    public static function get(string $name) {
        $cursor = Misc::getCursor();
        $api = Wrappers::api();
        $hashtag = $api->hashtag($name);
        $hashtag->feed($cursor);
        if ($hashtag->ok()) {
            $info = $hashtag->getInfo();
            $feed = $hashtag->getFeed();
            Wrappers::latte('tag', new FullTemplate($info->detail->title, $info, $feed));
        } else {
            ErrorHandler::showMeta($hashtag->error());
        }
    }

    public static function rss(string $name) {
        $api = Wrappers::api();
        $hashtag = $api->hashtag($name);
        $hashtag->feed();
        if ($hashtag->ok()) {
            $data = $hashtag->getFull();
            Misc::rss($name);
            Wrappers::latte('rss', new RSSTemplate($name, $data->info->detail->desc, '', UrlBuilder::tag($name), $data->feed->items));
        }
    }
}
