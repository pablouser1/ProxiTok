<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Models\FeedTemplate;

class VideoController {
    static public function get(string $video_id) {
        $api = Misc::api();
        $feed = $api->getVideoByID($video_id);
        if ($feed->meta->success) {
            $latte = Misc::latte();
            $latte->render(Misc::getView('video'), new FeedTemplate('Video', $feed));
        } else {
            ErrorHandler::show($feed->meta);
        }
    }
}
