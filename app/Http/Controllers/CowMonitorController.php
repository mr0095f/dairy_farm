<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Shed;
use App\Models\Animal;
use App\Models\Calf;
use App\Models\MonitoringService;
use App\Models\CowMonitor;
use App\Models\CowMonitorDtls;
use App\Models\Vaccines;
use App\Models\CowVaccineMonitor;
use App\Models\CowVaccineMonitorDtls;
use App\Library\farm;
use Validator;
use Response;
use Session;
use DB;
use Auth;

class CowMonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata'] = CowMonitor::leftJoin('sheds', 'sheds.id', 'cow_monitor.shed_no')
                            ->leftJoin('users', 'users.id','cow_monitor.user_id')
							->leftJoin('users_type', 'users_type.id','users.user_type')
							->where('cow_monitor.branch_id', Session::get('branch_id'))
                            ->select('cow_monitor.*', 'sheds.shed_number','users.name','users_type.user_type')
                            ->paginate(20);
        return view('cow-monitor.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['all_sheds'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        $data['service_arr'] = MonitoringService::orderBy('service_name', 'asc')->get();
        return view('cow-monitor.form', $data);
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
		$input['user_id'] = Auth::user()->id;
		$input['milk'] = !empty($input['milk']) ? $input['milk'] : '0.00';
		$input['date'] = date('y-m-d', strtotime($input['date']));
		
		if($request->hasfile('animal_image')) {
            $all_images = "";
            foreach($request->file('animal_image') as $image){
                $name=$image->getClientOriginalExtension();
                $fileName=rand(1,1000).date('dmyhis').".".$name;
                $all_images .=$fileName."_";  
            }
            $input['new_images'] = chop($all_images, '_');
        }
		
        $message = '';
		try{
            $bug=0;
            $insert = CowMonitor::create($input);
			if($request->hasfile('animal_image')){
                $index = 0;
                $imageArr = explode('_', $insert->new_images);
                foreach($request->file('animal_image') as $image){
                    $image->move('storage/app/public/uploads/animal/', $imageArr[$index]);
                    $index++;
                }
            }
            foreach($request->cow_service as $value){
                if(isset($value['service_id'])){
                    $value['monitor_id'] = $insert->id;
                    CowMonitorDtls::create($value);
                }
            }
        }catch(\Exception $e){
            $message = $e->getMessage();
			$bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','New Data Successfully Saved !');
            return redirect('cow-monitor')->with('status_color','success');
        }else{
            Session::flash('flash_message',$message);
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
        $data['service_arr'] = MonitoringService::orderBy('service_name', 'asc')->get();
        $data['single_data'] = CowMonitor::findOrFail($id);
        $data['cowArr'] = Animal::where('branch_id', Session::get('branch_id'))
        ->where('shade_no', $data['single_data']->shed_no)->get();
        return view('cow-monitor.form', $data);
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
        $data = CowMonitor::findOrFail($id);
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
		
		$input['user_id'] = Auth::user()->id;
        $input['branch_id'] = Session::get('branch_id');
		$input['date'] = date('y-m-d', strtotime($input['date']));
		$input['milk'] = !empty($input['milk']) ? $input['milk'] : '0.00';
		
		
		//updated images
		$newImages = [];
        if($request->hasfile('animal_image')){
            $all_images = "";
            foreach($request->file('animal_image') as $image){
                $name=$image->getClientOriginalExtension();
                $fileName=rand(1,1000).date('dmyhis').".".$name;
                $newImages[] = $fileName;
                $all_images .=$fileName."_";  
            }
            $input['new_images'] = chop($all_images, '_');
        }else{
            $input['new_images']="";
        }
		
		$needDeleteImages = [];
        if($data->new_images){
            if(isset($input['exitesPreviousImage'])){
                $needDeleteImages = array_diff(explode('_', $data->new_images),$input['exitesPreviousImage']);
                $input['new_images']= implode('_', $input['exitesPreviousImage'])."_".$input['new_images'];
                $input['new_images'] = chop($input['new_images'], '_');
            }else{
                $needDeleteImages = explode('_', $data->pictures);
            }
        }
		
        try{
            $bug=0;
            $data->update($input);
            CowMonitorDtls::where('monitor_id', $data->id)->delete();
            foreach($request->cow_service as $value){
                if(isset($value['service_id'])){
                    $value['monitor_id'] = $data->id;
                    CowMonitorDtls::create($value);
                }
            }
			
			if($request->hasfile('animal_image')){
                $index = 0;
                foreach($request->file('animal_image') as $image){
                    $image->move('storage/app/public/uploads/animal/', $newImages[$index]);
                    $index++;
                }
            }
            if(count($needDeleteImages)>0){
                foreach ($needDeleteImages as $deleteImage) {
                $img_path='storage/app/public/uploads/animal/'.$deleteImage;
                    if(file_exists($img_path)){
                    unlink($img_path);
                    } 
                }
            }
			
			
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Data Successfully Updated !');
            return redirect('cow-monitor')->with('status_color','warning');
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
        $data = CowMonitor::findOrFail($id);
        try{
            $bug=0;
            $delete = $data->delete();
            CowMonitorDtls::where('monitor_id', $id)->delete();
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
			
			$vaccine_done = CowVaccineMonitor::Where('cow_id',$request->id)->orderBy('date', 'desc')->get();
			
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
					'list' => $vaccine_list
				);
			}
			
			//last five monitoring result
			$data['monitors'] = array();
			$monitor_done = CowMonitor::leftJoin('users','users.id','cow_monitor.user_id')
							->leftJoin('users_type', 'users_type.id','users.user_type')
							->Where('cow_monitor.cow_id',$request->id)
							->orderBy('cow_monitor.date', 'desc')
							->select('cow_monitor.*','users.name','users_type.user_type')
							->take(5)
							->get();
			foreach($monitor_done as $md){
				$monitor_list = CowMonitorDtls::join('monitoring_services','monitoring_services.id','cow_monitor_dtls.service_id')
								->Where('cow_monitor_dtls.monitor_id',$md->id)
								->orderBy('cow_monitor_dtls.id', 'asc')
								->select('cow_monitor_dtls.*', 'monitoring_services.service_name')
								->get();
				$data['monitors'][] = array(
					'name'				=> $md->name,
					'user_type'			=> $md->user_type,
					'date'				=> $md->date,
					'note'				=> $md->note,
					'weight'			=> $md->weight,
					'height'			=> $md->height,
					'milk'				=> $md->milk,
					'health_score'		=> $md->health_score,
					'user_id'			=> $md->user_id,
					'list' 				=> $monitor_list
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
			return view('cow-monitor.ajax-animal', $data);
		} else {
			return '';
		}
	}
}
