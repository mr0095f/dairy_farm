<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CollectMilk;
use App\Models\SaleMilk;
use App\Models\MilkDueCollections;
use App\Models\Supplier;
use Validator;
use Session;
use DB;
use Auth;
use Response;

class SaleMilkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['allData'] = SaleMilk::leftJoin('users', 'users.id', 'sale_milk.added_by')
							->leftJoin('users_type', 'users_type.id','users.user_type')
							->where('sale_milk.branch_id', Session::get('branch_id'))
							->select('sale_milk.*', 'users.name as sold_by','users_type.user_type')
                            ->orderBy('sale_milk.id', 'desc')->paginate(40);
							
        $data['milkData'] = CollectMilk::where('branch_id', Session::get('branch_id'))
                           ->orderBy('date', 'desc')->get();
						   
        $data['supplierArr'] = Supplier::where('branch_id', Session::get('branch_id'))
                              ->orderBy('name', 'asc')->get();
							   
        return view('sale-milk.list', $data);
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
                    'milk_account_number' => 'required',
                    'name' => 'required',
                    'litter' => 'required',
                    'rate' => 'required',
                    'total_amount' => 'required',
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
            $objInsert = SaleMilk::create($input);
			if($objInsert->id){
				//insert data into due payment table
				$payment = array();
				$payment['sale_id'] = $objInsert->id;
				$payment['date'] = date('Y-m-d');
				$payment['pay_amount'] = $input['paid'];
				MilkDueCollections::create($payment);
			}
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            if(isset($input['save'])){
				Session::flash('flash_message','Save Information Successfully.');
            	return redirect()->back()->with('status_color','success');
			} else {
				Session::flash('flash_message','Save Information Successfully.');
            	return redirect('sale-milk-invoice/'.$objInsert->id)->with('status_color','success');	
			}
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
        $data = SaleMilk::findOrFail($id);
        $validator = Validator::make($request->all(), [
                    'milk_account_number' => 'required',
                    'name' => 'required',
                    'litter' => 'required',
                    'rate' => 'required',
                    'total_amount' => 'required',
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
        $data = SaleMilk::findOrFail($id);
        try{
            $bug=0;
            $delete = $data->delete();
			MilkDueCollections::where('sale_id', $id)->delete();
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
	
	public function getStockStatus(Request $request){
		$data = array();
		if($request->id){			
			$data = SaleMilk::Where('milk_account_number',$request->id)
				->where('sale_milk.branch_id', Session::get('branch_id'))
				->select([DB::raw("SUM(litter) as total_sold"), DB::raw("SUM(paid) as total_paid"), DB::raw("SUM(due) as total_due")])
				->groupBy('milk_account_number')
				->first();
			if(!empty($data)){
				$data = $data->toArray();
			}
		}
		return Response::json(array(
            'success' => true,
         	'data'   => $data
         )); 
		
	}
	
	public function printInvoice(Request $request){
		if(!empty($request->id)){
			//invoice create here
			$data['sale_paid_amount'] = 0;
			$data['sale_due_amount'] = 0;
			$data['single_data'] = SaleMilk::findOrFail($request->id);
			$data['sale_paid_amount'] = $data['single_data']->collectPayments()->sum('pay_amount');
			if(!empty($data['sale_paid_amount'])){
				$data['sale_due_amount'] = (float)$data['single_data']->total_amount - (float)$data['sale_paid_amount'];
			}
			return view('invoice.milk-sale', $data);
		} else {
			die('Invalid Request.');
		}
	}
}
