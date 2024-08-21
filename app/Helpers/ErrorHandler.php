<?php
namespace App\Helpers;

use App\Models\ErrorTemplate;
use TikScraper\Models\Meta;

class ErrorHandler {
    public static function showMeta(Meta $meta) {
        http_response_code($meta->httpCode);
        Wrappers::latte('error', new ErrorTemplate($meta->httpCode, $meta->proxitokMsg, $meta->proxitokCode, $meta->response));
    }

    public static function showText(int $code, string $msg) {
        http_response_code($code);
        Wrappers::latte('error', new ErrorTemplate($code, $msg, null, null));
    }
}
