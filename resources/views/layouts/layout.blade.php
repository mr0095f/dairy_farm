<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>@yield('title')</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Bootstrap 3.3.7 -->
{!!Html::style('public/custom/css/bootstrap.min.css')!!}
<!-- Font Awesome -->
{!!Html::style('public/custom/css_icon/font-awesome/css/font-awesome.min.css')!!}
<!-- Ionicons -->
{!!Html::style('public/custom/css_icon/Ionicons/css/ionicons.min.css')!!}
<!-- Simple Line Icon -->
{!!Html::style('public/css/cssicon/css/simple-line-icons.css')!!}
<!-- Theme style -->
{!!Html::style('public/custom/css/AdminLTE.css')!!}
{!!Html::style('public/custom/css/skins/_all-skins.css')!!}
{!!Html::style('public/custom/css/bootstrap-tagsinput.css')!!}
{!!Html::style('public/custom/css/style.css')!!}
<!-- jQuery 3 -->
{!!Html::script('public/custom/js/plugins/jquery/dist/jquery.min.js')!!}
<!-- Bootstrap 3.3.7 -->
{!!Html::script('public/custom/js/plugins/bootstrap/dist/js/bootstrap.min.js')!!}
{!!Html::script('public/custom/js/plugins/bootstrap/dist/js/bootstrap-confirmation.min.js')!!}
<!-- SlimScroll -->
{!!Html::script('public/custom/js/plugins/jquery-slimscroll/jquery.slimscroll.js')!!}
<!-- FastClick -->
{!!Html::script('public/custom/js/plugins/fastclick/lib/fastclick.js')!!}
<!-- AdminLTE App -->
{!!Html::script('public/custom/js/adminlte.js')!!}
<!--datepicker-->
{!!Html::script('public/custom/js/plugins/datepicker/bootstrap-datepicker.js')!!}
{!!Html::style('public/custom/js/plugins/datepicker/datepicker3.css')!!}
{!!Html::script('public/custom/js/bootstrap-tagsinput.js')!!}
{!!Html::script('public/custom/js/demo.js')!!}
{!!Html::script('public/custom/js/plugins/chart/chart.js')!!}
{!!Html::script('public/custom/js/plugins/chart/Chart.min.js')!!}
{!!Html::script('public/custom/js/plugins/chart/utils.js')!!}
{!!Html::style('public/custom/js/plugins/select/select2.min.css')!!}
{!!Html::script('public/custom/js/plugins/select/select2.min.js')!!}
{!!Html::script('public/custom/js/notify.js')!!}
<!-- Range Slider -->
{!!Html::script('public/custom/js/plugins/ionslider/ion.rangeSlider.js')!!}
{!!Html::style('public/custom/js/plugins/ionslider/ion.rangeSlider.css')!!}
<!-- owl-carousel -->
{!!Html::script('public/custom/js/plugins/owl-carousel/owl.carousel.js')!!}
{!!Html::style('public/custom/js/plugins/owl-carousel/assets/owl.carousel.css')!!}
<!-- Calculator -->
{!!Html::script('public/custom/js/plugins/calculator/SimpleCalculadorajQuery.js')!!}
{!!Html::style('public/custom/js/plugins/calculator/SimpleCalculadorajQuery.css')!!}
<!-- Moment.js -->
{!!Html::script('public/custom/js/plugins/datepicker/moment.js')!!}

