<?php
namespace Helpers;

class Error {
    static public function show(object $meta) {
        $http_code = $meta->http_code;
        http_response_code($http_code);

        $latte = Misc::latte();
        $latte->render(Misc::getView('error'), ['error' => $meta]);
    }
}
