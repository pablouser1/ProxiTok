<?php
namespace Helpers;

class Following {
    static public function getUsers (): array {
        $following_string = Settings::get('following');
        if ($following_string) {
            return explode(',', $following_string);
        }
        return [];
    }

    static public function getAll (array $users): object {
        $allowed_items_total = isset($_GET['max']) && is_numeric($_GET['max']) && $_GET['max'] <= 100 ? $_GET['max'] : 20;
        $items = [];
        if (count($users) !== 0) {
            $api = Misc::api();
            $max_items_per_user = $allowed_items_total / count($users);
            foreach ($users as $user) {
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
        return $feed;
    }
};
