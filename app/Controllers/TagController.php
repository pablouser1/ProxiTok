<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Models\FullTemplate;
use App\Models\RSSTemplate;

class TagController {
    static public function get(string $name) {
        $cursor = Misc::getCursor();
        $api = Wrappers::api();
        $hashtag = $api->hashtag($name);
        $hashtag->feed($cursor);
        if ($hashtag->ok()) {
            $data = $hashtag->getFull();
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('tag'), new FullTemplate('Tag', $data));
        } else {
            ErrorHandler::show($hashtag->error());
        }
    }

    static public function rss(string $name) {
        $api = Wrappers::api();
        $hashtag = $api->hashtag($name);
        $hashtag->feed();
        if ($hashtag->ok()) {
            $data = $hashtag->getFull();
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('rss'), new RSSTemplate($name, $data->info->detail->desc, "/tag/{$name}", $data->feed->items));
        }
    }
}
