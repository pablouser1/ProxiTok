<?php
namespace App\Helpers;

use App\Models\ErrorTemplate;
use TikScraper\Models\Meta;

class ErrorHandler {
    public static function showMeta(Meta $meta) {
        http_response_code($meta->http_code);
        Wrappers::latte('error', new ErrorTemplate($meta->http_code, $meta->tiktok_msg, $meta->tiktok_code));
    }

    public static function showText(int $code, string $msg) {
        http_response_code($code);
        Wrappers::latte('error', new ErrorTemplate($code, $msg));
    }
}
