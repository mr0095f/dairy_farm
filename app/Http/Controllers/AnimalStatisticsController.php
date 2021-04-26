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
use App\Models\PregnancyRecord;
use App\Models\PregnancyType;
use App\Models\CowFeed;
use App\Models\CowFeedDtls;
use Validator;
use Response;
use Session;
use DB;
use Auth;

class AnimalStatisticsController extends Controller
{
    public function index()
    {
        $data['all_sheds'] = Shed::where('branch_id', Session::get('branch_id'))->get();
        return view('animal-statistics.index', $data);
    }
	
	public function getAnimalDetails(Request $request){
		if($request->id){			
			
			//get all pregnancy record
			$data['pregnancy_records'] = PregnancyRecord::join('sheds', 'sheds.id', 'pregnancy_record.stall_no')
										->join('animals', 'animals.id', 'pregnancy_record.cow_id')
										->join('pregnancy_type', 'pregnancy_type.id', 'pregnancy_record.pregnancy_type_id')
										->join('animal_type', 'animal_type.id', 'pregnancy_record.semen_type')
										->Where('pregnancy_record.cow_id',$request->id)
										->orderBy('pregnancy_record.id', 'desc')
										->select('pregnancy_record.*','sheds.shed_number','pregnancy_type.type_name','animal_type.type_name as aTypeName')
										->get();
			
			
			$data['calf_list'] = Calf::join('sheds', 'sheds.id', 'calf.shade_no')
								->join('animal_type', 'animal_type.id', 'calf.animal_type')
								->where('calf.animal_id', $request->id)
								->orderBy('calf.id','desc')
								->select('calf.*','sheds.shed_number','animal_type.type_name')
								->get();
			
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
			
			
			
			if(!empty($data['single_data']->shade_no)){
				$data['feed_chart'] = CowFeed::where('branch_id', Session::get('branch_id'))->where('cow_id', $request->id)->first();
				if(!empty($data['feed_chart']->id)){
					$data['feed_chart_details'] = DB::table('cow_feed_dtls')
                                            ->leftJoin('food_items', 'food_items.id', 'cow_feed_dtls.item_id')
                                            ->leftJoin('food_units', 'food_units.id', 'cow_feed_dtls.unit_id')
                                            ->where('feed_id', $data['feed_chart']->id)
                                            ->select('food_items.name as item_name', 'food_units.name as unit_name', 'cow_feed_dtls.qty', 'cow_feed_dtls.time')
                                            ->get();
					
					
				}
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
						'vaccine_id' 	=> $vl->vaccine_id,
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
							->whereYear('cow_monitor.date', '=', date('Y'))
							->orderBy('cow_monitor.date', 'ASC')
							->select('cow_monitor.*','users.name','users_type.user_type')
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
			
			$data['chart_data'] = $this->_getHealthChartData($data['monitors']);
			
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
			return view('animal-statistics.ajax-animal', $data);
		} else {
			return '';
		}
	}
	
	private function _getHealthChartData($data){
		$graphArray = array(0,0,0,0,0,0,0,0,0,0,0,0);
		$WeightArray = array(0,0,0,0,0,0,0,0,0,0,0,0);
		$heightArray = array(0,0,0,0,0,0,0,0,0,0,0,0);
		$milkArray = array(0,0,0,0,0,0,0,0,0,0,0,0);
		
		$sumScore = 0;
		$weightScore = 0;
		$heightScore = 0;
		$milk = 0;
		$monthVal = 0;
		$total_monitor = 0;
		
		if(!empty($data)){
			foreach($data as $d){
				$month = (int)date('m', strtotime($d['date']));
				if($monthVal == $month){
					$sumScore += (float)$d['health_score'];
					$weightScore += (float)$d['weight'];
					$heightScore += (float)$d['height'];
					$milk += (float)$d['milk'];
					$total_monitor += 1;
				} else {
					if(!empty($monthVal)){
						$graphArray[$monthVal] = (float)$sumScore / (int)$total_monitor;
						$WeightArray[$monthVal] = (float)$weightScore / (int)$total_monitor;
						$heightArray[$monthVal] = (float)$heightScore / (int)$total_monitor;
						$sumScore = (float)$d['health_score'];
						$weightScore = (float)$d['weight'];
						$heightScore = (float)$d['height'];
						$milk = (float)$d['milk'];
						$total_monitor = 1;
						$monthVal = $month;
					} else {
						$sumScore = (float)$d['health_score'];
						$weightScore = (float)$d['weight'];
						$heightScore = (float)$d['height'];
						$milk = (float)$d['milk'];
						$total_monitor = 1;
						$monthVal = $month;
					}
				}
			}
			if(!empty($sumScore)){
				$graphArray[$monthVal] = (float)$sumScore / (int)$total_monitor;
			}
			if(!empty($weightScore)){
				$WeightArray[$monthVal] = (float)$weightScore / (int)$total_monitor;
			}
			if(!empty($weightScore)){
				$heightArray[$monthVal] = (float)$heightScore / (int)$total_monitor;
			}
			if(!empty($milkArray)){
				$milkArray[$monthVal] = (float)$milk / (int)$total_monitor;
			}
		}
		return array($graphArray, $WeightArray, $heightArray, $milkArray);
	}
}
