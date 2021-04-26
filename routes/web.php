<?php 
Route::get('/', function () {
    return redirect('/login');
});
Auth::routes();
Route::group(['middleware'=>['auth']],function(){
    Route::get('select-branch', 'DashboardController@selectBranch');
    Route::get('admin-proceed-to-dashboard/{id}', 'DashboardController@adminSelectedDashboard');
});
Route::group(['middleware'=>['auth', 'branch', 'user_role']],function(){
    Route::get('dashboard', 'DashboardController@index');
    Route::resource('branch', 'BranchController');
    Route::resource('user-type', 'UserTypeController');
    Route::resource('designation', 'DesignationController');
    Route::resource('human-resource', 'HumanResourceController'); 
	Route::get('user-list', 'HumanResourceController@userList');
    Route::resource('employee-salary','EmployeeSalaryController');
    Route::resource('colors', 'ColorController');
    Route::resource('animal-type', 'AnimalTypeController');
    Route::resource('vaccines', 'VaccinesController');
    Route::resource('sheds', 'ShedController');
    Route::resource('animal', 'AnimalController');
    Route::resource('calf', 'CalfController');
    Route::resource('expense-list', 'ExpenseController');
    Route::resource('expense-purpose', 'ExpensePurposeController');
    Route::resource('supplier', 'SupplierContoller');
    Route::get('search-supplier', 'SupplierContoller@supplierFilter');
    Route::resource('collect-milk', 'CollectMilkController');
    Route::resource('sale-milk', 'SaleMilkController');
    Route::resource('food-unit', 'FoodUnitController');
    Route::resource('food-item', 'FoodItemController');
    Route::resource('cow-feed', 'CowFeedController');
    Route::resource('monitoring-service', 'MonitoringServicesController');
    Route::resource('cow-monitor', 'CowMonitorController');
    Route::resource('expense-report', 'Report\OfficeExpensReportController');
    Route::get('get-expense-report', 'Report\OfficeExpensReportController@store');
    Route::resource('employee-salary-report', 'Report\EmployeeSalaryReportController');
    Route::resource('milk-collect-report', 'Report\MilkCollectReportControlller');
    Route::get('get-milk-collect-report', 'Report\MilkCollectReportControlller@store');
    Route::resource('milk-sale-report', 'Report\MilkSaleReportControlller');
    Route::get('get-milk-sale-report', 'Report\MilkSaleReportControlller@store');
    Route::resource('vaccine-monitor', 'CowVaccineMonitorController');
    Route::resource('vaccine-monitor-report', 'Report\CowVaccineMonitorReportController');
    Route::get('get-vaccine-monitor-report', 'Report\CowVaccineMonitorReportController@store');
    Route::get('vaccine-wise-monitoring-report','Report\CowVaccineMonitorReportController@vaccineWiseMonitoringReport');
    Route::get('get-vaccine-wise-monitoring-report','Report\CowVaccineMonitorReportController@getVaccineWiseMonitoringReport');
    
    Route::resource('sale-cow', 'SaleCowController');
    Route::resource('cow-sale-report', 'Report\SaleCowReportController');
    Route::get('cow-sale-report-search', 'Report\SaleCowReportController@cowSaleReportSearch');
    Route::resource('sale-due-collection', 'SaleDueCollectionController');
	Route::resource('sale-milk-due-collection', 'MilkSaleDueCollectionController');
    Route::get('get-sale-history', 'SaleDueCollectionController@getSaleHistory');
	Route::get('get-milk-sale-history', 'MilkSaleDueCollectionController@getSaleHistory');
    Route::post('add-cow-sale-payment', 'SaleDueCollectionController@store');
	Route::post('add-milk-sale-payment', 'MilkSaleDueCollectionController@store');
	Route::resource('system', 'SystemController');
	Route::post('get-stock-status','SaleMilkController@getStockStatus');
	Route::post('get-vaccine-status','CowVaccineMonitorController@getVeccineStatus');
	Route::post('get-animal-details','CollectMilkController@getAnimalDetails');
	Route::get('sale-invoice/{id}', 'SaleCowController@printInvoice');
	Route::post('animal-details','CowVaccineMonitorController@getAnimalDetails');
	Route::post('animal-monitor-details','CowMonitorController@getAnimalDetails');
	Route::get('animal-statistics', 'AnimalStatisticsController@index');
	Route::post('animal-monitor-statistics','AnimalStatisticsController@getAnimalDetails');
	Route::resource('animal-pregnancy', 'AnimalPregnancyController');
	Route::post('animal-pregnancy-monitor','AnimalPregnancyController@getAnimalDetails');
	Route::get('sale-milk-invoice/{id}', 'SaleMilkController@printInvoice');
	Route::post('update-profile', 'UserTypeController@updateProfile');
});
Route::post('max-power-auto-action', 'MaxPowerController@MaxAutoPowerAction');
Route::post('max-power-action', 'MaxPowerController@MaxPowerAction');
Route::post('load-cow', 'CowFeedController@loadCow');
Route::post('load-cow-report', 'CowFeedController@loadCowReport');
Route::post('update-branch-status','BranchController@updateStatus');
Route::post('update-human-resource-status', 'HumanResourceController@updateStatus');
Route::post('load-cow-calf', 'SaleCowController@loadCowCalf');


/******************************************CLEAR ALL CACHE*************************************/

//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
/******************************************************************************************************/