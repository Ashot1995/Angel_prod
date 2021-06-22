<?php

namespace App\Http\Controllers\Yclients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingDateController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($company_id)
    {
        return $this->yclients->getBookDates($company_id)
            ->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $date
     * @param  string  $company_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show(string $company_id, string $date)
    {
        $staff = $this->yclients->getCompanyStaffs($company_id)
            ->json()['data'][0] ?? null;

        if (!$staff) return response()->json([
            'success' => true,
            'date' => [],
            'meta' => []
        ]);

        return $this->yclients->bookTimeForDate($company_id, $staff['id'], $date)
            ->json();
    }
}
