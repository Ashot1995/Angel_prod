<?php

namespace App\Http\Controllers\Yclients;

use App\Http\Controllers\Controller;
use App\Services\YclientsService;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->yclients->getCompanyList()
            ->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->yclients->getCompanyById($id)
            ->json();
    }
}
