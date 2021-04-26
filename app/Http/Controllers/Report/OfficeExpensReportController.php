<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExpensePurpose;
use App\Models\Expense;
use Session;
use DB;
use PDF;

class OfficeExpensReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.office-expense-report');
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
       
        if(empty(trim($request->date_from)) && empty(trim($request->date_to))){
            Session::flash('flash_message','Please Fillup date field.');
            return redirect()->back()->with('status_color','warning');
        }

        if(empty(trim($request->date_from)) && !empty(trim($request->date_to))){
            Session::flash('flash_message','You can\'t give Date To field without Date From field.');
            return redirect()->back()->with('status_color','warning');
        }

        if(!empty(trim($request->date_from)) && !empty(trim($request->date_to))){
            $dateFrom = date('Y-m-d',strtotime($request->date_from));
            $dateTo = date('Y-m-d',strtotime($request->date_to));
            if($dateFrom > $dateTo){
                Session::flash('flash_message','Date From can\'t be bigger than Date To.');
                return redirect()->back()->with('status_color','warning');
            }
        }

        $dateFrom = date('Y-m-d',strtotime($request->date_from));
        if($request->date_to !=''){
            $dateTo = date('Y-m-d',strtotime($request->date_to));
        }else{
           $dateTo = ''; 
        }

        if($dateFrom !='' && $dateTo !=''){
            $data['alldata'] =  Expense::leftJoin('expense_purpose', 'expense_purpose.id', 'expenses.purpose_id')
                                ->whereBetween('expenses.date', [$dateFrom, $dateTo])
                                ->select('expenses.*', 'expense_purpose.purpose_name')
                                ->orderBy('expenses.date', 'asc')
                                ->get();

            $data['date_from'] = $request->date_from;
            $data['date_to'] = $request->date_to;
        }else{
            $data['alldata'] = Expense::leftJoin('expense_purpose', 'expense_purpose.id', 'expenses.purpose_id')
                                ->where('expenses.date', $dateFrom)
                                ->select('expenses.*', 'expense_purpose.purpose_name')
                                ->orderBy('expenses.date', 'asc')
                                ->get();

            $data['date_from'] = $request->date_from;
        }

        $data['getJsonArr'] = json_decode(json_encode($data['alldata']),True);
        $data['hasData'] = 1;
        return view('reports.office-expense-report', $data);
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
