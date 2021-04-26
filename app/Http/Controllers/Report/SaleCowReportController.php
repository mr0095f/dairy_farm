<?php

namespace App\Http\Controllers\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SaleCow;
use Validator;
use Response;
use Session;
use DB;

class SaleCowReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['date_from'] = $data['date_to'] = date('m/d/Y');
        $date_from = $date_to = date('Y-m-d');
        $data['allData'] = SaleCow::where('cow_sale.branch_id', Session::get('branch_id'))
                            ->whereBetween('cow_sale.date', [$date_from, $date_to])
                            ->get();
        return view('reports.sale-cow-report', $data);
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
        //
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
    public function destroy($id)
    {
        //
    }

    public function cowSaleReportSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'date_from' => 'required',
                    'date_to' => 'required',
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

        
        if (!empty($request->date_from) && !empty($request->date_to)) {
            $date_from = date('Y-m-d', strtotime($request->date_from));
            $date_to = date('Y-m-d', strtotime($request->date_to));


            $data['allData']=SaleCow::where('cow_sale.branch_id', Session::get('branch_id'))
            ->whereBetween('cow_sale.date', [$date_from, $date_to])
            ->select('cow_sale.*')
            ->get();

            $data['date_from'] = $request->date_from;
            $data['date_to'] = $request->date_to;
			$data['hasData'] = true;
			
        }else{
            Session::flash('flash_message','Please Enter Date From and Date To');
            return redirect()->back()->with('status_color','success');
        }
        
        return view('reports.sale-cow-report', $data);
    }
}
