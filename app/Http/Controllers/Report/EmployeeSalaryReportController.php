<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Session;
use DB;

class EmployeeSalaryReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['employees'] = User::where('user_type', '!=', 1)->where('branch_id', Session::get('branch_id'))->get();
        return view('reports.employeeSalaryReport', $data);
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
        if($request->employee_id==0 && $request->month==0 && $request->year==0){
            Session::flash('flash_message','Please select at least one field !');
            return redirect()->back()->with('status_color','warning');
        }
        else{

            $query = 'select a.*, b.name, b.phone_number as phone_no, c.name as designation_name from employee_salary a, users b, designations c where a.employee_id=b.id and b.designation=c.id and b.branch_id='.Session::get('branch_id');

            if($request->month > 0){
                $query .=' and a.month='.$request->month; 
                $data['selected_month'] = $request->month;
            }

            if($request->year > 0){
                $query .=' and a.year='.$request->year; 
                $data['selected_year'] = $request->year;
            }

            if($request->employee_id > 0){
                $query .=' and a.employee_id='.$request->employee_id; 
                $data['selected_employee_id'] = $request->employee_id;
            }

            $query .= ' order by a.year desc, a.month asc, b.name asc';

            //echo $query; die;

            $data['result'] = DB::select($query);
            $data['employees'] = User::where('user_type', '!=', 1)->where('branch_id', Session::get('branch_id'))
                                 ->get();

            // echo "<pre>";
            // print_r($data['result']); die; 

            return view('reports.employeeSalaryReport', $data);
        }
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
