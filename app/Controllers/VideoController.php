<?php
namespace App\Controllers;

/**
 * @deprecated Please use UserController::video instead
 */
class VideoController {
    static public function get(string $video_id) {
        UserController::video('placeholder', $video_id);
    }
}
