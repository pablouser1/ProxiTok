<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Models\FullTemplate;

class MusicController {
    static public function get(string $music_id) {
        $cursor = Misc::getCursor();

        $api = Wrappers::api();
        $music = $api->music($music_id);
        $music->feed($cursor);
        if ($music->ok()) {
            $data = $music->getFull();
            Wrappers::latte('music', new FullTemplate('Music', $data));
        } else {
            ErrorHandler::showMeta($music->error());
        }
    }
}
