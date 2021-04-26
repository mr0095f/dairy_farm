<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\CollectMilk;
use App\Models\Shed;
use Validator;
use Session;
use Response;
use DB;
use Auth;

class CollectMilkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$data['allData'] = CollectMilk::leftJoin('sheds', 'sheds.id', 'collect_milk.stall_no')
							->leftJoin('users', 'users.id', 'collect_milk.added_by')
							->leftJoin('users_type', 'users_type.id','users.user_type')
							->where('collect_milk.branch_id', Session::get('branch_id'))
                           	->select('collect_milk.*', 'sheds.shed_number as shed_number', 'users.name as added_name','users_type.user_type')
							->orderBy('collect_milk.date', 'desc')->paginate(40);
							
        $data['all_sheds'] = Shed::where('branch_id', Session::get('branch_id'))->get();
		return view('collect-milk.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$data['all_sheds'] = Shed::where('branch_id', Session::get('branch_id'))->get();
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
                    'account_number' => 'required',
                    'name' => 'required',
                    'dairy_number' => 'required',
                    'liter' => 'required',
                    'liter_price' => 'required',
                    'total' => 'required',
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
        $input['date'] = date('Y-m-d');
        $input['branch_id'] = Session::get('branch_id');
		$input['added_by'] = Auth::user()->id;
        
        try{
            $bug=0;
            CollectMilk::create($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Added.');
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
		$data['all_sheds'] = Shed::where('branch_id', Session::get('branch_id'))->get();
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
        $data = CollectMilk::findOrFail($id);
        $validator = Validator::make($request->all(), [
                    'account_number' => 'required',
                    'name' => 'required',
                    'dairy_number' => 'required',
                    'liter' => 'required',
                    'liter_price' => 'required',
                    'total' => 'required',
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
            Session::flash('flash_message','Data Successfully Updated.');
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
        $data = CollectMilk::findOrFail($id);
        try{
            $bug=0;
            $delete = $data->delete();
        }
        catch(\Exception $e)
        {
            $bug=$e->errorInfo[1];
        }

        if($bug==0){

            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');

        }else{

            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
	
	public function getAnimalDetails(Request $request){
		$animal = array();
		if($request->id){			
			$data =  Animal::where('shade_no', $request->id)->get();
			if(!empty($data)){
				$animal = json_decode($data, true);
			}
			
		}
		return Response::json(array(
            'success' => true,
         	'data'   => $animal
         )); 
		
	}
}
