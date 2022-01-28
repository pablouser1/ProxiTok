<?php

/**@var Bramus\Router\Router $router */

use Helpers\Following;
use Helpers\Misc;
use Views\Models\FollowingTemplate;

// Showing
$router->get('/following', function () {
    $users = Following::getUsers();
    $feed = Following::getAll($users);
    $latte = Misc::latte();
    $latte->render(Misc::getView('following'), new FollowingTemplate($users, $feed));
});
