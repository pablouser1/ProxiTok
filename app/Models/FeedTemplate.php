<?php
namespace App\Models;

use TikScraper\Models\Feed;

/**
* Base for templates with a feed
*/
class FeedTemplate extends BaseTemplate {
    public Feed $feed;

    function __construct(string $title, Feed $feed) {
        parent::__construct($title);
        $this->feed = $feed;
    }
}
