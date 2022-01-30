<?php
namespace App\Controllers;

use App\Helpers\Following;
use App\Helpers\Misc;
use App\Models\FollowingTemplate;

class FollowingController {
    static public function get() {
        $users = Following::getUsers();
        $feed = Following::getAll($users);
        $latte = Misc::latte();
        $latte->render(Misc::getView('following'), new FollowingTemplate($users, $feed));
    }
}
