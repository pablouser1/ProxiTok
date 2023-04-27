<?php
namespace App\Controllers;

class VideoController {
    public static function get(string $video_id) {
        UserController::video('placeholder', $video_id);
    }
}