{!!Html::script('public/custom/js/ckeditor.js')!!}
</head>
<body class="hold-transition skin-green-light sidebar-mini fixed">
<?php 
  $configuration_data = \App\Library\farm::get_system_configuration('system_config');
  $url = Request::path(); 
  use App\library\UserRoleWiseAccess;
  
  if(!empty(Auth::user()->image)){
    $loginImg = "storage/app/public/uploads/human-resource/".Auth::user()->image;
    if (!file_exists($loginImg)) {
      $loginImg = "storage/app/public/uploads/nouserimage.png";
    }
  }else{
    $loginImg = "storage/app/public/uploads/nouserimage.png";
  }
  
  if(Auth::user()->user_type == 1){
  	$loginImg = "storage/app/public/uploads/".$configuration_data->super_admin_logo;
  }

  $staffList = UserRoleWiseAccess::verifyAccess('HumanResourceController', 'index');
  $staffCreate = UserRoleWiseAccess::verifyAccess('HumanResourceController', 'create');
  $userList = UserRoleWiseAccess::verifyAccess('HumanResourceController', 'userList');
  $salaryList = UserRoleWiseAccess::verifyAccess('EmployeeSalaryController', 'index');
  $collectMilkList = UserRoleWiseAccess::verifyAccess('CollectMilkController', 'index');
  $saleMilkList = UserRoleWiseAccess::verifyAccess('SaleMilkController', 'index');
  $cowFeedList = UserRoleWiseAccess::verifyAccess('CowFeedController', 'index');
  $cowMonitorList = UserRoleWiseAccess::verifyAccess('CowMonitorController', 'index');
  $cowVaccineMonitorList = UserRoleWiseAccess::verifyAccess('CowVaccineMonitorController', 'index');
  $expenseList = UserRoleWiseAccess::verifyAccess('ExpenseController', 'index');
  $expensePurposeList = UserRoleWiseAccess::verifyAccess('ExpensePurposeController', 'index');
  $supplierList = UserRoleWiseAccess::verifyAccess('SupplierContoller', 'index');
  $animalList = UserRoleWiseAccess::verifyAccess('AnimalController', 'index');
  $calfList = UserRoleWiseAccess::verifyAccess('CalfController', 'index');
  $shedList = UserRoleWiseAccess::verifyAccess('ShedController', 'index');
  $branchList = UserRoleWiseAccess::verifyAccess('BranchController', 'index');
  $userTypeList = UserRoleWiseAccess::verifyAccess('UserTypeController', 'index');
  $designationList = UserRoleWiseAccess::verifyAccess('DesignationController', 'index');
  $colorList = UserRoleWiseAccess::verifyAccess('ColorController', 'index');
  $animalTypeList = UserRoleWiseAccess::verifyAccess('AnimalTypeController', 'index');
  $vaccineList = UserRoleWiseAccess::verifyAccess('VaccinesController', 'index');
  $foodUnitList = UserRoleWiseAccess::verifyAccess('FoodUnitController', 'index');
  $foodItemList = UserRoleWiseAccess::verifyAccess('FoodItemController', 'index');
  $monitorServiceList = UserRoleWiseAccess::verifyAccess('MonitoringServicesController', 'index');
  $expenseReportList = UserRoleWiseAccess::verifyAccess('OfficeExpensReportController', 'index');
  $salaryReportList = UserRoleWiseAccess::verifyAccess('EmployeeSalaryReportController', 'index');
  $milkCollectReportList=UserRoleWiseAccess::verifyAccess('MilkCollectReportControlller', 'index');
  $milkSaleReportList=UserRoleWiseAccess::verifyAccess('MilkSaleReportControlller', 'index');
  $cowVaccineReportList=UserRoleWiseAccess::verifyAccess('CowVaccineMonitorReportController', 'index');
  $vaccineWiseReportList=UserRoleWiseAccess::verifyAccess('CowVaccineMonitorReportController', 'vaccineWiseMonitoringReport');
  $saleCowList=UserRoleWiseAccess::verifyAccess('SaleCowController', 'index');
  $saleCowDueCollectionList=UserRoleWiseAccess::verifyAccess('SaleDueCollectionController', 'index');
  $saleCowReport=UserRoleWiseAccess::verifyAccess('SaleCowReportController', 'cowSaleReportSearch');
  $systemSettings=UserRoleWiseAccess::verifyAccess('SystemController', 'index');
  $animalStatistics=UserRoleWiseAccess::verifyAccess('AnimalStatisticsController', 'index');
  $animalPregnancySetup=UserRoleWiseAccess::verifyAccess('AnimalPregnancyController', 'index');
  $milkDueCollection=UserRoleWiseAccess::verifyAccess('MilkSaleDueCollectionController', 'index');
  //
  $configuration_data = \App\Library\farm::get_system_configuration('system_config');
  $verifyUserPK = \App\Library\farm::verifyUserPKey();
  
  //pregnent processing list
  use App\Models\PregnancyRecord;
  $pregnancy_record_info = PregnancyRecord::join('sheds', 'sheds.id', 'pregnancy_record.stall_no')
										->join('animals', 'animals.id', 'pregnancy_record.cow_id')
										->join('pregnancy_type', 'pregnancy_type.id', 'pregnancy_record.pregnancy_type_id')
										->join('animal_type', 'animal_type.id', 'pregnancy_record.semen_type')
										->where('pregnancy_record.status','1')
										->orderBy('pregnancy_record.id', 'desc')
										->select('pregnancy_record.*','sheds.shed_number','pregnancy_type.type_name','animal_type.type_name as aTypeName')
										->get();
