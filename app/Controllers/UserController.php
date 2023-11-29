<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\UrlBuilder;
use App\Helpers\Wrappers;
use App\Models\FullTemplate;
use App\Models\RSSTemplate;
use App\Models\VideoTemplate;

class UserController {
    public static function get(string $username) {
        $cursor = Misc::getCursor();
        $api = Wrappers::api();
        $user = $api->user($username);
        $user->feed($cursor);
        if ($user->ok()) {
            $info = $user->getInfo();
            $feed = $user->getFeed();
            Wrappers::latte('user', new FullTemplate($info->detail->nickname, $info, $feed));
        } else {
            ErrorHandler::showMeta($user->error());
        }
    }

    public static function video(string $username, string $video_id) {
        $api = Wrappers::api();
        $video = $api->video($video_id);
        $video->feed();
        if ($video->ok()) {
            $item = $video->getFeed()->items[0];
            $info = $video->getInfo();
            Wrappers::latte('video', new VideoTemplate($item, $info));
        } else {
            ErrorHandler::showMeta($video->error());
        }
    }

    public static function rss(string $username) {
        $api = Wrappers::api();
        $user = $api->user($username);
        $user->feed();
        if ($user->ok()) {
            $data = $user->getFull();
            Misc::rss($username);
            Wrappers::latte('rss', new RSSTemplate($data->info->detail->nickname, $data->info->detail->signature, UrlBuilder::stream($data->info->detail->avatarLarger), UrlBuilder::user($username), $data->feed->items));
        }
    }
}
