<?php
namespace Helpers;

class Following {
    static public function get (): array {
        $following_string = Settings::get('following');
        if ($following_string) {
            return explode(',', $following_string);
        }
        return [];
    }
};
