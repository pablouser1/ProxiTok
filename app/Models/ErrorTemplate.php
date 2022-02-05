<?php
namespace App\Models;

class ErrorTemplate extends BaseTemplate {
    public object $error;

    function __construct(object $error) {
        parent::__construct('Error');
        $this->error = $error;
    }
}
