<?php
namespace App\Helpers;

use App\Models\ErrorTemplate;

class ErrorHandler {
    static public function show(object $meta) {
        http_response_code($meta->http_code);
        $latte = Misc::latte();
        $latte->render(Misc::getView('error'), new ErrorTemplate($meta));
    }
}
