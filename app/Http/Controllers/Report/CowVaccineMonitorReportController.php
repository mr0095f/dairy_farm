<?php

namespace App\Http\Controllers\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shed;
use App\Models\Animal;
use App\Models\Vaccines;
use App\Models\CowVaccineMonitor;
use App\Models\CowVaccineMonitorDtls;
use Validator;
use Response;
use Session;
use DB;

class CowVaccineMonitorReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['shedArr'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        return view('reports.vaccine-monitor-report', $data);
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
        $data['shedArr'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        
        $data['date_from'] = $request->date_from;
        $data['date_to'] = $request->date_to;

        $dateFrom = date('Y-m-d',strtotime($request->date_from));
        $dateTo = date('Y-m-d',strtotime($request->date_to));

        $sql = '';
        if($request->shed_no > 0){
            $sql .="sheds.id=".$request->shed_no." and ";
            $data['shed_no'] = $request->shed_no;
        }

        if(!empty($request->dairy_no)){
            $sql .="cow_vaccine_monitor.cow_id=".$request->dairy_no." and ";
            $data['dairy_no'] = $request->dairy_no;
        }

        $sql .='1';

        $data['alldata'] = CowVaccineMonitor::leftJoin('sheds', 'sheds.id', 'cow_vaccine_monitor.shed_no')
                ->where('cow_vaccine_monitor.branch_id', Session::get('branch_id'))
                ->whereBetween('cow_vaccine_monitor.date', [$dateFrom, $dateTo])
                ->where(DB::Raw($sql), 1)
                ->select('sheds.shed_number', 'cow_vaccine_monitor.*')
                ->get();

        $data['getJsonArr'] = json_decode(json_encode($data['alldata']),True);
        $data['hasData'] = 1;
        return view('reports.vaccine-monitor-report', $data);
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

    public function vaccineWiseMonitoringReport()
    {
        $data['shedArr'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        $data['vaccine_arr'] = Vaccines::orderBy('vaccine_name', 'asc')->get();
        return view('reports.vaccine-wise-monitoring-report', $data);
    }

    public function getVaccineWiseMonitoringReport(Request $request)
    {
        $data['shedArr'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        $data['vaccine_arr'] = Vaccines::orderBy('vaccine_name', 'asc')->get();
        
        $data['date_from'] = $request->date_from;
        $data['date_to'] = $request->date_to;
        $data['vaccine_id'] = $request->vaccine_id;

        $sql = '';
        if($request->shed_no > 0){
            $sql .="sheds.id=".$request->shed_no." and ";
            $data['shed_no'] = $request->shed_no;
        }
        $sql .='1';
        
        $data['alldata'] = Animal::leftJoin('sheds', 'sheds.id', 'animals.shade_no')
                            ->where('animals.branch_id', Session::get('branch_id'))
                            ->where(DB::Raw($sql), 1)
                            ->select('sheds.shed_number', 'animals.*')
                            ->get();

        $data['getJsonArr'] = json_decode(json_encode($data['alldata']),True);
        $data['hasData'] = 1;
        return view('reports.vaccine-wise-monitoring-report', $data);
    }
}
