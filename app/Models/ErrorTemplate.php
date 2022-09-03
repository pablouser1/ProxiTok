<?php
namespace App\Models;

class ErrorTemplate extends BaseTemplate {
    public int $http_code = 502;
    public ?int $tiktok_code = -1;
    public string $msg = '';


    function __construct(int $http_code, string $msg, ?int $tiktok_code = null) {
        parent::__construct('Error');
        $this->http_code = $http_code;
        $this->msg = $msg;
        $this->tiktok_code = $tiktok_code;
    }
}
