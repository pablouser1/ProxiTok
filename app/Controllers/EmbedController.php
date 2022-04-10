<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Models\VideoTemplate;

class EmbedController {
    static public function v2(int $id) {
        $api = Wrappers::api();
        $feed = $api->getVideoByID($id);
        if ($feed->meta->success) {
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('video'), new VideoTemplate($feed->items[0], $feed->info->detail, true));
        } else {
            ErrorHandler::show($feed->meta);
        }
    }
}
