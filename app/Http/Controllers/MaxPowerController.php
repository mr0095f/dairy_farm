<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MaxPower;
use DB;
use App\Library\farm;
use Validator;
use Session;
use Response;

class MaxPowerController extends Controller
{

    public function MaxPowerAction(Request $request)
    {
        $data = array();
		$validator = Validator::make($request->all(), [
         	'website_url' => 'required',
			'purchase_key' => 'required',
			'email' => 'required'
        ]);
        if($validator->fails()){
			$data = array('hasError'=>true, 'MSG'=>'Validation Required Error.');
        } 
		$input = $request->all();
		$response = farm::verifyPurchaseKey($input['email'],$input['website_url'],$input['purchase_key']);
		if(!empty($response)){
			if($response['code'] == '200'){
				$input['last_check_date'] = date('Y-m-d');
				MaxPower::create($input);
				$data = array('hasError'=>false, 'MSG'=>'Your purchase key activated successfully');
			} else if($response['code'] == '202'){
				$data = array('hasError'=>true, 'MSG'=>'Already installed so you cannot continue, please contact with application owner.');
			} else {
				$data = array('hasError'=>true, 'MSG'=>$response['code']);
			}
		} else {
			$data = array('hasError'=>true, 'MSG'=>'Invalid purchase key.');
		}
		return Response::json($data);
    }
	
	public function MaxAutoPowerAction()
    {
        $data = array();
		$result = MaxPower::first();
		if(!$result){
			$data = array('hasError'=>true, 'MSG'=>'Invalid active user');
		} else {
			if(!empty($result->last_check_date)){
				$now = strtotime(date('Y-m-d H:i:s'));
				$check_time = strtotime($result->last_check_date);
				$datediff =  $now - $check_time;
				$days = round($datediff / (60 * 60 * 24));
				if((int)$days > 7){
					$response = farm::verifyPurchaseKey($result->email, url(''), $result->purchase_key);
					if($response['code'] == '202'){
						if($response['domain']==url('')){
							$data = array('hasError'=>false, 'MSG'=>'Valid Domain');
						} else {
							DB::table('tbl_max_power')->delete();
							$data = array('hasError'=>true, 'MSG'=>'Invalid Domain');
						}
					}
				} else {
					$data = array('hasError'=>false, 'MSG'=>'Valid Domain');
				}
			} else {
				$data = array('hasError'=>true, 'MSG'=>'Invalid active user');
			}
		}
		return Response::json($data);
    }
	
}
