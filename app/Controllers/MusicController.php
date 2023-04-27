<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Models\FullTemplate;

class MusicController {
    public static function get(string $music_id) {
        $cursor = Misc::getCursor();

        $api = Wrappers::api();
        $music = $api->music($music_id);
        $music->feed($cursor);
        if ($music->ok()) {
            $info = $music->getInfo();
            $feed = $music->getFeed();
            Wrappers::latte('music', new FullTemplate('Music', $info, $feed));
        } else {
            ErrorHandler::showMeta($music->error());
        }
    }
}
