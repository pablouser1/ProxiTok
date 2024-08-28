<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Models\FeedTemplate;

class FollowingController {
    public static function get() {
        $cursor = Misc::getCursor();

        $api = Wrappers::api();
        $following = $api->following();
        $following->feed($cursor);
        if ($following->ok()) {
            $feed = $following->getFeed();
            Wrappers::latte('following', new FeedTemplate('Following / Discover', $feed));
        } else {
            ErrorHandler::showMeta($following->error());
        }
    }
}
