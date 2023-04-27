<?php
namespace App\Controllers;

use App\Helpers\ErrorHandler;
use App\Helpers\Wrappers;
use App\Models\DiscoverTemplate;

class DiscoverController {
    public static function get() {
        $api = Wrappers::api();
        $data = $api->discover();
        if ($data->meta->success) {
            Wrappers::latte('discover', new DiscoverTemplate($data));
        } else {
            ErrorHandler::showMeta($data->meta);
        }
    }
}
