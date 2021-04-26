<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CollectMilk;
use App\Models\SaleMilk;
use App\Models\MilkDueCollections;
use Validator;
use Response;
use Session;
use DB;

class MilkSaleDueCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sale-milk.due-collect');
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
		$data['allData'] = SaleMilk::join('milk_due_collections', 'milk_due_collections.sale_id', 'sale_milk.id')
        ->where('sale_milk.branch_id', Session::get('branch_id'))
        ->where('sale_milk.id', $request->invoice_id)
        ->select('milk_due_collections.*', 'sale_milk.total_amount')
        ->get();

        $data['invoice_id'] = $request->invoice_id;

        return view('sale-milk.due-collect', $data);
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
        try{
            $bug=0;
            MilkDueCollections::create($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }
        if($bug==0){
            Session::flash('flash_message','Due Payment Collected Successfully !');
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
		$data = MilkDueCollections::findOrFail($id);
		$data->delete();
		Session::flash('flash_message','Due Payment Record Successfully Deleted !');
        return redirect('get-milk-sale-history?invoice_id=000'.$input['sale_id'])->with('status_color','danger');
    }
}
