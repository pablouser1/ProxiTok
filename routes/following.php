<?php
use Helpers\Following;
use Helpers\Misc;
use Steampixel\Route;

// Showing
Route::add('/following', function () {
    $allowed_items_total = isset($_GET['max']) && is_numeric($_GET['max']) && $_GET['max'] <= 100 ? $_GET['max'] : 20;
    $following = Following::get();
    $items = [];
    if (count($following) !== 0) {
        $api = Misc::api();
        $max_items_per_user = $allowed_items_total / count($following);
        foreach ($following as $user) {
            $user_feed = $api->getUserFeed($user);
            if ($user_feed) {
                $max = count($user_feed->items) > $max_items_per_user ? $max_items_per_user : count($user_feed->items);
                for ($i = 0; $i < $max; $i++) {
                    $item = $user_feed->items[$i];
                    array_push($items, $item);
                }
            }
        }
    }

    $feed = (object) [
        'items' => $items,
        'hasMore' => false
    ];
    $latte = Misc::latte();
    $latte->render(Misc::getView('following'), ['following' => $following, 'feed' => $feed]);
});
