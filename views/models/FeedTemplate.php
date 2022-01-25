<?php
namespace Views\Models;

/**
* Base for templates with a feed
*/
class FeedTemplate extends BaseTemplate {
    public object $feed;

    function __construct(string $title, object $feed) {
        parent::__construct($title);
        $this->feed = $feed;
    }
}
