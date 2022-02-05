<?php
namespace App\Models;

/**
* Exclusive for /
*/
class HomeTemplate extends BaseTemplate {
    public array $forms = [
        [
            'title' => 'Search by user',
            'input' => 'user',
            'placeholder' => 'Type username'
        ],
        [
            'title' => 'Search by video ID',
            'input' => 'video',
            'placeholder' => 'Type video ID'
        ],
        [
            'title' => 'Search by tag',
            'input' => 'tag',
            'placeholder' => 'Type tag'
        ],
        [
            'title' => 'Search by music ID',
            'input' => 'music',
            'placeholder' => 'Type music'
        ]
    ];

    function __construct() {
        parent::__construct('Home');
    }
}
