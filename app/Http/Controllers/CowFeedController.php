<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Shed;
use App\Models\Animal;
use App\Models\Calf;
use App\Models\FoodUnit;
use App\Models\FoodItem;
use App\Models\CowFeed;
use App\Models\CowFeedDtls;
use Validator;
use Response;
use Session;

class CowFeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata'] = CowFeed::leftJoin('sheds', 'sheds.id', 'cow_feed.shed_no')
                            ->where('cow_feed.branch_id', Session::get('branch_id'))
                            ->select('cow_feed.*', 'sheds.shed_number')
                            ->orderBy('shed_no', 'ASC')
							->paginate(40);
        return view('cow-feed.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['all_sheds'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        $data['food_items'] = FoodItem::orderBy('name', 'asc')->get();
        $data['food_units'] = FoodUnit::orderBy('name', 'asc')->get();
        return view('cow-feed.form', $data);
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
                    'shed_no' => 'required|not_in:0',
                    'cow_id' => 'required',
                    'date' => 'required',
                ]);

        if($validator->fails()){
            Session::flash('flash_message','Please Fillup all Inputs.');
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');
        }

        $input['branch_id'] = Session::get('branch_id');
		$input['date'] = date('y-m-d', strtotime($input['date']));

        $message = '';
		try{
            $bug=0;
            $insert = CowFeed::create($input);
            foreach($request->cow_feed as $value){
            if(isset($value['item_id'])){
                $value['feed_id'] = $insert->id;
                CowFeedDtls::create($value);
            }
        }
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
			$message = $e->getMessage();
        }

        if($bug==0){
            Session::flash('flash_message','New Data Successfully Saved !');
            return redirect('cow-feed')->with('status_color','success');
        }else{
            Session::flash('flash_message',$message);
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function loadCow(Request $request)
    {
        $data = Animal::where('branch_id', Session::get('branch_id'))
        ->where('shade_no', $request->shed_no)
		->where('sale_status', 0)
		->get();
		
		if($data->isEmpty()){
			$data = Calf::where('branch_id', Session::get('branch_id'))
       				->where('shade_no', $request->shed_no)
					->where('sale_status', 0)
					->get();
					
		}
        return Response::json($data);
    }
	
	public function loadCowReport(Request $request)
    {
        $data = Animal::where('branch_id', Session::get('branch_id'))
        ->where('shade_no', $request->shed_no)
		->get();
		
		if($data->isEmpty()){
			$data = Calf::where('branch_id', Session::get('branch_id'))
       				->where('shade_no', $request->shed_no)
					->get();
					
		}
		
		
        return Response::json($data);
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
        $data['all_sheds'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        $data['food_items'] = FoodItem::orderBy('name', 'asc')->get();
        $data['food_units'] = FoodUnit::orderBy('name', 'asc')->get();
        $data['single_data'] = CowFeed::findOrFail($id);
        $data['cowArr'] = Animal::where('branch_id', Session::get('branch_id'))
        ->where('shade_no', $data['single_data']->shed_no)->get();
        return view('cow-feed.form', $data);
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
        $data = CowFeed::findOrFail($id);
        $input  = $request->all();
        $validator = Validator::make($request->all(), [
                    'shed_no' => 'required|not_in:0',
                    'cow_id' => 'required',
                    'date' => 'required',
                ]);

        if($validator->fails()){
            Session::flash('flash_message','Please Fillup all Inputs.');
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');
        }

        $input['branch_id'] = Session::get('branch_id');
		$input['date'] = date('y-m-d', strtotime($input['date']));

        try{
            $bug=0;
            $data->update($input);
            CowFeedDtls::where('feed_id', $data->id)->delete();
            foreach($request->cow_feed as $value){
                if(isset($value['item_id'])){
                    $value['feed_id'] = $data->id;
                    CowFeedDtls::create($value);
                }
            }
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Updated !');
            return redirect('cow-feed')->with('status_color','warning');
        }else{
            Session::flash('flash_message','Something Error Found !');
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
        $data = CowFeed::findOrFail($id);
        try{
            $bug=0;
            $delete = $data->delete();
            CowFeedDtls::where('feed_id', $id)->delete();
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
}
