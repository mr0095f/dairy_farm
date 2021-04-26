<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\User;
use App\Models\EmployeeSalary;
use DB;
use Session;
use Auth;
use Validator;
class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $salaryList = EmployeeSalary::leftJoin('users','employee_salary.employee_id','users.id')
                                    ->where('users.branch_id', Session::get('branch_id'))
                                    ->select('employee_salary.*','users.name as employee_name','users.image')
                                    ->paginate(10);
        return view('employee-salary.salary-list',compact('salaryList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allEmployee = User::where('user_type', '!=', 1)
                       ->where('users.branch_id', Session::get('branch_id'))
                       ->get();
        return view('employee-salary.employee-salary',compact('allEmployee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'paydate' => 'required',
                    'employee_id' => 'required',
                    'year' => 'required',
                    'month' => 'required',
                    'salary' => 'required',
                ]);

        if($validator->fails()){
            $plainErrorText = "";
            $errorMessage = json_decode($validator->messages(), True);
            foreach ($errorMessage as $value) { 
                $plainErrorText .= $value[0].". ";
            }
            Session::flash('flash_message', $plainErrorText);
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');
        }
                
        $input = $request->all();
        $input['paydate'] = date('Y-m-d', strtotime($input['paydate']));

        try{
            $bug=0;
            $insert= EmployeeSalary::create($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Employee Successfully Added.');
            return redirect('employee-salary')->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found.');
            return redirect('employee-salary')->with('status_color','danger');
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
        $allEmployee = User::where('user_type', '!=', 1)
                        ->where('users.branch_id', Session::get('branch_id'))
                        ->get();
        $employeeSalary = EmployeeSalary::findOrFail($id);
        return view('employee-salary.employee-salary',compact('allEmployee','employeeSalary'));
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
        $data=EmployeeSalary::findOrFail($id);

        $validator = Validator::make($request->all(), [
                    'paydate' => 'required',
                    'employee_id' => 'required',
                    'year' => 'required',
                    'month' => 'required',
                    'salary' => 'required',
                ]);

        if($validator->fails()){
            Session::flash('flash_message','Please Fillup all Valid Inputs.');
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');
        }

        $input=$request->all();
        $input['paydate'] = date('Y-m-d', strtotime($input['paydate']));

        try{
            $bug=0;
            $data->update($input);
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Employee Salary Successfully Updated.');
            return redirect('employee-salary')->with('status_color','warning');
        }
        else{
            Session::flash('flash_message','Something Error Found.');
            return redirect('employee-salary')->with('status_color','danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = EmployeeSalary::findOrFail($id);

        try{
            $bug=0;
            $delete = $data->delete();
        }
        catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect('employee-salary')->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}
