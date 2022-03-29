<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Models\FeedTemplate;

class MusicController {
    static public function get(string $music_id) {
        $cursor = Misc::getCursor();

        $api = Wrappers::api();
        $feed = $api->getMusicFeed($music_id, $cursor);
        if ($feed->meta->success) {
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('music'), new FeedTemplate('Music', $feed));
        } else {
            ErrorHandler::show($feed->meta);
        }
    }
}
