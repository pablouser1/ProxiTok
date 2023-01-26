<?php
namespace App\Models;

use TikScraper\Models\Discover;

class DiscoverTemplate extends BaseTemplate {
    public Discover $data;

    function __construct(Discover $data) {
        parent::__construct("Discover");
        $this->data = $data;
    }
}
