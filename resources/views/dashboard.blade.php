@extends('layouts.layout')
@section('title', __('same.dashboard'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> {{ __('dashboard.user-dashboard') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('same.dashboard') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content" id="dashboard-panel">
  <div class="row">
    <div class="col-md-12"> @include('common.message') </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box"> <span class="info-box-icon bg-red"><img src="public/custom/img/employee.png"></span>
        <div class="info-box-content"> <span class="info-box-text">{{__('dashboard.total-staff') }}</span> <span class="info-box-number">{{$totalEmployee}}</span> </div>
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
	  <div class="info-box"> <span class="info-box-icon bg-aqua"><img src="public/custom/img/cow.png"></span>
        <div class="info-box-content"> <span class="info-box-text">{{__('dashboard.total-cow') }}</span> <span class="info-box-number">{{$totalCow}}</span> </div>
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
	  <div class="info-box"> <span class="info-box-icon bg-yellow"><img src="public/custom/img/calf.png"></span>
        <div class="info-box-content"> <span class="info-box-text">{{__('dashboard.total-calf') }}</span> <span class="info-box-number">{{$totalCalf}}</span> </div>
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
	  <div class="info-box"> <span class="info-box-icon bg-green"><img src="public/custom/img/supplier.png"></span>
        <div class="info-box-content"> <span class="info-box-text">{{__('dashboard.total-supplier') }}</span> <span class="info-box-number">{{$totalSupplier}}</span> </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
	  <div class="info-box"> <span class="info-box-icon bg-red"><img src="public/custom/img/cow-stalls.png"></span>
        <div class="info-box-content"> <span class="info-box-text">{{__('dashboard.total-cow-stall') }}</span> <span class="info-box-number">{{$totalShed}}</span> </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box"> <span class="info-box-icon bg-aqua"><img src="public/custom/img/expense.png"></span>
        <div class="info-box-content"> <span class="info-box-text">{{__('dashboard.total-expense') }}</span> <span class="info-box-number">{{\App\Library\farm::currency($totalExpense)}}</span> </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box"> <span class="info-box-icon bg-yellow"><img src="public/custom/img/milk.png"></span>
        <div class="info-box-content"> <span class="info-box-text">{{__('dashboard.total-collected-milk') }}</span> <span class="info-box-number">{{$totalCollectMilk}}</span> </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box"> <span class="info-box-icon bg-green"><img src="public/custom/img/milk-delivery.png"></span>
        <div class="info-box-content"> <span class="info-box-text">{{__('dashboard.total-sold-milk') }}</span> <span class="info-box-number">{{\App\Library\farm::currency($totalSaleMilk)}}</span> </div>
      </div>
	  
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box"> <span class="info-box-icon bg-red"><img src="public/custom/img/today-milk.png"></span>
        <div class="info-box-content"> <span class="info-box-text">{{__('dashboard.today-collected-milk') }}</span> <span class="info-box-number">{{$todayCollectMilk}}</span> </div>
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box"> <span class="info-box-icon bg-aqua"><img src="public/custom/img/today-sold-milk.png"></span>
        <div class="info-box-content"> <span class="info-box-text">{{__('dashboard.today-sold-milk') }}</span> <span class="info-box-number">{{$todaySaleMilk}}</span> </div>
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box"> <span class="info-box-icon bg-yellow"><img src="public/custom/img/milk-collect-amount.png"></span>
        <div class="info-box-content"> <span class="info-box-text">{{__('dashboard.today-collected-milk-amount') }}</span> <span class="info-box-number">{{$todayCollectMilkAmnt}}</span> </div>
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box"> <span class="info-box-icon bg-green"><img src="public/custom/img/milk-sold-amount.png"></span>
        <div class="info-box-content"> <span class="info-box-text">{{__('dashboard.today-sold-milk-amount') }}</span> <span class="info-box-number">{{$todaySaleMilkAmnt}}</span> </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-bar-chart"></i> {{__('dashboard.milk_sell_chart') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
              <p class="text-center"> {{__('dashboard.sale_chart_jan_dec') }} {{date('Y', strtotime(date('m/d/Y')))}} </p>
              <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas id="myChart" width="400" height="300"></canvas>
              </div>
              <!-- /.chart-responsive -->
            </div>
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
    </div>
    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-bar-chart"></i> {{__('dashboard.monthly_sale_expense_chart') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
              <p class="text-center"> {{__('dashboard.expense_chart_from_jan_dec') }} {{date('Y', strtotime(date('m/d/Y')))}}</p>
              <div class="chart">
                <!-- Sales Chart Canvas -->
                <canvas id="myChart2" width="400" height="300"></canvas>
              </div>
              <!-- /.chart-responsive -->
            </div>
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
    </div>
    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-info-circle"></i> {{__('dashboard.last_fve_enpense_history') }}</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table_scroll" style="height: 260px;overflow: auto;">
                <table class="table table-bordered table-striped table-responsive table-hover">
                  <tr>
                    <th>{{__('same.date') }}</th>
                    <th>{{__('dashboard.expense_purpose') }}</th>
                    <th>{{__('same.amount') }}</th>
                  </tr>
                  <tbody>
                  
                  @foreach($lastFiveExpense as $lastFiveExpenseData)
                  <tr>
                    <td>{{date('M d, Y', strtotime($lastFiveExpenseData->date))}}</td>
                    <td>{{$lastFiveExpenseData->purpose_name}}</td>
                    <td>{{\App\Library\farm::currency($lastFiveExpenseData->amount)}}</td>
                  </tr>
                  @endforeach
                  </tbody>
                  
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-info-circle"></i> {{__('dashboard.last_fve_milk_sale_history') }}</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table_scroll" style="height: 260px;overflow: auto;">
                <table class="table table-bordered table-striped table-responsive table-hover">
                  <tr>
                    <th>{{__('same.date') }}</th>
                    <th>{{__('same.account_no') }}</th>
                    <th>{{__('same.litre') }}</th>
                    <th>{{__('same.amount') }}</th>
                  </tr>
                  <tbody>
                  
                  @foreach($lastFiveMilkSale as $lastFiveMilkSaleData)
                  <tr>
                    <td>{{date('M d, Y', strtotime($lastFiveMilkSaleData->date))}}</td>
                    <td>{{$lastFiveMilkSaleData->milk_account_number}}</td>
                    <td>{{$lastFiveMilkSaleData->litter}}</td>
                    <td>{{\App\Library\farm::currency($lastFiveMilkSaleData->total_amount)}}</td>
                  </tr>
                  @endforeach
                  </tbody>
                  
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	
	<?php
		use App\Models\Animal;
		use App\Models\CowFeed;
		use App\Models\CowFeedDtls;
		use App\Models\FoodItem;
		use App\Models\FoodUnit;
	?>
	<div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-cutlery"></i> {{__('dashboard.cow_feed_chart') }}</h3>
		  <div class="box-tools pull-right">
                <a href="{{url('cow-feed/create')}}" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> {{__('dashboard.set_feed_chart') }}</a>
              </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table_scroll" style="height:450px;overflow: auto;">
                <table class="table table-bordered table-striped table-responsive table-hover">
                  <tr>
                    <th>{{__('dashboard.stall_number') }}</th>
					@foreach($food_items as $food_item)
					<th>{{$food_item->name}}</th>
					@endforeach
                  </tr>
                  <tbody>
                  
                  @foreach($all_sheds as $all_shed)
                  <tr>
					<?php 
						$feedsDetails = array();
						$animal_id = '';
						$animal = Animal::join('cow_feed', 'cow_feed.cow_id', 'animals.id')
											->where('animals.shade_no', $all_shed->id)
											->select('animals.*', 'cow_feed.id')
											->first();
						if(!empty($animal->id)){
							$animal_id = '000'.$animal->id;
							$dtlsArr = DB::table('cow_feed_dtls')
                                            ->leftJoin('food_items', 'food_items.id', 'cow_feed_dtls.item_id')
                                            ->leftJoin('food_units', 'food_units.id', 'cow_feed_dtls.unit_id')
                                            ->where('feed_id', $animal->id)
                                            ->select('food_items.name as item_name', 'food_units.name as unit_name', 'cow_feed_dtls.qty', 'cow_feed_dtls.time')
                                            ->get();
											
							foreach($dtlsArr as $dtls){
								$feedsDetails[$dtls->item_name] = array(
									'item_name'		=> $dtls->item_name,
									'unit_name'		=> $dtls->unit_name,
									'qty'			=> $dtls->qty,
									'time'			=> $dtls->time,
								);
							}
							
						}
						
					?>
					<td>{{$all_shed->shed_number}}</td>
					<?php if(!empty($feedsDetails) && count($feedsDetails) > 0) { ?>
						@foreach($food_items as $food_item)
							<?php if(isset($feedsDetails[$food_item->name])) { ?>
								<td><label class="label label-success lblfarm">{{__('dashboard.quantity') }} : <?php echo $feedsDetails[$food_item->name]['qty'].' '.$feedsDetails[$food_item->name]['unit_name']?></label> &nbsp; <label class="label label-warning lblfarm">{{__('dashboard.time') }} : <?php echo $feedsDetails[$food_item->name]['time']; ?></label></td>
							<?php } else { ?>
								<td>&nbsp;</td>
							<?php } ?>
						@endforeach
					<?php } else { ?>
						@foreach($food_items as $food_item)
							<td>&nbsp;</td>
						@endforeach
					<?php } ?>
                  </tr>
                   @endforeach
                  </tbody>
                  
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<input type="hidden" id="monthly_milk_sale" value='<?php echo $monthly_milk_sale; ?>' />
<input type="hidden" id="monthly_expense" value='<?php echo $monthly_expense; ?>' />
<!-- /.content -->
@endsection 