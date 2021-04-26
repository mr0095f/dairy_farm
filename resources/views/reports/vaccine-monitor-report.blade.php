@extends('layouts.layout')
@section('title', __('reports.vaccine_monitor_report') )
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="fa fa-area-chart"></i> {{__('reports.vaccine_monitor_report') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('sale.home') }}</a></li>
    <li class="active"><a>{{__('reports.vaccine_monitor_report') }}</a></li>
  </ol>
</section>
<?php
$configuration_data = \App\Library\farm::get_system_configuration('system_config');
$branch_info =  \App\Library\farm::branchInfo();
?>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success">
    <div class="box-body">
      <div class="form-group"> {!! Form::open(array('url' => 'get-vaccine-monitor-report','class'=>'form-horizontal','autocomplete'=>'off','method' =>'GET')) !!}
        <div class="col-md-12">
          <div class="panel panel-default mt20">
            <div class="panel-heading"><i class="fa fa-search"></i> {{__('reports.search_fields') }}</div>
            <div class="panel-body pb250">
              <div class="col-md-3">
                <select class="form-control" name="shed_no">
                  <option value="0">{{__('reports.select_a_stall') }}</option>
                  @foreach($shedArr as $shedArrData)
                  <option value="{{$shedArrData->id}}" {{isset($shed_no)?($shed_no==$shedArrData->id)?'selected':'':''}}>{{$shedArrData->shed_number}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <input name="dairy_no" value="{{isset($dairy_no)?$dairy_no:''}}" class="form-control" placeholder="{{__('reports.animal_id') }}" type="text">
              </div>
              @if(isset($date_from))
              <div class="col-md-3">
                <input name="date_from" value="{{$date_from}}" id="date_from" class="form-control wsit_datepicker" placeholder="{{__('same.start_date') }}" type="text" selected required>
              </div>
              @else
              <div class="col-md-3">
                <input name="date_from" value="" id="date_from" class="form-control wsit_datepicker" placeholder="{{__('same.start_date') }}" type="text" selected required>
              </div>
              @endif
              @if(isset($date_to))
              <div class="col-md-3"> @if($date_to !='')
                <input name="date_to" value="{{$date_to}}" id="date_to" class="form-control wsit_datepicker" placeholder="{{__('same.end_date') }}" type="text" selected required>
                @else
                <input name="date_to" value="" id="date_to" class="form-control wsit_datepicker" placeholder="{{__('same.end_date') }}" type="text" selected required>
                @endif </div>
              @else
              <div class="col-md-3">
                <input name="date_to" value="" id="dateTo" class="form-control wsit_datepicker" placeholder="{{__('same.end_date') }}" type="text" selected required>
              </div>
              @endif
              <div class="col-md-12"> <br>
                <button type="submit" class="btn btn-success btn100"><i class="fa fa-search"></i> {{__('same.search') }}</button>
              </div>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
        <div class="clearfix"></div>
      </div>
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
              <p class="print-ptag">{{__('reports.vaccine_monitor_report') }}</p>
              <p class="print-ptag">{{__('reports.for_date') }} : {{$date_from}} 
                @if(isset($date_to))
                - {{$date_to}} 
                @endif </p>
            </div>
            <div class="table-div">
              <table class="table-print-style-1">
                <thead>
                  <tr>
                    <th rowspan="2">{{__('same.sl') }}</th>
                    <th rowspan="2">{{__('same.date') }}</th>
                    <th rowspan="2">{{__('reports.animal_id') }}</th>
                    <th rowspan="2">{{__('reports.stall_no') }}</th>
                    <th rowspan="2">{{__('reports.note') }}</th>
                    <th class="text-center" colspan="2">{{__('reports.vaccine_details') }}</th>
                  </tr>
                  <tr>
                    <th class="text-center width250"> {{__('reports.vaccine_name') }} </th>
                    <th class="text-center width250"> {{__('reports.remarks') }} </th>
                  </tr>
                </thead>
                <tbody>
                  <?php $sl = 0; ?>
                @if(isset($getJsonArr) && !empty($getJsonArr) && count($alldata)>0)
                @foreach($alldata as $data)
                <tr>
                  <td> {{++$sl}} </td>
                  <td> {{date('m/d/Y', strtotime($data->date))}} </td>
                  <td> 000{{$data->cow_id}} </td>
                  <td> {{$data->shed_number}} </td>
                  <td> {{$data->note}} </td>
                  <td colspan="2"><?php  
                        $dtlsArr = DB::table('cow_vaccine_monitor_dtls')
                                  ->leftJoin('vaccines', 'vaccines.id','cow_vaccine_monitor_dtls.vaccine_id')
                                  ->where('cow_vaccine_monitor_dtls.monitor_id', $data->id)
                                  ->select('vaccines.vaccine_name', 'vaccines.months', 'cow_vaccine_monitor_dtls.*')
                                  ->get();
                      ?>
                    <table class="print-child-table">
                      @foreach($dtlsArr as $dtlsArrData)
                      <tr>
                        <td class="width250"> {{$dtlsArrData->vaccine_name}} - ( {{$dtlsArrData->months}} Months ) </td>
                        <td class="width250"> {{$dtlsArrData->remarks}} </td>
                      </tr>
                      @endforeach
                    </table></td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="7" align="center"><h2>{{__('same.empty_row') }}</h2></td>
                </tr>
                @endif
                </tbody>
                
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