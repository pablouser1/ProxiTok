<?php
namespace App\Models;

/**
* Base for all templates, needs a Title to set
*/
class BaseTemplate {
    public string $title;

    function __construct(string $title) {
        $this->title = $title;
    }
}
