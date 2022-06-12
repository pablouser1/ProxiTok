<?php
namespace App\Controllers;

class VideoController {
    static public function get(string $video_id) {
        UserController::video('placeholder', $video_id);
    }
}