?>
<!-- Site wrapper -->
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="{{URL::To('/')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">@if(!empty($configuration_data) && !empty($configuration_data->logo))<img src="{{asset("storage/app/public/uploads/$configuration_data->logo")}}"/>@endif</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b> @if(!empty($configuration_data) && !empty($configuration_data->topTitle)){{$configuration_data->topTitle}}@endif</b></span> </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="messages-menu calculatorboxbg"> <a href="javascript:;" data-toggle="modal" data-target="#minicalculator" aria-expanded="false"> <img class="imgcalstyle" src="{{ url('public/custom/img/calculator.png') }}"> </a> </li>
          <li class="dropdown notifications-menu pprogress"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"> <img class="imgcalstyle" src="{{ url('public/custom/img/pregnent.png') }}"> <span class="label label-success"><?php echo !empty($pregnancy_record_info) && count($pregnancy_record_info) > 0 ? count($pregnancy_record_info) : 0; ?></span> </a>
            <ul class="dropdown-menu">
              <li class="header"><b>{{__('same.youhave') }} <?php echo !empty($pregnancy_record_info) && count($pregnancy_record_info) > 0 ? count($pregnancy_record_info) : 0; ?> {{__('same.p_processing') }}</b></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @foreach($pregnancy_record_info as $preg_record_info)
                  <?php
					$diff_value = 0;
					$str = App\Library\farm::appoxDeliveryDate($preg_record_info->pregnancy_start_date);
					if(!empty($str['days'])){
						$diff_value = (float)((float)$str['days'] / 383) * 100;
						$diff_value = number_format($diff_value, 2);
					}
				?>
                  <li class="cowpprogess">
                    <div class="pbox"> {{__('same.animal_id') }}: 000{{$preg_record_info->cow_id}}&nbsp;&nbsp;({{__('same.stall_no') }}: {{$preg_record_info->shed_number}}) <small class="pull-right"><b><?php echo !empty($str['days']) && $str['days'] > 0 ? $str['days'] : 0; ?> </b>/283</small> </div>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-green" style="width:<?php echo !empty($str['days']) && $str['days'] > 0 ? $str['days'] : 0; ?>%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"> </div>
                    </div>
                  </li>
                  @endforeach
                </ul>
              </li>
            </ul>
          </li>
          <li class="dropdown user user-menu"> <a class="userprofilebox" href="#" class="dropdown-toggle" data-toggle="dropdown">{!!Html::image( asset($loginImg), 'User Image', array('class' => 'user-image'))!!}<span class="hidden-xs">{{Auth::user()->name}}</span> </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">{!!Html::image( asset($loginImg), 'User Image', array('class' => 'img-circle'))!!}
                <p>Hello<br/>
                  <small> @if(isset(Auth::user()->userTypeDtls->user_type))
                  {{Auth::user()->userTypeDtls->user_type}}
                  @endif <br>
                  @if(Session::has('branch_id'))
                  @if(Session::get('branch_id') !=0 )
                  <?php 
                        $branchFullData = DB::table('branchs')->where('id', Session::get('branch_id'))->first();
                      ?>
                  <strong> {{__('same.zone') }} : {{$branchFullData->branch_name}} </strong> @endif
                  @endif </small> <small></small></p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer"> @if(Auth::user()->user_type == 1)
                <div class="col-md-12 switch-branch-mb-10"> <a href="" data-toggle="modal" data-target="#switch_branch" class="btn btn-primary btn-flat btn-branch-link">{{__('same.switch_branch') }}</a> </div>
                @endif
                <div class="pull-left"> <a href="#" data-toggle="modal" data-target="#profile_modal" class="btn btn-success btn-flat"><i class="fa fa-user-circle"></i> {{__('same.profile') }}</a> </div>
                <div class="pull-right"> <a id="__logout_system" href="{{ route('logout') }}" class="btn btn-danger btn-flat" onClick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fa fa-sign-out"></i> {{__('same.signout') }} </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hideme">
                    @csrf
                  </form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li class="settingspage"> <a href="{{URL::To('system')}}"><i class="fa fa-gear"></i></a> </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- =============================================== -->
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image"> {!!Html::image(asset($loginImg), 'User Image', array('class' => 'img-circle max-height-45'))!!}</div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> {{__('same.online') }}</a> </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="{{($url=='dashboard') ? 'active':''}}"> <a href="{{URL::To('dashboard')}}"> <i class="fa fa-dashboard"></i> <span>{{__('left_menu.dashboard') }}</span> </a> </li>
        @if($staffList==true || $staffCreate==true || $userList==true || $salaryList==true)
        <li class="treeview {{($url=='human-resource'||$url=='human-resource/create' || $url=='user-list' || $url=='employee-salary' || $url=='employee-salary/create')?'active':''}}"> <a href="#"> <i class="fa fa-user-o" aria-hidden="true"></i> <span>{{__('left_menu.human_resource') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            @if($staffCreate==true)
            <li class="{{($url=='human-resource/create')?'active':''}}"><a href="{{URL::To('human-resource/create')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.add_staff') }}</a></li>
            @endif
            @if($staffList==true)
            <li class="{{($url=='human-resource')?'active':''}}"><a href="{{URL::To('human-resource')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.staff_list') }}</a></li>
            @endif
            @if($userList==true)
            <li class="{{($url=='user-list')?'active':''}}"><a href="{{URL::To('user-list')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.user_list') }}</a></li>
            @endif
            @if($salaryList==true)
            <li class="{{($url=='employee-salary' || $url=='employee-salary/create')?'active':''}}"><a href="{{url('employee-salary')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.employee_salary') }}</a></li>
            @endif
          </ul>
        </li>
        @endif
        
        @if($collectMilkList==true || $saleMilkList==true)
        <li class="treeview {{($url=='collect-milk' || $url=='sale-milk' || $url=='get-milk-sale-history' || $url=='sale-milk-due-collection')?'active':''}}"> <a href="#"> <i class="fa fa-tint"></i> <span>{{__('left_menu.milk_parlor') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            @if($collectMilkList==true)
            <li class="{{($url=='collect-milk')?'active':''}}"><a href="{{URL::to('collect-milk')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.collect_milk') }}</a></li>
            @endif
            @if($saleMilkList==true)
            <li class="{{($url=='sale-milk')?'active':''}}"><a href="{{URL::to('sale-milk')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.sale_milk') }}</a></li>
            @endif
            @if($milkDueCollection==true)
            <li class="{{($url=='sale-milk-due-collection' || $url=='get-milk-sale-history')?'active':''}}"><a href="{{URL::to('sale-milk-due-collection')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.sale_due_collection') }}</a></li>
            @endif
          </ul>
        </li>
        @endif
        
        @if($cowFeedList==true)
        <li class="{{($url=='cow-feed' || $url=='cow-feed/create') ? 'active':''}}"> <a href="{{URL::To('cow-feed')}}"> <i class="fa fa-cutlery"></i> <span>{{__('left_menu.cow_feed') }}</span> </a> </li>
        @endif
        
        @if($cowMonitorList==true || $cowVaccineMonitorList==true)
        <li class="treeview {{($url=='cow-monitor' || $url=='animal-pregnancy' || $url=='cow-monitor/create' || $url=='vaccine-monitor' || $url=='vaccine-monitor/create')?'active':''}}"> <a href="#"> <i class="fa fa-tv"></i> <span>{{__('left_menu.cow_monitor') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            @if($cowMonitorList==true)
            <li class="{{($url=='cow-monitor' || $url=='cow-monitor/create')?'active':''}}"><a href="{{URL::to('cow-monitor')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.routine_monitor') }}</a></li>
            @endif
            @if($cowVaccineMonitorList==true)
            <li class="{{($url=='vaccine-monitor' || $url=='vaccine-monitor/create')?'active':''}}"><a href="{{URL::to('vaccine-monitor')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.vaccine_monitor') }}</a></li>
            @endif
            @if($animalPregnancySetup==true)
            <li class="{{($url=='animal-pregnancy')?'active':''}}"><a href="{{URL::to('animal-pregnancy')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.animal_pregnancy') }}</a></li>
            @endif
          </ul>
        </li>
        @endif
        
        @if($saleCowList==true || $saleCowDueCollectionList==true)
        <li class="treeview {{($url=='sale-cow' || $url=='sale-cow/create' || $url=='sale-due-collection')?'active':''}}"> <a href="#"> <i class="fa fa-money"></i> <span>{{__('left_menu.cow_sale') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            @if($saleCowList==true)
            <li class="{{($url=='sale-cow' || $url=='sale-cow/create')?'active':''}}"><a href="{{URL::to('sale-cow')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.sale_list') }}</a></li>
            @endif
            @if($saleCowDueCollectionList==true)
            <li class="{{($url=='sale-due-collection')?'active':''}}"><a href="{{URL::to('sale-due-collection')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.sale_due_collection') }}</a></li>
            @endif
          </ul>
        </li>
        @endif
        
        @if($expenseList==true || $expensePurposeList==true)
        <li class="treeview {{($url=='expense-purpose' || $url=='expense-list')?'active':''}}"> <a href="#"> <i class="fa fa-money"></i> <span>{{__('left_menu.office_expense') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            @if($expenseList==true)
            <li class="{{($url=='expense-list')?'active':''}}"><a href="{{URL::to('expense-list')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.expense_list') }}</a></li>
            @endif
            @if($expensePurposeList==true)
            <li class="{{($url=='expense-purpose')?'active':''}}"><a href="{{URL::to('expense-purpose')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.expense_purpose') }}</a></li>
            @endif
          </ul>
        </li>
        @endif
        
        @if($supplierList==true)
        <li class="{{($url=='supplier' || $url=='supplier/create') ? 'active':''}}"> <a href="{{URL::To('supplier')}}"> <i class="fa fa-user"></i> <span>{{__('left_menu.suppliers') }}</span> </a> </li>
        @endif
        
        @if($animalList==true)
        <li class="{{($url=='animal' || $url=='animal/create') ? 'active':''}}"> <a href="{{URL::To('animal')}}"> <i class="fa fa-paw"></i> <span>{{__('left_menu.manage_cow') }}</span> </a> </li>
        @endif
        
        @if($calfList==true)
        <li class="{{($url=='calf' || $url=='calf/create') ? 'active':''}}"> <a href="{{URL::To('calf')}}"> <i class="fa fa-paw"></i> <span>{{__('left_menu.manage_cow_calf') }}</span> </a> </li>
        @endif
        
        @if($shedList==true)
        <li class="{{($url=='sheds') ? 'active':''}}"> <a href="{{URL::To('sheds')}}"> <i class="fa fa-home"></i> <span>{{__('left_menu.manage_stall') }}</span> </a> </li>
        @endif
        
        @if($branchList==true || $userTypeList==true || $designationList==true || $colorList==true || $animalTypeList==true || $vaccineList==true || $foodItemList==true || $foodUnitList==true || $monitorServiceList==true)
        <li class="treeview {{($url=='branch' || $url=='user-type' || $url=='designation' || $url=='colors' || $url=='animal-type' || $url=='vaccines' || $url=='food-unit' || $url=='monitoring-service' || $url=='food-item') ? 'active':''}}"> <a href="#"> <i class="fa fa-th"></i> <span>{{__('left_menu.catalog') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            @if($branchList==true)
            <li class="{{($url=='branch')?'active':''}}"><a href="{{URL::to('/branch')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.branch') }}</a></li>
            @endif
            @if($userTypeList==true)
            <li class="{{($url=='user-type') ? 'active':''}}"><a href="{{URL::To('user-type')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.user_type') }}</a></li>
            @endif
            @if($designationList==true)
            <li class="{{($url=='designation')?'active':''}}"><a href="{{URL::To('designation')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.designation') }}</a></li>
            @endif
            @if($colorList==true)
            <li class="{{($url=='colors')?'active':''}}"><a href="{{URL::To('colors')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.colors') }}</a></li>
            @endif
            @if($animalTypeList==true)
            <li class="{{($url=='animal-type')?'active':''}}"><a href="{{URL::To('animal-type')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.animal_types') }}</a></li>
            @endif
            @if($vaccineList==true)
            <li class="{{($url=='vaccines')?'active':''}}"><a href="{{URL::To('vaccines')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.vaccines') }}</a></li>
            @endif
            @if($foodUnitList==true)
            <li class="{{($url=='food-unit')?'active':''}}"><a href="{{URL::To('food-unit')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.food_unit') }}</a></li>
            @endif
            @if($foodItemList==true)
            <li class="{{($url=='food-item')?'active':''}}"><a href="{{URL::To('food-item')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.food_item') }}</a></li>
            @endif
            @if($monitorServiceList==true)
            <li class="{{($url=='monitoring-service')?'active':''}}"><a href="{{URL::To('monitoring-service')}}"><i class="fa fa-angle-double-right"></i>{{__('left_menu.monitoring_services') }}</a></li>
            @endif
          </ul>
        </li>
        @endif
        
        @if($systemSettings==true)
        <li class="{{($url=='system') ? 'active':''}}"> <a href="{{URL::To('system')}}"> <i class="fa fa-wrench"></i> <span>{{__('left_menu.settings') }}</span> </a> </li>
        @endif
        
        @if($expenseReportList==true || $salaryReportList==true || $milkCollectReportList==true || $milkSaleReportList==true || $cowVaccineReportList==true || $vaccineWiseReportList==true || $saleCowReport==true)
        <li class="treeview {{($url=='expense-report' || $url=='animal-statistics' || $url=='employee-salary-report' || $url=='milk-collect-report' || $url=='milk-sale-report' || $url=='vaccine-monitor-report' || $url=='vaccine-wise-monitoring-report' || $url=='cow-sale-report')?'active':''}}"> <a href="#"> <i class="fa fa-bar-chart"></i> <span>{{__('left_menu.reports') }}</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            @if($expenseReportList==true)
            <li class="{{($url=='expense-report')?'active':''}}"><a href="{{URL::To('expense-report')}}"><i class="fa fa-angle-double-right"></i> {{__('left_menu.office_expense_report') }}</a></li>
            @endif
            @if($salaryReportList==true)
            <li class="{{($url=='employee-salary-report')?'active':''}}"><a href="{{URL::to('employee-salary-report')}}"><i class="fa fa-angle-double-right"></i> {{__('left_menu.employee_salary_report') }}</a></li>
            @endif
            @if($milkCollectReportList==true)
            <li class="{{($url=='milk-collect-report')?'active':''}}"><a href="{{URL::to('milk-collect-report')}}"><i class="fa fa-angle-double-right"></i> {{__('left_menu.milk_collect_report') }}</a></li>
            @endif
            @if($milkSaleReportList==true)
            <li class="{{($url=='milk-sale-report')?'active':''}}"><a href="{{URL::to('milk-sale-report')}}"><i class="fa fa-angle-double-right"></i> {{__('left_menu.milk_sale_report') }}</a></li>
            @endif
            @if($cowVaccineReportList==true)
            <li class="{{($url=='vaccine-monitor-report')?'active':''}}"><a href="{{URL::to('vaccine-monitor-report')}}"><i class="fa fa-angle-double-right"></i> {{__('left_menu.vaccine_monitor_report') }}</a></li>
            @endif
            @if($vaccineWiseReportList==true)
            <li class="{{($url=='vaccine-wise-monitoring-report')?'active':''}}"><a href="{{URL::to('vaccine-wise-monitoring-report')}}"><i class="fa fa-angle-double-right"></i> {{__('left_menu.vaccine_wise_monitor_report') }}</a></li>
            @endif
            @if($saleCowReport==true)
            <li class="{{($url=='cow-sale-report')?'active':''}}"><a href="{{URL::to('cow-sale-report')}}"><i class="fa fa-angle-double-right"></i> {{__('left_menu.cow_sale_report') }}</a></li>
            @endif
            @if($animalStatistics==true)
            <li class="{{($url=='animal-statistics')?'active':''}}"><a href="{{URL::to('animal-statistics')}}"><i class="fa fa-angle-double-right"></i> {{__('left_menu.animal_statistics') }}</a></li>
            @endif
          </ul>
        </li>
        @endif
      </ul>
      <br/>
      <br/>
      <br/>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- =============================================== -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> @yield('content') </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs"> <b>{{__('same.version') }}</b> 1.0.0 </div>
    <strong>{{__('same.copyright') }} &copy; <?php echo date('Y');?> <a target="_blank" href="@if(!empty($configuration_data) && !empty($configuration_data->copyrightLink)){{$configuration_data->copyrightLink}}@endif">@if(!empty($configuration_data) && !empty($configuration_data->copyrightText)){{$configuration_data->copyrightText}}@endif</a>.</strong> {{__('same.all_right_reverse') }} </footer>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
@if(Auth::user()->user_type == 1)
<!-- Branch Switch Modal -->
<div class="modal fade" id="switch_branch" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content branchbox">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" align="center"><strong>{{__('same.switch_to_another') }}</strong></h4>
      </div>
      <div class="modal-body">
        <?php  
              $admin_all_branches = DB::table('branchs')->get();
            ?>
        @foreach($admin_all_branches as $branch)
        <div class=""> <a class="bboxpointer" href="{{URL::To('admin-proceed-to-dashboard')}}/{{$branch->id}}">
          <div class="info-box"> <span class="info-box-icon bg-green"><i class="fa fa-home"></i></span>
            <div class="info-box-content"> <span class="info-box-text boxbname">{{$branch->branch_name}}</span> <span class="info-box-text">{{$branch->branch_address}}</span> </div>
          </div>
          </a> </div>
        @endforeach </div>
      <div class="modal-footer"> </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endif
<div class="modal fade" id="profile_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-circle"></i> {{__('same.update_profile_title') }}</h4>
      </div>
      <div class="modal-body">
        <h4 align="center" id="notifyMsg"></h4>
        {{Form::hidden('id',Auth::user()->id)}}
        <div class="form-group row">
          <label for="name" class="col-md-4 control-label">{{__('same.name') }}:</label>
		  <div class="col-md-8">
            <input type="text" class="form-control" id="name" value="{{  Auth::user()->name  }}" name="name" placeholder="{{__('same.name') }}">
          </div>
        </div>
        <div class="form-group row">
          <label for="oldPassword" class="col-md-4 control-label">{{__('same.old_password') }}:</label>
		  <div class="col-md-8">
            <input type="password" class="form-control" id="oldPassword" value="" name="exist_password" placeholder="{{__('same.old_password') }}">
            <input type="hidden" class="form-control" id="existPass" value="{{Auth::user()->password}}" name="old_password" placeholder="Enter old password">
          </div>
        </div>
        <div class="form-group row">
          <label for="newPass" class="col-md-4 control-label">{{__('same.new_password') }}:</label>
		  <div class="col-md-8">
            <input type="password" class="form-control" id="newPass" name="password" placeholder="{{__('same.new_password') }}">
          </div>
        </div>
        <div class="form-group row">
          <label for="confirmPass" class="col-md-4 control-label">{{__('same.confirm_password') }}:</label>
		  <div class="col-md-8">
            <input type="password" class="form-control" id="confirmPass" name="confirm_password" placeholder="{{__('same.confirm_password') }}">
            <span id="confirmMsg"></span> </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="btnSave" data-url="{{URL::to('update-profile')}}" value="add">{{__('same.update') }}</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="minicalculator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-md">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-calculator"></i> {{__('same.calculator') }}</h4>
      </div>
      <div class="modal-body">
        <div id="calculator"></div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="verifyApplication" data-backdrop="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-key"></i> {{__('same.verify_purchase') }}</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="pkeyboxalert"><i class="fa fa-hand-o-right"></i> {{__('same.verify_purchase_required') }}</div>
            <div class="form-group">
              <input type="text" class="form-control" id="pk_email" name="email" placeholder="{{__('same.your_email_address') }}">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="pk_website_url" name="website_url" value="{{url('')}}" placeholder="{{__('same.your_domain_name') }}">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" id="pk_purchase_key" name="purchase_key" placeholder="{{__('same.purchase_key') }}">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer"> <i class="fa fa-spinner fa-spin myloader"></i>
        <button type="button" class="btn btn-success access-key-action" data-aurl="{{URL::to('max-power-auto-action')}}" data-url="{{URL::to('max-power-action')}}" id="btnAction"><b>{{__('same.continue_access') }}</b> <i class="fa fa-arrow-right"></i></button>
      </div>
    </div>
  </div>
</div>

<input type="hidden" name="system" id="system" value="{{ App\Library\farm::get_system_configuration_json_data('system_config') }}">
<input type="hidden" id="_pkey" value="{{$verifyUserPK}}">
<input type="hidden" id="site_url" value="{{url('')}}">
<input type="hidden" id="jan" value="{{__('same.jan') }}" />
<input type="hidden" id="feb" value="{{__('same.feb') }}" />
<input type="hidden" id="mar" value="{{__('same.mar') }}" />
<input type="hidden" id="apr" value="{{__('same.apr') }}" />
<input type="hidden" id="may" value="{{__('same.may') }}" />
<input type="hidden" id="jun" value="{{__('same.jun') }}" />
<input type="hidden" id="jul" value="{{__('same.jul') }}" />
<input type="hidden" id="aug" value="{{__('same.aug') }}" />
<input type="hidden" id="sep" value="{{__('same.sep') }}" />
<input type="hidden" id="oct" value="{{__('same.oct') }}" />
<input type="hidden" id="nov" value="{{__('same.nov') }}" />
<input type="hidden" id="dec" value="{{__('same.dec') }}" />
<input type="hidden" id="select" value="{{__('same.select') }}" />

{!!Html::script('public/custom/js/ams.js')!!}
{!!Html::script('public/custom/js/homeGraph.js')!!}
</body>
</html>
