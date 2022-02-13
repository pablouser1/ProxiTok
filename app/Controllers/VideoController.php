<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Models\FeedTemplate;

class VideoController {
    static public function get(string $video_id) {
        $api = Misc::api();
        $item = $api->getVideoByID($video_id);
        if ($item->meta->success) {
            $latte = Misc::latte();
            $latte->render(Misc::getView('video'), new FeedTemplate($item->info->detail->nickname, $item));
        } else {
            ErrorHandler::show($item->meta);
        }
    }
}
