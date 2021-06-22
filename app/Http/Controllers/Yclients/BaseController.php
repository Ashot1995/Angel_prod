<?php

namespace App\Http\Controllers\Yclients;

use App\Http\Controllers\Controller;
use App\Services\PaypoolServices;
use App\Services\YclientsService;

abstract class BaseController extends Controller
{
    protected $yclients;
    protected $paypool;

    public function __construct(YclientsService $yclients, PaypoolServices $paypool){
        $this->yclients = $yclients;
        $this->paypool = $paypool;
    }
}
