<?php
namespace Views\Models;

/**
* Exclusive for /following
*/
class FollowingTemplate extends FeedTemplate {
    public array $following;

    function __construct(array $following, object $feed) {
        parent::__construct('Following', $feed);
        $this->following = $following;
    }
}
