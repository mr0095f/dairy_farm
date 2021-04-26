<?php

namespace App\library {
 	use Auth;
 	use DB;
 	use URL;
	use Response;
 	use Session;
	use Carbon\Carbon;
	use App\Models\SystemControl;
	use App\Models\Branch;
	use App\Models\MaxPower;
	
	class farm {
		
		protected $systemConfig;
		
		protected $branchDetails;
		
		public function __construct() {
        	$this->systemConfig = $this->get_system_configuration('system_config');
			if(!empty(Session::get('branch_id'))){
				$this->branchDetails = Branch::where('id', Session::get('branch_id'))->first();
			}
    	}
		
		public static function get_system_configuration($key) {
			if(!empty($key)){
				$result = SystemControl::where('key','=',$key)->first();
				return json_decode($result->value);
			} else {
				return '';
			}
		}
		
		public static function get_system_configuration_json_data($key) {
			if(!empty($key)){
				$result = SystemControl::where('key','=', $key)->first();
				$data = json_decode($result->value, true);
				return json_encode($data);
			} else {
				return '';
			}
		}
		
		public static function respondWithJson($data){
    		$options = app('request')->header('accept-charset') == 'utf-8' ? JSON_UNESCAPED_UNICODE : null;
    		return response()->json($data, 200, $options);
		}
		
		public static function currency($price) {
			if($price ==''){$price='0.00';}
			$result = SystemControl::where('key','=','system_config')->first();
			if(!empty($result)){
				$config = json_decode($result->value);
				if(isset($config->currencyDisable)){
					return $price;
				} else {
					if(!empty($config->currencySymbol)){
						$price = number_format($price,2,$config->currencySeparator,",");
						if($config->currencyPosition=='left'){
							//left
							if(isset($config->currencySpace)){
								$price = $config->currencySymbol.' '.$price; //with space
							} else {
								$price = $config->currencySymbol.$price; //without space
							}
						} else {
							//right
							if(isset($config->currencySpace)){
								$price = $price.' '.$config->currencySymbol; //with space
							} else {
								$price = $price.' '.$config->currencySymbol; //without space
							}
						}
					}
				}
			}
			return $price;
		}
		
		//get branch details
		public static function branchInfo() {
			if(!empty(Session::get('branch_id'))){
				 return Branch::where('id', Session::get('branch_id'))->first();
			} else {
				return array();
			}
		}
		
		/*
		* Datetime picker date conversion
		*/
		public static function FormatCalenderDateToMySqlDate($date){ //m/d/y
			$str = explode('/',$date);
			return $str[2].'-'.$str[0].'-'.$str[1];
		}
		
		/*
		@Get animal live Age
		*/
		public static function animalAge($date){
			$days = (strtotime(date('Y-m-d')) - strtotime($date)) / (60 * 60 * 24);
			$months = number_format((float)$days / 30,2,".",".");
			return array('day'=>$days,'month'=>$months);
		}
		
		//animal age format
		public static function animalAgeFormat($date){
			$lang_day = 'Day';
			$lang_month = 'Month';
			$age = farm::animalAge($date);
			if($age['day'] > 0){
				$lang_day = 'Days';
			}
			if($age['month'] > 0){
				$lang_month = 'Months';
			}
			return $age['day'].' '.$lang_day.'  '.$age['month'].' '.$lang_month;
		}
		
		/*
		* @get Apox delivery date based on 283
		*/
		public static function appoxDeliveryDate($date){
			if(!empty($date)){
				$days = (strtotime(date('Y-m-d')) - strtotime($date)) / (60 * 60 * 24);
				$edd = date('Y-m-d', strtotime($date. ' + 283 days'));
				return array('days'=>$days,'edd'=>$edd);
			} else {
				return '';
			}
		}
		
		public static function verifyUserPKey(){
			$data = MaxPower::first();
			if(!$data){
				return 0;
			} else {
				return 1;
			}
		}
		
		/*
		* @verify purchase key
		*/
		public static function verifyPurchaseKey($email,$domain,$pk){
			if(!empty($pk)){
				$response = farm::callAPI('http://sakocart.com/api/api2.php', array('apikey'=>'b7aac11a-509a-22e8-9c2d-fa7ae01bbebc','email' => trim($email),'domain' => trim($domain),'pcode' =>trim($pk),'ip_address'=>$_SERVER['REMOTE_ADDR']));
				return $response;
			} else {
				return '';
			}
		}
		
		private static function callAPI($url, $data){
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response_json = curl_exec($ch);
			curl_close($ch);
			return json_decode($response_json, true);
		}
    }
}
?>