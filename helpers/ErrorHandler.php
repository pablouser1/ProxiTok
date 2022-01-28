<?php
namespace Helpers;

class ErrorHandler {
    static public function show(object $meta) {
        http_response_code($meta->http_code);
        $latte = Misc::latte();
        $latte->render(Misc::getView('error'), ['error' => $meta]);
    }
}
