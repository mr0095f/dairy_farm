<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserType;
use App\User;
use Validator;
use Session;
use Auth;
use DB;
use Hash;
use Response;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata'] = UserType::where('id', '!=', 1)->get();
        return view('userType.index', $data);
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
                    'user_type' => 'required',
                ]);
        
        if ($validator->fails()) {
            Session::flash('flash_message','User Type is required !');
            return redirect()->back()->with('status_color','warning');
        }
        $input['user_type'] = $request->user_type;

        if(!isset($request->useraccess)){
            $input['user_role'] = null;
        }else{
            $input['user_role'] = json_encode($request->useraccess);
        }

        DB::beginTransaction();
        try{
            $result=0;
            UserType::create($input);
            DB::commit();
        }catch(\Exception $e){
            $result = $e->errorInfo[1];
            DB::rollback();
        }

        if($result==0){
            Session::flash('flash_message','User Type Successfully Created !');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found.');
            return redirect()->back()->with('status_color','danger');
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
        $data= UserType::findOrFail($id);
        $validator = Validator::make($request->all(), [
                    'user_type' => 'required',
                ]);
        
        if ($validator->fails()) {
            Session::flash('flash_message','User Type is required !');
            return redirect()->back()->with('status_color','warning');
        }
        $input['user_type'] = $request->user_type;

        if(!isset($request->useraccess)){
            $input['user_role'] = null;
        }else{
            $input['user_role'] = json_encode($request->useraccess);
        }

        DB::beginTransaction();
        try{
            $result=0;
            $data->update($input);
            DB::commit();
        }catch(\Exception $e){
            $result = $e->errorInfo[1];
            DB::rollback();
        }

        if($result==0){
            Session::flash('flash_message','Informations Successfully Updated !');
            return redirect()->back()->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found.');
            return redirect()->back()->with('status_color','danger');
        }
    }
	
	public function updateProfile(Request $request){
        $profile = array();
        $profile['id'] = $request->id;
        $profile['name'] = $request->name;
        $profile['exist_password'] = $request->exist_password;
        $profile['old_password'] = $request->old_password;
        $profile['password'] = $request->password;
        $data = User::findOrFail($profile['id']);
         
        if($profile['password']){
            if (Hash::check($profile['exist_password'], $data->password)) {
                $profile['password'] = bcrypt($profile['password']);
            }else{
                $msg = array('Old password does not match, please give correct password !','red');
                return Response::json($msg);
                die;
            }
        }else{
            $profile['password'] = $profile['old_password'];
        }
        $data->update($profile);
        $msg = array('Profile Successfully Updated !','green');
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
        //
    }
}
