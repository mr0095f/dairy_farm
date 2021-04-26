<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SystemControl;
use Validator;
use Response;
use Session;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$data['alldata'] = SystemControl::where('key', 'system_config')->first();
		if(!empty($data['alldata'])){
			$data['config_data'] = json_decode($data['alldata']->value);
		}
        return view('settings.index', $data);
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
        try{
			if(!empty($request->config)){
				$logo = '';
				$super_admin_logo = '';
				
				$data = SystemControl::where('key', 'system_config')->first();
				if(!empty($data)){
					$config_data = json_decode($data->value);
					if(isset($config_data)){
						$logo = $config_data->logo;
					}
					if(isset($super_admin_logo)){
						$super_admin_logo = $config_data->super_admin_logo;
					}
					$data->delete();
				}
				//insert
				if ($request->hasFile('system-logo')) {
					$photo=$request->file('system-logo');
					$fileType=$photo->getClientOriginalExtension();
					$fileName=rand(1,1000).date('dmyhis').".".$fileType;
					$logo=$fileName;
					$photo->move('storage/app/public/uploads', $fileName );
            	}
				if ($request->hasFile('super_admin_logo')) {
					$photo=$request->file('super_admin_logo');
					$fileType=$photo->getClientOriginalExtension();
					$fileName=rand(1,1000).date('dmyhis').".".$fileType;
					$super_admin_logo=$fileName;
					$photo->move('storage/app/public/uploads', $fileName );
            	}
				$_request = $request->config;
				$_request['logo'] = $logo;
				$_request['super_admin_logo'] = $super_admin_logo;
				$request->merge(array('config'=>$_request));
				//$request->request->add(['logo' => $logo]);
				$input = array();
				$input['key'] = 'system_config';
				$input['value'] = json_encode($request->config);
				$input['status'] = 1;
				$insert= SystemControl::create($input);
				Session::flash('flash_message','System Configuration Saved Successfully');
				return redirect('system')->with('status_color','success');
			} else {
				die('Opps Something wrong here');
			}
		}catch(\Exception $e){
			echo $e->getMessage();
			die();
		}
    }


    public function updateSystemConfiguration(Request $request)
    {
        $data = SystemControl::where('key', $request->id)->firstOrFail();
        $input = array();
        //$input['status'] = $request->status;
        $data->update($input);
        $msg = array('System Updated Successfully');
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
    }

}
