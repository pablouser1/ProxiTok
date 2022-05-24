<?php
namespace App\Models;

use TikScraper\Models\Full;

/**
* Base for templates with both info and feed
*/
class FullTemplate extends BaseTemplate {
    public Full $data;

    function __construct(string $title, Full $data) {
        parent::__construct($title);
        $this->data = $data;
    }
}
