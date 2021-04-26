<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Session;
use App\Models\ExpensePurpose;
class ExpensePurposeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allData = ExpensePurpose::where('branch_id', Session::get('branch_id'))
                   ->orderBy('id','desc')->paginate(15);
        return view('expenses.purposes',compact('allData'));
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
                    'purpose_name' => 'required',
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
        $input['branch_id'] = Session::get('branch_id');
        
        try{
            $bug=0;
            $insert= ExpensePurpose::create($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Purpose Successfully Added !');
            return redirect('expense-purpose')->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect('expense-purpose')->with('status_color','danger');
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
        $data=ExpensePurpose::findOrFail($id);
        $validator = Validator::make($request->all(), [
                    'purpose_name' => 'required',
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
        try{
            $bug=0;
            $data->update($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Purpose Successfully Updated !');
            return redirect('expense-purpose')->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect('expense-purpose')->with('status_color','danger');
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
        $data = ExpensePurpose::findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Purpose Successfully Deleted !');
            return redirect('expense-purpose')->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect('expense-purpose')->with('status_color','danger');
        }
    }
}
