<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\UserType;
use App\User;
use Validator;
use Response;
use Session;
use Hash;
use Auth;
use DB;

class HumanResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['allData'] = User::where('users.user_type', '!=', 1)
                            ->leftJoin('designations', 'designations.id', 'users.designation')
                            ->leftJoin('users_type', 'users_type.id', 'users.user_type')
                            ->where('users.branch_id', Session::get('branch_id'))
                            ->select('users.*', 'designations.name as designation_name', 'users_type.user_type as user_type_name')
                            ->orderBy('users.name', 'asc')
                            ->paginate(25);
        return view('humanResource.staffList', $data);
        
    }

    public function userList()
    {
        $data['allData'] = User::where('users.user_type', '!=', 1)
                            ->leftJoin('designations', 'designations.id', 'users.designation')
                            ->leftJoin('users_type', 'users_type.id', 'users.user_type')
                            ->where('users.user_type', '>', 0)
                            ->where('users.branch_id', Session::get('branch_id'))
                            ->select('users.*', 'designations.name as designation_name', 'users_type.user_type as user_type_name')
                            ->orderBy('users.name', 'asc')
                            ->paginate(25);
        return view('humanResource.userList', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['designations'] = Designation::orderBy('name', 'asc')->get();
        $data['user_types'] = UserType::where('id', '!=', 1)->orderBy('user_type', 'asc')
                              ->get();
        return view('humanResource.humanResourceForm', $data);
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
                    'name' => 'required',
                    'email' => 'required',
                    'designation' => 'required|not_in:0',
                    'phone_number' => 'required', 
                    'present_address' => 'required',
                    'basic_salary' => 'required',
                    'gross_salary' => 'required',
                    'joining_date' => 'required',
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
            
        if ($request->hasFile('image')) {
              $photo=$request->file('image');
              $fileType=$photo->getClientOriginalExtension();
              $fileName=rand(1,1000).date('dmyhis').".".$fileType;
              $photo->move('storage/app/public/uploads/human-resource', $fileName);
              $input['image']=$fileName;
        }

        if($request->password !=''){
            $input['password']=bcrypt($request['password']);
            $input['password_hint'] = $request['password'];
        }

        $input['created_by'] = Auth::User()->id;
        $input['status'] = 1;
        $input['branch_id'] = Session::get('branch_id');
        $input['nid'] = !empty($request['nid'])?$request['nid']:null;
        $input['joining_date'] = date('y-m-d', strtotime($input['joining_date']));
        
        if(!empty($input['resign_date'])){
            $input['resign_date'] = date('y-m-d', strtotime($input['resign_date']));
        }

        try{
          $bug=0;
          $insert= User::create($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Information Successfully Added.');
            return redirect()->back()->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found.');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function updateStatus(Request $request){
        $data = User::findOrFail($request->id);
        $input = array();
        $input['status'] = $request->status;
        $data->update($input);
        $msg = array('Status Enable Successfully','Status Disable Successfully');
        return Response::json($msg);
        die;
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
        $data['editData'] = User::findOrfail($id);
        $data['designations'] = Designation::orderBy('name', 'asc')->get();
        $data['user_types'] = UserType::where('id', '!=', 1)->orderBy('user_type', 'asc')
                              ->get();
        return view('humanResource.humanResourceForm', $data);
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
        $data = User::findOrfail($id);
        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required',
                    'designation' => 'required|not_in:0',
                    'phone_number' => 'required', 
                    'present_address' => 'required',
                    'basic_salary' => 'required',
                    'gross_salary' => 'required',
                    'joining_date' => 'required',
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

        if ($request->hasFile('image')) {
            $photo=$request->file('image');
            $fileType=$photo->getClientOriginalExtension();
            $fileName=rand(1,1000).date('dmyhis').".".$fileType;
            $photo->move('storage/app/public/uploads/human-resource', $fileName);
            $input['image']=$fileName;

            $img_path='storage/app/public/uploads/human-resource/'.$data['image'];
            if($data['image']!=null and file_exists($img_path)){
                   unlink($img_path);
            }
        }else{
            $input['image'] = $data->image;
        }

        if($request->password !=''){
            $input['password']=bcrypt($request['password']);
            $input['password_hint'] = $request['password'];
        }else{
          $input['password'] = $data->password;
          $input['password_hint'] = $data->password_hint;
        }

        $input['nid'] = !empty($request['nid'])?$request['nid']:null;
        $input['joining_date'] = date('y-m-d', strtotime($input['joining_date']));
        if(!empty($input['resign_date'])){
            $input['resign_date'] = date('y-m-d', strtotime($input['resign_date']));
        }

        try{
          $bug=0;
          $data->update($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Information Successfully Updated !');
            return redirect()->back()->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found.');
            return redirect()->back()->with('status_color','danger');
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
        $data = User::findOrFail($id);
        $img_path='storage/app/public/uploads/human-resource/'.$data['image'];
        if($data['image']!=null and file_exists($img_path)){
           unlink($img_path);
        }
        
        try{
          $bug=0;
          $action = $data->delete();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }
        else{
            Session::flash('flash_message','Something Error Found.');
            return redirect()->back()->with('status_color','danger');
        }
    }
}
