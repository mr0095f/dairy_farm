<?php
namespace App\library{
	use App\Models\UserType;
	use Auth;
	class UserRoleWiseAccess
	{

	    public static function controllerMethods()
	    {
	        $controllerAccessArr = array( 
	        	'AnimalController' => array(
	        		'index' => __('user_role.admin_controller_index'),
	        		'create' => __('user_role.admin_controller_create'),
	        		'store' => __('user_role.admin_controller_store'),
	        		'edit' => __('user_role.admin_controller_edit'),
	        		'update' => __('user_role.admin_controller_update'),
	        		'destroy' => __('user_role.admin_controller_destroy'),
	        	),
	        	'AnimalTypeController' => array(
	        		'index' => __('user_role.animal_type_controller_index'),
	        		'store' => __('user_role.animal_type_controller_store'),
	        		'update' => __('user_role.animal_type_controller_update'),
	        		'destroy' => __('user_role.animal_type_controller_destroy'),
	        	),
	        	'BranchController' => array(
	        		'index' => __('user_role.branch_controller_index'),
	        		'store' => __('user_role.branch_controller_store'),
	        		'update' => __('user_role.branch_controller_update'),
	        		'destroy' => __('user_role.branch_controller_destroy'),
	        		'updateStatus' => __('user_role.branch_controller_updateStatus'),
	        	),
	        	'CalfController' => array(
	        		'index' => __('user_role.calf_controller_index'),
	        		'create' => __('user_role.calf_controller_create'),
	        		'store' => __('user_role.calf_controller_store'),
	        		'edit' => __('user_role.calf_controller_edit'),
	        		'update' => __('user_role.calf_controller_update'),
	        		'destroy' => __('user_role.calf_controller_destroy'),
	        	),
	        	'CollectMilkController' => array(
	        		'index' => __('user_role.collect_milk_controller_index'),
	        		'store' => __('user_role.collect_milk_controller_store'),
	        		'update' => __('user_role.collect_milk_controller_update'),
	        		'destroy' => __('user_role.collect_milk_controller_destroy'),
	        	),
	        	'ColorController' => array(
	        		'index' => __('user_role.ColorControllerIndex'),
	        		'store' => __('user_role.ColorControllerStore'),
	        		'update' => __('user_role.ColorControllerUpdate'),
	        		'destroy' => __('user_role.ColorControllerDestroy'),
	        	),
	        	'CowFeedController' => array(
	        		'index' => __('user_role.CowFeedControllerIndex'),
	        		'create' => __('user_role.CowFeedControllerCreate'),
	        		'store' => __('user_role.CowFeedControllerStore'),
	        		'edit' => __('user_role.CowFeedControllerEdit'),
	        		'update' => __('user_role.CowFeedControllerUpdate'),
	        		'destroy' => __('user_role.CowFeedControllerDestroy'),
	        	),
	        	'CowMonitorController' => array(
	        		'index' => __('user_role.CowMonitorControllerIndex'),
	        		'create' => __('user_role.CowMonitorControllerCreate'),
	        		'store' => __('user_role.CowMonitorControllerStore'),
	        		'edit' => __('user_role.CowMonitorControllerEdit'),
	        		'update' => __('user_role.CowMonitorControllerUpdate'),
	        		'destroy' => __('user_role.CowMonitorControllerDestroy'),
	        	),
	        	'CowVaccineMonitorController' => array(
	        		'index' => __('user_role.CowVaccineMonitorControllerIndex'),
	        		'create' => __('user_role.CowVaccineMonitorControllerCreate'),
	        		'store' => __('user_role.CowVaccineMonitorControllerStore'),
	        		'edit' => __('user_role.CowVaccineMonitorControllerEdit'),
	        		'update' => __('user_role.CowVaccineMonitorControllerUpdate'),
	        		'destroy' => __('user_role.CowVaccineMonitorControllerDestroy'),
	        	),
	        	'SaleCowController' => array(
	        		'index' => __('user_role.SaleCowControllerIndex'),
	        		'create' => __('user_role.SaleCowControllerCreate'),
	        		'store' => __('user_role.SaleCowControllerStore'),
	        		'edit' => __('user_role.SaleCowControllerEdit'),
	        		'update' => __('user_role.SaleCowControllerUpdate'),
	        		'destroy' => __('user_role.SaleCowControllerDestroy'),
	        	),
	        	'DesignationController' => array(
	        		'index' => __('user_role.DesignationControllerIndex'),
	        		'store' => __('user_role.DesignationControllerStore'),
	        		'update' => __('user_role.DesignationControllerUpdate'),
	        		'destroy' => __('user_role.DesignationControllerDestroy'),
	        	),
	        	'EmployeeSalaryController' => array(
	        		'index' => __('user_role.EmployeeSalaryControllerIndex'),
	        		'create' => __('user_role.EmployeeSalaryControllerCreate'),
	        		'store' => __('user_role.EmployeeSalaryControllerStore'),
	        		'edit' => __('user_role.EmployeeSalaryControllerEdit'),
	        		'update' => __('user_role.EmployeeSalaryControllerUpdate'),
	        		'destroy' => __('user_role.EmployeeSalaryControllerDestroy'),
	        	),
	        	'ExpenseController' => array(
	        		'index' => __('user_role.ExpenseControllerIndex'),
	        		'store' => __('user_role.ExpenseControllerStore'),
	        		'update' => __('user_role.ExpenseControllerUpdate'),
	        		'destroy' => __('user_role.ExpenseControllerDestroy'),
	        	),
	        	'ExpensePurposeController' => array(
	        		'index' => 	__('user_role.ExpensePurposeControllerIndex'),
	        		'store' => 	__('user_role.ExpensePurposeControllerStore'),
	        		'update' => 	__('user_role.ExpensePurposeControllerUpdate'),
	        		'destroy' =>	__('user_role.ExpensePurposeControllerDestroy'),
	        	),
	        	'FoodItemController' => array(
	        		'index' => __('user_role.FoodItemControllerIndex'),
	        		'store' => __('user_role.FoodItemControllerStore'),
	        		'update' => __('user_role.FoodItemControllerUpdate'),
	        		'destroy' => __('user_role.FoodItemControllerDestroy'),
	        	),
	        	'FoodUnitController' => array(
	        		'index' => __('user_role.FoodUnitControllerIndex'),
	        		'store' => __('user_role.FoodUnitControllerStore'),
	        		'update' => __('user_role.FoodUnitControllerUpdate'),
	        		'destroy' => __('user_role.FoodUnitControllerDestroy'),
	        	),
	        	'HumanResourceController' => array(
	        		'index' => __('user_role.HumanResourceControllerIndex'),
	        		'userList' => __('user_role.HumanResourceControllerUserList'),
	        		'create' => __('user_role.HumanResourceControllerCreate'),
	        		'store' => __('user_role.HumanResourceControllerStore'),
	        		'edit' => __('user_role.HumanResourceControllerEdit'),
	        		'update' => __('user_role.HumanResourceControllerUpdate'),
	        		'destroy' => __('user_role.HumanResourceControllerDestroy'),
	        	),
	        	'MonitoringServicesController' => array(
	        		'index' => __('user_role.MonitoringServicesControllerIndex'),
	        		'store' => __('user_role.MonitoringServicesControllerStore'),
	        		'update' => __('user_role.MonitoringServicesControllerUpdate'),
	        		'destroy' => __('user_role.MonitoringServicesControllerDestroy'),
	        	),
	        	'SaleMilkController' => array(
	        		'index' => __('user_role.SaleMilkControllerIndex'),
	        		'store' => __('user_role.SaleMilkControllerStore'),
	        		'update' => __('user_role.SaleMilkControllerUpdate'),
	        		'destroy' => __('user_role.SaleMilkControllerDestroy'),
	        	),
	        	'ShedController' => array(
	        		'index' => __('user_role.ShedControllerIndex'),
	        		'store' => __('user_role.ShedControllerStore'),
	        		'update' => __('user_role.ShedControllerUpdate'),
	        		'destroy' => __('user_role.ShedControllerDestroy'),
	        	),
	        	'SupplierContoller' => array(
	        		'index' => __('user_role.SupplierContollerIndex'),
	        		'create' => __('user_role.SupplierContollerCreate'),
	        		'store' => __('user_role.SupplierContollerStore'),
	        		'edit' => __('user_role.SupplierContollerEdit'),
	        		'update' => __('user_role.SupplierContollerUpdate'),
	        		'destroy' => __('user_role.SupplierContollerDestroy'),
	        		'supplierFilter' => __('user_role.SupplierContollerSupplierFilter'),
	        	),
	        	'UserTypeController' => array(
	        		'index' => __('user_role.UserTypeControllerIndex'),
	        		'store' => __('user_role.UserTypeControllerStore'),
	        		'update' => __('user_role.UserTypeControllerUpdate'),
	        	),
	        	'VaccinesController' => array(
	        		'index' => __('user_role.VaccinesControllerIndex'),
	        		'store' => __('user_role.VaccinesControllerStore'),
	        		'update' => __('user_role.VaccinesControllerUpdate'),
	        		'destroy' => __('user_role.VaccinesControllerDestroy'),
	        	),
	        	'EmployeeSalaryReportController' => array(
	        		'index' => __('user_role.EmployeeSalaryReportControllerIndex'),
	        		'store' => __('user_role.EmployeeSalaryReportControllerstore'),
	        	),
	        	'MilkCollectReportControlller' => array(
	        		'index' => __('user_role.MilkCollectReportControlllerIndex'),
	        		'store' => __('user_role.MilkCollectReportControlllerStore'),
	        	),
	        	'MilkSaleReportControlller' => array(
	        		'index' => __('user_role.MilkSaleReportControlllerIndex'),
	        		'store' => __('user_role.MilkSaleReportControlllerStore'),
	        	),
	        	'OfficeExpensReportController' => array(
	        		'index' => __('user_role.OfficeExpensReportControllerIndex'),
	        		'store' => __('user_role.OfficeExpensReportControllerStore'),
	        	),
	        	'SaleCowReportController' => array(
	        		'index' => __('user_role.SaleCowReportControllerIndex'),
	        		'cowSaleReportSearch' => __('user_role.SaleCowReportControllerCowSaleReportSearch'),
	        	),
	        	'CowVaccineMonitorReportController' => array(
	        		'index' => __('user_role.CowVaccineMonitorReportControllerIndex'),
	        		'store' => __('user_role.CowVaccineMonitorReportControllerStore'),
	        		'vaccineWiseMonitoringReport' => __('user_role.CowVaccineMonitorReportControllerVaccineWiseMonitoringReport'),
	        		'getVaccineWiseMonitoringReport' => __('user_role.CowVaccineMonitorReportControllerGetVaccineWiseMonitoringReport'),
	        	),
	        	'SaleDueCollectionController' => array(
	        		'index' => __('user_role.SaleDueCollectionControllerIndex'),
	        		'store' => __('user_role.SaleDueCollectionControllerStore'),
	        		'getSaleHistory' => __('user_role.SaleDueCollectionControllerGetSaleHistory'),
	        	),
				'SystemController' => array(
	        		'index' => __('user_role.SystemControllerIndex'),
	        		'update' => __('user_role.SystemControllerUpdate'),
	        	),
				'AnimalStatisticsController' => array(
	        		'index' => __('user_role.AnimalStatisticsControllerIndex'),
	        	),
				'AnimalPregnancyController' => array(
	        		'index' => __('user_role.AnimalPregnancyControllerIndex'),
	        	),
				'MilkSaleDueCollectionController' => array(
	        		'index' => __('user_role.MilkSaleDueCollectionControllerIndex'),
	        	),
	      
	        );
	        return $controllerAccessArr;
	    }

	    public static function verifyAccess($controller = false, $method = false)
	    {
	    	if(Auth::user()->user_type==1){
	            return true;
	        }else{
	            $data=UserType::where('id', Auth::user()->user_type)->pluck('user_role')->first();
	            $userRoleAccess = json_decode($data, true);

	            if(isset($userRoleAccess[$controller][$method])){
	                return true;
	            }
	            else{
	                return false;
	            }
	        }
	    }
	}
}
