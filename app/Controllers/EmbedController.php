<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Models\VideoTemplate;

class EmbedController {
    static public function v2(int $id) {
        $api = Wrappers::api();
        $video = $api->video($id);
        $video->feed();
        if ($video->ok()) {
            $data = $video->getFull();
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('video'), new VideoTemplate($data->feed->items[0], $data->info->detail, true));
        } else {
            ErrorHandler::showMeta($video->error());
        }
    }
}
