<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Shed;
use App\Models\Calf;
use App\Models\Animal;
use App\Models\SaleCow;
use App\Models\SaleCowDtls;
use App\Models\SaleCowPayment;
use Validator;
use Response;
use Session;
use DB;

class SaleCowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['allData'] = SaleCow::where('branch_id', Session::get('branch_id'))->orderBy('date', 'desc')->paginate(50);
        return view('sale-cow.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sale-cow.form');
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
                    'sale_date' => 'required',
                    'customer_name' => 'required',
                    'customer_number' => 'required',
                    'total_price' => 'required',
                ]);

        if($validator->fails()){
            Session::flash('flash_message','Please Fillup all Inputs.');
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');
        }

        $input['date'] = date('Y-m-d', strtotime($request->sale_date));
        $input['branch_id'] = Session::get('branch_id');

        try{
            $bug=0;
            $insert= SaleCow::create($input);
            
            foreach($input['cowdtls'] as $dataDtls){
                $saleDtls = $dataDtls;
                $saleDtls['sale_id'] = $insert->id;
                SaleCowDtls::create($saleDtls);

                if($saleDtls['cow_type']==1){
                    Animal::where('id', $saleDtls['cow_id'])->update(['sale_status'=>1]);
                }else{
                    Calf::where('id', $saleDtls['cow_id'])->update(['sale_status'=>1]);
                }

                Shed::where('id', $saleDtls['shed_no'])->update(['status'=>0]);
                
            }

            $saleAmountDtls['sale_id'] = $insert->id;
            $saleAmountDtls['date'] = $input['date'];
            $saleAmountDtls['pay_amount'] = $input['total_paid'];
            SaleCowPayment::create($saleAmountDtls);
            
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','New data Successfully Saved !');
            return redirect('sale-cow')->with('status_color','success');
        }else{
            Session::flash('flash_message','Something Error Found !');
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
        $data['single_data'] = SaleCow::findOrFail($id);
        return view('sale-cow.form', $data);
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
        $data = SaleCow::findOrFail($id);
        $input  = $request->all();
        $validator = Validator::make($request->all(), [
                    'sale_date' => 'required',
                    'customer_name' => 'required',
                    'customer_number' => 'required',
                    'total_price' => 'required',
                ]);

        if($validator->fails()){
            Session::flash('flash_message','Please Fillup all Inputs.');
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');
        }

        $input['date'] = date('Y-m-d', strtotime($request->sale_date));

        try{
            $bug=0;
            $data->update($input);
            
            //Delete Old One
            $oldSaleDtls = SaleCowDtls::where('sale_id', $id)->get();
            foreach($oldSaleDtls as $oldSaleDtlsData){
                if($oldSaleDtlsData->cow_type==1){
                    Animal::where('id', $oldSaleDtlsData->cow_id)->update(['sale_status'=>0]);
                }else{
                    Calf::where('id', $oldSaleDtlsData->cow_id)->update(['sale_status'=>0]);
                }
                Shed::where('id', $oldSaleDtlsData->shed_no)->update(['status'=>1]);

            }
            SaleCowDtls::where('sale_id', $id)->delete();
            // Create New Row             
            foreach($input['cowdtls'] as $dataDtls){
                $saleDtls = $dataDtls;
                $saleDtls['sale_id'] = $data->id;
                SaleCowDtls::create($saleDtls);
                if($saleDtls['cow_type']==1){
                    Animal::where('id', $saleDtls['cow_id'])->update(['sale_status'=>1]);
                }else{
                    Calf::where('id', $saleDtls['cow_id'])->update(['sale_status'=>1]);
                }
                Shed::where('id', $saleDtls['shed_no'])->update(['status'=>0]);
            }
            
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','New data Successfully Saved !');
            return redirect('sale-cow')->with('status_color','success');
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
        $data = SaleCow::findOrFail($id);
        try{
            $bug=0;
            $saledtls = SaleCowDtls::where('sale_id', $id)->get();
            foreach($saledtls as $saledtlsData){
                if($saledtlsData['cow_type']==1){
                    Animal::where('id', $saledtlsData['cow_id'])->update(['sale_status'=>0]);
                }else{
                    Calf::where('id', $saledtlsData['cow_id'])->update(['sale_status'=>0]);
                }
                Shed::where('id', $saledtlsData['sale_id'])->update(['status'=>0]);
            }
            SaleCowPayment::where('sale_id', $id)->delete();            
            $data->delete();
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

    public function loadCowCalf(Request $request)
    {
        if($request->cowtype==1){
            $data = Animal::leftJoin('sheds', 'sheds.id', 'animals.shade_no')
                    ->where('animals.branch_id', Session::get('branch_id'))
                    ->where('animals.sale_status', 0)
                    ->select('animals.*', 'sheds.shed_number')->get();
        }else{
            $data = Calf::leftJoin('sheds', 'sheds.id', 'calf.shade_no')
                    ->where('calf.branch_id', Session::get('branch_id'))
                    ->where('calf.sale_status', 0)
                    ->select('calf.*', 'sheds.shed_number')->get();
        }

        foreach($data as $info){
            if(!empty($info->pictures) && file_exists("storage/app/public/uploads/animal/".explode('_', $info->pictures)[0])){
                $info->pictures="storage/app/public/uploads/animal/".trim(explode('_', $info->pictures)[0]);
            }
            else{
                $info->pictures = 'public/custom/img/noImage.jpg';
            }
        }
        return Response::json($data);
    }
	
	public function printInvoice(Request $request){
		if(!empty($request->id)){
			//invoice create here
			$data['single_data'] = SaleCow::findOrFail($request->id);
			return view('invoice.sale', $data);
		} else {
			die('Invalid Request.');
		}
	}
}
