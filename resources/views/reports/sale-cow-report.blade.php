@extends('layouts.layout')
@section('title', __('reports.cow_sale_report'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="fa fa-area-chart"></i> {{__('reports.cow_sale_report') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active"><a>{{__('reports.cow_sale_report') }}</a></li>
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
      <div class="form-group"> {{Form::open(array('url'=>['cow-sale-report-search'],'method'=>'GET'))}}
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default mt20">
            <div class="panel-heading"><i class="fa fa-search"></i> {{__('reports.search_fields') }}</div>
            <div class="panel-body pb250">
              <div class="col-md-4">
                <input name="date_from" value="{{$date_from}}" id="date_from" class="form-control wsit_datepicker" placeholder="{{__('same.start_date') }}" type="text" required>
              </div>
              <div class="col-md-4">
                <input name="date_to"value="{{$date_to}}" id="dateTo" class="form-control wsit_datepicker" placeholder="{{__('same.end_date') }}" type="text" required>
              </div>
              <div class="col-md-4">
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
              <p class="print-ptag">{{__('reports.cow_sale_report') }}</p>
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
                    <th>{{__('reports.invoice') }}</th>
                    <th>{{__('same.date') }}</th>
                    <th>{{__('reports.customer_number') }}</th>
                    <th>{{__('reports.customer_name') }}</th>
                    <th>{{__('reports.address') }}</th>
                    <th class="text-right">{{__('reports.total_price') }}</th>
                    <th class="text-right">{{__('reports.total_paid') }}</th>
                    <th class="text-right">{{__('reports.due') }}</th>
                    <th class="text-right">{{__('reports.note') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                 $si = 1;
                $total = 0;
				$total_paid = 0;
				$total_due = 0;
				?>
                @if(isset($allData) && count($allData)>0)
                @foreach($allData as $data)
                <?php
				$total += (float)$data->total_price;
				$paid = DB::table('cow_sale_payments')->where('sale_id', $data->id)->sum('pay_amount');
				$total_paid += (float)$paid;
				$due = (float)$data->total_price - (float)$paid;
				$total_due += (float)$due;
				?>
                <tr style="background:<?php if((float)$due > 0) { ?>darkred;color:#fff;<?php } ?>">
                  <td> {{$si++}} </td>
                  <td> 000{{$data->id}} </td>
                  <td> {{  date('m/d/Y', strtotime($data->date))  }} </td>
                  <td> {{$data->customer_number}} </td>
                  <td> {{$data->customer_name}} </td>
                  <td> {{$data->address}} </td>
                  <td align="right"> {{App\Library\farm::currency($data->total_price)}} </td>
                  <td align="right"> {{App\Library\farm::currency($paid)}} </td>
                  <td align="right"> {{App\Library\farm::currency($due)}} </td>
                  <td align="right"> {{$data->note}} </td>
                </tr>
                @endforeach
                
                @else
                <tr>
                  <td colspan="15" align="center"><b>{{__('same.empty_row') }}</b></td>
                </tr>
                @endif
                </tbody>
                
                <?php if(!empty($total)) { ?>
                <tfoot>
                  <tr>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right"> {{ App\Library\farm::currency($total) }}</td>
                    <td align="right"> {{ App\Library\farm::currency($total_paid) }}</td>
                    <td align="right"> {{ App\Library\farm::currency($total_due) }}</td>
                    <td align="right">&nbsp;</td>
                  </tr>
                </tfoot>
                <?php } ?>
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