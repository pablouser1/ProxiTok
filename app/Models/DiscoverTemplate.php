<?php
namespace App\Models;

use TikScraper\Models\Discover;

/**
* Base for templates with a feed
*/
class DiscoverTemplate extends BaseTemplate {
    public Discover $feed;

    function __construct(Discover $feed) {
        parent::__construct('Discover');
        $this->feed = $feed;
    }
}
