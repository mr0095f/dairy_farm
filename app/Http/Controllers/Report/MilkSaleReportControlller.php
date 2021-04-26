<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SaleMilk;
use App\Models\Supplier;
use Session;
use DB;

class MilkSaleReportControlller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.milk-sale-report');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['date_from'] = $request->date_from;
        $data['date_to'] = $request->date_to;

        $dateFrom = date('Y-m-d',strtotime($request->date_from));
        $dateTo = date('Y-m-d',strtotime($request->date_to));

        $sql = '';
        if(!empty($request->account_number)){
            $sql .="sale_milk.milk_account_number=".$request->account_number." and ";
            $data['account_number'] = $request->account_number;
        }
        $sql .='1';

        $data['alldata'] = SaleMilk::where('sale_milk.branch_id', Session::get('branch_id'))
                ->whereBetween('sale_milk.date', [$dateFrom, $dateTo])
                ->where(DB::Raw($sql), 1)
                ->get();

        $data['getJsonArr'] = json_decode(json_encode($data['alldata']),True);
        $data['hasData'] = 1;
        return view('reports.milk-sale-report', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
