<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Branch;
use Validator;
use Response;
use Session;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata'] = Branch::orderBy('branch_name','asc')->paginate(10);
        return view('branch.branchList', $data);
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
        $input  = $request->all();
        $validator = Validator::make($request->all(), [
                    'branch_name' => 'required',
                    'builders_name' => 'required',
                    'branch_address' => 'required',
                    'email' => 'required|email',
                    'setup_date' => 'required',
                    'phone_number' => 'required'
                ]);

        if($validator->fails()){
            Session::flash('flash_message','Please Fillup all Valid Inputs.');
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');
        }

        $input['setup_date'] = date('Y-m-d', strtotime($input['setup_date']));
        $input['status'] = 1;

        try{
            $bug=0;
            $insert= Branch::create($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','New Branch Successfully Added !');
            return redirect('branch')->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect('branch')->with('status_color','danger');
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
        $data=Branch::findOrFail($id);
        $validator = Validator::make($request->all(), [
                    'branch_name' => 'required',
                    'builders_name' => 'required',
                    'branch_address' => 'required',
                    'email' => 'required|email',
                    'setup_date' => 'required',
                    'phone_number' => 'required'
                ]);

        if($validator->fails()){
            Session::flash('flash_message','Please Fillup all Valid Inputs.');
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');;
        }

        $input=$request->all();
        $input['setup_date'] = date('Y-m-d', strtotime($input['setup_date']));

        try{
            $bug=0;
            $data->update($input);
        }catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Branch Information Successfully Updated !');
            return redirect('branch')->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found.');
            return redirect('branch')->with('status_color','danger');
        }
    }


    public function updateStatus(Request $request)
    {
        $data = Branch::findOrFail($request->id);
        $input = array();
        $input['status'] = $request->status;
        $data->update($input);
        $msg = array('Status Enable Successfully','Status Disable Successfully');
        return Response::json($msg);
        die;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Branch::findOrFail($id);

        try{
            $bug=0;
            $delete = $data->delete();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Branch Successfully Deleted !');
            return redirect('branch')->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

}
