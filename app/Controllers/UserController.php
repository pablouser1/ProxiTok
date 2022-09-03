<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Models\FullTemplate;
use App\Models\RSSTemplate;
use App\Models\VideoTemplate;

class UserController {
    static public function get(string $username) {
        $cursor = Misc::getCursor();
        $api = Wrappers::api();
        $user = $api->user($username);
        $user->feed($cursor);
        if ($user->ok()) {
            $data = $user->getFull();
            if ($data->info->detail->privateAccount) {
                ErrorHandler::showText(401, "Private account detected! Not supported");
                return;
            }
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('user'), new FullTemplate($data->info->detail->nickname, $data));
        } else {
            ErrorHandler::showMeta($user->error());
        }
    }

    static public function video(string $username, string $video_id) {
        $api = Wrappers::api();
        $video = $api->video($video_id);
        $video->feed();
        if ($video->ok()) {
            $data = $video->getFull();
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('video'), new VideoTemplate($data->feed->items[0], $data->info->detail));
        } else {
            ErrorHandler::showMeta($video->error());
        }
    }

    static public function rss(string $username) {
        $api = Wrappers::api();
        $user = $api->user($username);
        $user->feed();
        if ($user->ok()) {
            $data = $user->getFull();
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('rss'), new RSSTemplate($username, $data->info->detail->signature, '/@' . $username, $data->feed->items));
        }
    }
}
