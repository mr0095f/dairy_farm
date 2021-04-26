@extends('layouts.layout')
@section('title', __('reports.expense_report_title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="fa fa-area-chart"></i> {{__('reports.expense_report_title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active"><a>{{__('reports.expense_report_title') }}</a></li>
  </ol>
</section>
<!-- Main content -->
<?php
$configuration_data = \App\Library\farm::get_system_configuration('system_config');
$branch_info =  \App\Library\farm::branchInfo();
?>
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success">
    <div class="box-body">
      <div class="form-group"> {!! Form::open(array('url' => 'get-expense-report','class'=>'form-horizontal','autocomplete'=>'off','method' =>'GET')) !!}
        <div class="col-md-8 col-md-offset-2 mt20">
          <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-calendar"></i> {{__('reports.date_range') }}</div>
            <div class="panel-body pb250"> @if(isset($date_from))
              <div class="col-md-4">
                <input name="date_from" value="{{date('m/d/Y',strtotime($date_from))}}" id="date_from" class="form-control  wsit_datepicker" placeholder="{{__('same.start_date') }}" type="text" selected>
              </div>
              @else
              <div class="col-md-4">
                <input name="date_from" value="" id="date_from" class="form-control wsit_datepicker" placeholder="{{__('same.start_date') }}" type="text" selected>
              </div>
              @endif
              @if(isset($date_to))
              <div class="col-md-4"> @if($date_to !='')
                <input name="date_to" value="{{date('m/d/Y',strtotime($date_to))}}" id="date_to" class="form-control wsit_datepicker" placeholder="{{__('same.end_date') }}" type="text" selected>
                @else
                <input name="date_to" value="" id="date_to" class="form-control wsit_datepicker" placeholder="{{__('same.end_date') }}" type="text" selected>
                @endif </div>
              @else
              <div class="col-md-4">
                <input name="date_to" value="" id="dateTo" class="form-control wsit_datepicker" placeholder="{{__('same.end_date') }}" type="text" selected>
              </div>
              @endif
              <div class="col-md-4">
                <button type="submit" class="btn btn-success btn100"><i class="fa fa-search"></i> {{__('same.search') }}</button>
              </div>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
        <div class="clearfix"></div>
      </div>
      <hr/>
      @if(isset($hasData))
      <div class="table_scroll">
        <div id="print_icon"><a class="printReports" href="javascript:;"><img class="img-thumbnail" src='{{asset("storage/app/public/common/print.png")}}'></a></div>
        <br>
        <br>
        <div id="printBox">
			<div id="printTable">
			  <div class="col-md-12 print-base">
				<p>@if(!empty($configuration_data) && !empty($configuration_data->logo))<img src="{{asset("storage/app/public/uploads/$configuration_data->logo")}}"/>@endif</p>
				<p class="print-ptag">@if(!empty($configuration_data) && !empty($configuration_data->topTitle)){{$configuration_data->topTitle}}@endif</p>
				<?php if(!empty($branch_info->branch_name)) { ?>
				<p class="print-ptag">{{$branch_info->branch_name}}</p>
				<?php } ?>
				<p class="print-ptag">{{__('reports.office_expense_report') }}</p>
				<p class="print-ptag">{{__('reports.for_date') }} : {{$date_from}} 
				  @if(isset($date_to))
				  - {{$date_to}} 
				  @endif </p>
			  </div>
			  <div class="table-div">
				<table class="table-print-style-1">
				  <thead>
					<tr>
					  <th>{{__('same.sl') }}</th>
					  <th>{{__('same.date') }}</th>
					  <th>{{__('reports.expense_purpose') }}</th>
					  <th class="text-left">{{__('reports.amount') }}</th>
					</tr>
				  </thead>
				  <tbody>
					<?php $totalamount = 0; ?>
				  @if(isset($getJsonArr) && !empty($getJsonArr) && count($alldata)>0)
				  @foreach($alldata as $data)
				  <?php $totalamount += $data->amount;?>
				  <tr>
					<td> {{$data->id}} </td>
					<td> {{date('m/d/Y', strtotime($data->date))}} </td>
					<td> {{$data->purpose_name}} </td>
					<td align="left"> {{App\Library\farm::currency($data->amount)}} </td>
				  </tr>
				  @endforeach
				  @else
				  <tr>
					<td colspan="10" align="center"><h2>{{__('same.empty_row') }}</h2></td>
				  </tr>
				  @endif
				  </tbody>
				  
				  <tfoot>
					<tr>
					  <td colspan="3" align="right"><strong>{{__('same.total') }} :</strong></td>
					  <td>{{ App\Library\farm::currency($totalamount) }}</td>
					</tr>
				  </tfoot>
				</table>
			  </div>
			</div>
		</div>
      </div>
      @endif </div>
  </div>
  <!-- /.box -->
</section>
{!!Html::style('public/custom/css/report.css')!!}
<input type="hidden" id="print_url_1" value='{!!Html::style("public/custom/css/bootstrap.min.css")!!}' />
<input type="hidden" id="print_url_2" value='{!!Html::style("public/custom/css/report.css")!!}' />
<input type="hidden" id="print_url_3" value='{!!Html::style("public/custom/css/AdminLTE.css")!!}' />
<!-- /.content -->
@endsection 