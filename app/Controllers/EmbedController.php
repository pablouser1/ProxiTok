<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Wrappers;
use App\Models\VideoTemplate;

class EmbedController {
    public static function v2(int $id) {
        $api = Wrappers::api();
        $video = $api->video($id);
        $video->feed();
        if ($video->ok()) {
            $item = $video->getFeed()->items[0];
            $info = $video->getInfo();
            Wrappers::latte('video', new VideoTemplate($item, $info, true));
        } else {
            ErrorHandler::showMeta($video->error());
        }
    }
}
