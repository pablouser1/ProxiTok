<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Models\FeedTemplate;

class MusicController {
    static public function get(string $music_id) {
        $cursor = Misc::getCursor();

        $api = Misc::api();
        $feed = $api->getMusicFeed($music_id, $cursor);
        if ($feed->meta->success) {
            $latte = Misc::latte();
            $latte->render(Misc::getView('music'), new FeedTemplate('Music', $feed));
        } else {
            ErrorHandler::show($feed->meta);
        }
    }
}
