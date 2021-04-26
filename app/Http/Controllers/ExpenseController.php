<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Session;
use App\Models\ExpensePurpose;
use App\Models\Expense;
use Auth;
class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allPurpose = ExpensePurpose::where('branch_id', Session::get('branch_id'))->get();
        $allData = Expense::leftJoin('expense_purpose','expenses.purpose_id','expense_purpose.id')
                    ->leftJoin('users','expenses.created_by','users.id')
                    ->leftJoin('users_type', 'users_type.id','users.user_type')
					->where('expense_purpose.branch_id', Session::get('branch_id'))
                    ->select('expenses.*','users.name as created_by','expense_purpose.purpose_name','users_type.user_type')
                    ->orderBy('id', 'DESC')
					->paginate(20);
        return view('expenses.expense-list',compact('allPurpose','allData'));
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
       $validator = Validator::make($request->all(), [
                    'purpose_id' => 'required',
                    'date' => 'required',
                    'amount' => 'required',
                ]);

        if($validator->fails()){
            $plainErrorText = "";
            $errorMessage = json_decode($validator->messages(), True);
            foreach ($errorMessage as $value) { 
                $plainErrorText .= $value[0].". ";
            }
            Session::flash('flash_message', $plainErrorText);
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');;
        }
                
        $input = $request->all();
        $input['date'] = date('Y-m-d',strtotime($request->date));
        $input['created_by'] = Auth::user()->id;
        
        try{
            $bug=0;
            Expense::create($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Expense Successfully Added.');
            return redirect('expense-list')->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found.');
            return redirect('expense-list')->with('status_color','danger');
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
        $data=Expense::findOrFail($id);
        $validator = Validator::make($request->all(), [
                    'purpose_id' => 'required',
                    'date' => 'required',
                    'amount' => 'required',
                ]);

        if($validator->fails()){
            $plainErrorText = "";
            $errorMessage = json_decode($validator->messages(), True);
            foreach ($errorMessage as $value) { 
                $plainErrorText .= $value[0].". ";
            }
            Session::flash('flash_message', $plainErrorText);
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');;
        }
                
        $input = $request->all();
        $input['date'] = date('Y-m-d',strtotime($request->date));
        try{
            $bug=0;
            $data->update($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Expense Successfully Updated.');
            return redirect('expense-list')->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found.');
            return redirect('expense-list')->with('status_color','danger');
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
        $data = Expense::findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Expense Successfully Deleted.');
            return redirect('expense-list')->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found.');
            return redirect('expense-list')->with('status_color','danger');
        }
    }
}
