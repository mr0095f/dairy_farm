<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Shed;
use App\Models\Animal;
use App\Models\Calf;
use App\Models\CowMonitor;
use App\Models\Vaccines;
use App\Models\CowVaccineMonitor;
use App\Models\CowVaccineMonitorDtls;
use App\Library\farm;
use Validator;
use Response;
use Session;
use DB;

class CowVaccineMonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata'] = CowVaccineMonitor::leftJoin('sheds', 'sheds.id', 'cow_vaccine_monitor.shed_no')
                            ->leftJoin('users', 'users.id','cow_vaccine_monitor.user_id')
							->leftJoin('users_type', 'users_type.id','users.user_type')
							->where('cow_vaccine_monitor.branch_id', Session::get('branch_id'))
                            ->select('cow_vaccine_monitor.*', 'sheds.shed_number','users.name','users_type.user_type')
                            ->paginate(50);
        return view('cow-vaccine-monitor.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['all_sheds'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        $data['vaccine_arr'] = Vaccines::orderBy('vaccine_name', 'asc')->get();
        return view('cow-vaccine-monitor.form', $data);
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
		$input['user_id'] = Auth::user()->id;
		
        try{
            $bug=0;
            $insert = CowVaccineMonitor::create($input);
            foreach($request->cow_vaccine as $value){
                if(isset($value['vaccine_id'])){
                    $value['monitor_id'] = $insert->id;
                    CowVaccineMonitorDtls::create($value);
                }
            }
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','New Data Successfully Saved !');
            return redirect('vaccine-monitor')->with('status_color','success');
        }else{
            echo $bug; die;
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
        $data['all_sheds'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        $data['vaccine_arr'] = Vaccines::orderBy('vaccine_name', 'asc')->get();
        $data['single_data'] = CowVaccineMonitor::findOrFail($id);
        $data['cowArr'] = Animal::where('branch_id', Session::get('branch_id'))
                            ->where('shade_no', $data['single_data']->shed_no)->get();
   
        return view('cow-vaccine-monitor.form', $data);
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
        $data = CowVaccineMonitor::findOrFail($id);
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
		$input['user_id'] = Auth::user()->id;
		
        try{
            $bug=0;
            $data->update($input);
            CowVaccineMonitorDtls::where('monitor_id', $data->id)->delete();
            foreach($request->cow_vaccine as $value){
                if(isset($value['vaccine_id'])){
                    $value['monitor_id'] = $data->id;
                    CowVaccineMonitorDtls::create($value);
                }
            }
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Updated !');
            return redirect('vaccine-monitor')->with('status_color','warning');
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
        $data = CowVaccineMonitor::findOrFail($id);
        try{
            $bug=0;
            $delete = $data->delete();
            CowVaccineMonitorDtls::where('monitor_id', $id)->delete();
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
	
	public function getVeccineStatus(Request $request){
		$vaccines = array();
		if($request->id){			
			$data =  Animal::where('id', $request->id)->first();
			if(!empty($data)){
				$vaccines = json_decode($data->vaccines, true);
			}
			
		}
		return Response::json(array(
            'success' => true,
         	'data'   => $vaccines
         )); 
		
	}
	
	public function getAnimalDetails(Request $request){
		if($request->id){			
			$data['vaccine_done_list'] = array();
			$data['vaccines'] = array();
			$data['single_data'] = 	Animal::leftJoin('animal_type', 'animal_type.id', 'animals.animal_type')
									->Where('animals.id',$request->id)
									->select('animals.*', 'animal_type.type_name')
									->first();
			
			if(!$data['single_data']){
				$data['single_data'] = Calf::leftJoin('animal_type', 'animal_type.id', 'calf.animal_type')
									->Where('calf.id',$request->id)
									->select('calf.*', 'animal_type.type_name')
									->first();
			}
			
			$data['cow_score'] = CowMonitor::Where('cow_id',$request->id)->orderBy('id', 'desc')->first();
			
			$vaccine_done = CowVaccineMonitor::leftJoin('users','users.id','cow_vaccine_monitor.user_id')
							->leftJoin('users_type', 'users_type.id','users.user_type')
							->Where('cow_id',$request->id)
							->select('cow_vaccine_monitor.*','users.name','users_type.user_type')
							->orderBy('date', 'desc')
							->get();
			
			foreach($vaccine_done as $vaccine){
				$vaccine_list = CowVaccineMonitorDtls::join('vaccines','vaccines.id','cow_vaccine_monitor_dtls.vaccine_id')
								->Where('cow_vaccine_monitor_dtls.monitor_id',$vaccine->id)
								->orderBy('cow_vaccine_monitor_dtls.id', 'asc')
								->select('cow_vaccine_monitor_dtls.*', 'vaccines.vaccine_name')
								->get();
				foreach($vaccine_list as $vl){
					$data['vaccine_done_list'][] = array(
						'id' 			=> $vl->id,
						'monitor_id' 	=> $vl->monitor_id,
						'vaccine_id' 	=> $vl->vaccine_id ,
						'remarks' 		=> $vl->remarks,
						'time' 			=> $vl->time
					);
				}
				$data['vaccines'][$vaccine->date] = array(
					'name'				=> $vaccine->name,
					'user_type'			=> $vaccine->user_type,
					'list' 				=> $vaccine_list
				);
			}
			
			//vaccines auto calculate
			$age = farm::animalAge($data['single_data']->DOB);
			$days_of_age = $age['day'];
			$data['vaccine_pending'] = array();
			$data['vaccinesCollection'] = Vaccines::orderBy('vaccine_name', 'asc')->get();			
			
			foreach($data['vaccinesCollection'] as $vc){
				$vaccine_id = $vc->id;
				if((bool)$vc->repeat_vaccine){
					//repeat vaccine
					$vaccine_days = (int)$vc->months;
					$repeat_times = floor((float)$days_of_age  / (float)$vaccine_days);
					$vaccine_done_times = 0;
					foreach($data['vaccine_done_list'] as $vcdl){
						if($vcdl['vaccine_id'] == $vc->id){
							$vaccine_done_times += 1;
						}
					}
					if($vaccine_done_times != $repeat_times){
						array_push($data['vaccine_pending'], $vc);	
					}
				} else {
					if((int)$days_of_age >= (int)$vc->months){
						//one time vaccine only
						$done = false;
						foreach($data['vaccine_done_list'] as $vcdl){
							if($vcdl['vaccine_id'] == $vc->id){
								$done = true;
								break;
							}
						}
						if(!$done){
							array_push($data['vaccine_pending'], $vc);	
						}
					}
				}
			}						
			return view('cow-vaccine-monitor.ajax-animal', $data);
		} else {
			return '';
		}
	}
}
