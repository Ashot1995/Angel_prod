<?php


namespace App\Services;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class DadataServices
{
    private $headers;
    private $base_url;

    public function __construct() {
        $this->headers = Config::get('dadata.headers');
        $this->base_url= Config::get('dadata.base_url');
    }
    public function get ($address) {
//        dd(join('/', [$this->base_url, 'clean/address']));
        return Http::withHeaders($this->headers)
                ->post (join('/', [$this->base_url, 'clean/address']), [$address])
                ->json() [0];
    }
}
