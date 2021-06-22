<?php


namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class PaypoolServices
{
    protected $base_url;
    protected $headers;
    public function __construct() {
        $this->base_url = Config::get('paypool.base_url');
        $this->headers = Config::get('paypool.headers');
    }
    public function createTranslateionUrl ($amount, $from_id) {

        $redirectSuccess = 'http://localhost:8080/';
        $redirectFail = 'http://localhost:8080/';

        return Http::withHeaders(array_merge(
            $this->headers,
            [
                'User-id' => $from_id,
            ]
        ))
        ->get($this->base_url.'?direct=true&amount='.$amount
            . '&redirectSuccess='.$redirectSuccess
            .'&redirectFail='.$redirectFail);
    }
}
