<?php
namespace App\Models;
use TikScraper\Models\Response;

class ErrorTemplate extends BaseTemplate {
    public int $http_code = 502;
    public ?int $tiktok_code = -1;
    public string $msg = '';

    public ?Response $response = null;


    function __construct(int $http_code, string $msg, ?int $tiktok_code, ?Response $response) {
        parent::__construct('Error');
        $this->http_code = $http_code;
        $this->msg = $msg;
        $this->tiktok_code = $tiktok_code;
        $this->response = $response;
    }
}
