<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shed;
use App\Models\CollectMilk;
use App\Models\Animal;
use Session;
use DB;

class MilkCollectReportControlller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['shedArr'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        return view('reports.milk-collect-report', $data);
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
        $data['shedArr'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        
        $data['date_from'] = !empty($request->date_from) ? $request->date_from : '';
        $data['date_to'] = !empty($request->date_to) ? $request->date_to : '';
		$data['shed_no'] = !empty($request->shed_no) ? $request->shed_no : '';
		$data['dairy_no'] = !empty($request->dairy_no) ? $request->dairy_no : '';

        $dateFrom = !empty($request->date_from) ? date('Y-m-d',strtotime($request->date_from)) : '';
        $dateTo = !empty($request->date_to) ? date('Y-m-d',strtotime($request->date_to)) : '';

        $sqlBuilder = '';
		
        if(!empty($request->shed_no)){
            $sqlBuilder .="collect_milk.stall_no=".$request->shed_no." and ";
        }
        if(!empty($request->dairy_no)){
            $sqlBuilder .="collect_milk.account_number=".$request->dairy_no." and ";
        }
        
		$sqlBuilder .="collect_milk.branch_id=".Session::get('branch_id');

        $data['alldata'] = CollectMilk::leftJoin('animals', 'animals.id', 'collect_milk.dairy_number')
                ->leftJoin('sheds', 'sheds.id', 'collect_milk.stall_no')
                //->where('collect_milk.branch_id', Session::get('branch_id'))
                ->whereBetween('collect_milk.date', [$dateFrom, $dateTo])
                ->where(DB::Raw($sqlBuilder), 1)
                ->select('sheds.shed_number', 'collect_milk.*')
                ->get();
		
        $data['getJsonArr'] = json_decode(json_encode($data['alldata']),True);
        $data['hasData'] = 1;
        return view('reports.milk-collect-report', $data);
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
