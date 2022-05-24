<?php
namespace App\Models;

/**
* Base for templates with a feed
*/
class FeedTemplate extends BaseTemplate {
    public object $data;

    function __construct(string $title, object $feed) {
        parent::__construct($title);
        $this->data = (object) [
            'feed' => $feed
        ];
    }
}
