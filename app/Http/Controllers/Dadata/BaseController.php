<?php

namespace App\Http\Controllers\Dadata;

use App\Http\Controllers\Controller;
use App\Services\DadataServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

abstract class BaseController extends Controller
{
    protected $dadata;
    public function __construct(DadataServices $dadata)
    {
       $this->dadata = $dadata;
    }
}
