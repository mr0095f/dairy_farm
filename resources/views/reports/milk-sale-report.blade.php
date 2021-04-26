@extends('layouts.layout')
@section('title', __('reports.milk_sale_report'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="fa fa-area-chart"></i> {{__('reports.milk_sale_report') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active"><a>{{__('reports.milk_sale_report') }}</a></li>
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
      <div class="form-group"> {!! Form::open(array('url' => 'get-milk-sale-report','class'=>'form-horizontal','autocomplete'=>'off','method' =>'GET')) !!}
        <div class="col-md-12">
          <div class="panel panel-default mt20">
            <div class="panel-heading"><i class="fa fa-search"></i> {{__('reports.search_fields') }}</div>
            <div class="panel-body pb250">
              <div class="col-md-3">
                <input name="account_number" value="{{isset($account_number)?$account_number:''}}" class="form-control" placeholder="{{__('reports.milk_account_no') }}" type="text">
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
                <input name="date_to" value="" id="date_to" class="form-control" placeholder="{{__('same.end_date') }}" type="text" selected required>
                @endif </div>
              @else
              <div class="col-md-3">
                <input name="date_to" value="" id="dateTo" class="form-control wsit_datepicker" placeholder="{{__('same.end_date') }}" type="text" selected required>
              </div>
              @endif
              <div class="col-md-3">
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
              <p class="print-ptag">{{__('reports.milk_sale_report') }}</p>
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
                    <th>{{__('reports.milk_account_no') }}</th>
                    <th>{{__('reports.supplier_name') }}</th>
                    <th>{{__('reports.contact') }}</th>
                    <th>{{__('reports.litre') }}</th>
                    <th>{{__('reports.rate') }}</th>
                    <th class="text-right">{{__('same.total') }}</th>
                    <th class="text-right">{{__('reports.paid') }}</th>
                    <th class="text-right">{{__('reports.due') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $totalamount = $totalLitter = $totalPaid = $totalDue = $sl = 0; ?>
                @if(isset($getJsonArr) && !empty($getJsonArr) && count($alldata)>0)
                @foreach($alldata as $data)
                <?php 
					$total_amount_paid = $data->collectPayments()->sum('pay_amount');
					$total_amount_due = (float)$data->total_amount - (float)$total_amount_paid;
					
					$totalPaid += $total_amount_paid;
					$totalDue += $total_amount_due;
					
					$totalamount += $data->total_amount;
              
                    $totalLitter += $data->litter;
                  ?>
                <tr style="background:<?php if((float)$totalDue > 0) { ?>darkred;color:#fff;<?php } ?>">
                  <td> {{++$sl}} </td>
                  <td> {{date('m/d/Y', strtotime($data->date))}} </td>
                  <td> {{$data->milk_account_number}} </td>
                  <td> {{$data->name}} </td>
                  <td> {{$data->contact}} </td>
                  <td> {{$data->litter}} </td>
                  <td> {{App\Library\farm::currency($data->rate)}} </td>
                  <td align="right"> {{App\Library\farm::currency($data->total_amount)}} </td>
                  <td align="right"> {{App\Library\farm::currency($total_amount_paid)}} </td>
                  <td align="right"> {{ App\Library\farm::currency($total_amount_due)}} </td>
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
                    <td colspan="5" align="right"><strong>{{__('same.total') }} :</strong></td>
                    <td> {{ number_format($totalLitter, 2) }}</td>
                    <td>&nbsp;</td>
                    <td align="right"> {{ App\Library\farm::currency($totalamount) }}</td>
                    <td align="right"> {{ App\Library\farm::currency($totalPaid) }}</td>
                    <td align="right"> {{ App\Library\farm::currency($totalDue) }}</td>
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