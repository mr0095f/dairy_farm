<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SaleCow;
use App\Models\SaleCowPayment;
use Validator;
use Response;
use Session;
use DB;

class SaleDueCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sale-cow.due-collect');
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

    public function getSaleHistory(Request $request)
    {
        $data['allData'] = SaleCow::join('cow_sale_payments', 'cow_sale_payments.sale_id', 'cow_sale.id')
        ->where('cow_sale.branch_id', Session::get('branch_id'))
        ->where('cow_sale.id', $request->invoice_id)
        ->select('cow_sale_payments.*', 'cow_sale.total_price', 'cow_sale.id as cow_sale_id')
        ->get();

        $data['invoice_id'] = $request->invoice_id;

        return view('sale-cow.due-collect', $data);
    }

    public function store(Request $request)
    {
        $input  = $request->all();
        $validator = Validator::make($request->all(), [
                    'date' => 'required',
                    'pay_amount' => 'required',
                ]);

        if($validator->fails()){
            Session::flash('flash_message','Please Fillup all Inputs.');
            return redirect()->back()->withErrors($validator)->withInput()->with('status_color','warning');
        }

        $input['date'] = date('Y-m-d', strtotime($request->date));

        $data = SaleCow::findOrFail($request->sale_id);
        //$updateArr['total_paid'] = $data->total_paid + $request->pay_amount;
        //$updateArr['due'] = $data->due - $request->pay_amount;

        try{
            $bug=0;
            //$data->update($updateArr);
            SaleCowPayment::create($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Due payment collected Successfully !');
            return redirect()->back()->with('status_color','success');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
		$input = $request->all();
		$data = SaleCowPayment::findOrFail($id);
		$data->delete();
		Session::flash('flash_message','Due Payment Record Successfully Deleted !');
        return redirect('get-sale-history?invoice_id=000'.$input['sale_id'])->with('status_color','danger');
    }
}
