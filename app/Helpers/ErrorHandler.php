<?php
namespace App\Helpers;

use App\Models\ErrorTemplate;
use TikScraper\Models\Meta;

class ErrorHandler {
    static public function show(Meta $meta) {
        http_response_code($meta->http_code);
        $latte = Wrappers::latte();
        $latte->render(Misc::getView('error'), new ErrorTemplate($meta));
    }
}
