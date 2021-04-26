@extends('layouts.layout')
@section('title', __('reports.salary_report_title'))
@section('content')
<section class="content-header">
  <h1><i class="fa fa-area-chart"></i> {{__('reports.salary_report_title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active"><a href="{{URL::to('employee-salary-report')}}"> {{__('reports.salary_report_title') }}</a></li>
  </ol>
</section>
<?php
$configuration_data = \App\Library\farm::get_system_configuration('system_config');
$branch_info =  \App\Library\farm::branchInfo();
?>
<section class="content"> @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success">
    <div class="box-body">
      <div class="form-group">
        <div class="col-md-12">
          <div class="panel panel-default mt20">
            <div class="panel-heading"> <i class="fa fa-info-circle"></i> {{__('reports.search_title') }} </div>
            <div class="panel-body"> {!! Form::open(array('route' => 'employee-salary-report.store','class'=>'form-horizontal','method' =>'POST')) !!}
              <div class="col-md-3">
                <select class="form-control" name="month">
                  <option value="0">{{__('reports.select_a_month') }}</option>
                    @foreach(months() as $key => $months)
                  <option value="{{$key}}" {{(!empty($selected_month))?($selected_month==$key)?'selected':'':''}}>{{$months}}</option>
                    @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-control" name="year">
                  <option value="0">{{__('reports.select_a_year') }}</option>
                    @foreach(years() as $year)
                  <option value="{{$year}}" {{(!empty($selected_year))?($selected_year==$year)?'selected':'':''}}>{{$year}}</option>
                    @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-control" name="employee_id">
                  <option value="0">{{__('reports.select_an_employee') }}</option>
                    @foreach($employees as $employee)
                  <option value="{{$employee->id}}" {{(!empty($selected_employee_id))?($selected_employee_id==$employee->id)?'selected':'':''}}>{{$employee->name}}</option>
                    @endforeach
                </select>
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-success print-submit"> <i class="fa fa-search"></i> {{__('same.search') }}</button>
              </div>
              {!! Form::close() !!} </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  @if(isset($result))
  @if(!empty($result))
  <div class="box box-success">
    <div class="box-body">
      <div id="print_icon"><a class="printReports" href="javascript:;"><img class="img-thumbnail" src='{{asset("storage/app/public/common/print.png")}}'></a></div>
      <br>
      <br>
      <div id="printBox">
        <div class="table-responsive" id="printTable">
          <div class="col-md-12 print-base">
            <p>@if(!empty($configuration_data) && !empty($configuration_data->logo))<img src="{{asset("storage/app/public/uploads/$configuration_data->logo")}}"/>@endif</p>
            <p class="print-ptag">@if(!empty($configuration_data) && !empty($configuration_data->topTitle)){{$configuration_data->topTitle}}@endif</p>
            <?php if(!empty($branch_info->branch_name)) { ?>
            <p class="print-ptag">{{$branch_info->branch_name}}</p>
            <?php } ?>
            <p class="print-ptag">{{__('reports.employee_salary_report') }}</p>
          </div>
          <table class="table-print-style-2">
            <tr class="header-top">
              <th class="text-center">{{__('reports.pay_date') }}</th>
              <th>{{__('reports.employee_name') }}</th>
              <th>{{__('reports.contact_number') }}</th>
              <th>{{__('reports.designation') }}</th>
              <th class="text-right">{{__('reports.salary_amount') }}</th>
              <th class="text-right">{{__('reports.addition_amount') }}</th>
              <th class="text-right">{{__('reports.total_pay_amount') }}</th>
              <th class="text-center">{{__('reports.remarks') }}</th>
            </tr>
            <tbody>
              <?php 
              $year_arr = array(); $month_arr=array(); 
              $totalSalary = $totalAddition = $final = 0;
            ?>
            @foreach($result as $salary_data)
            
            @if(!in_array($salary_data->year, $year_arr))
            <?php $year_arr[$salary_data->year]=$salary_data->year; ?>
            <tr>
              <td colspan="8" class="report-year"> {{__('reports.year') }} : {{$salary_data->year}} </td>
            </tr>
            @endif
            
            @if(empty($month_arr[$salary_data->year][$salary_data->month]))
            <?php $month_arr[$salary_data->year][$salary_data->month]=$salary_data->month; ?>
            <tr>
              <td colspan="8" class="report-month"> {{__('reports.month') }} : {{months()[$salary_data->month]}} </td>
            </tr>
            @endif
            <tr class="base-loop-row">
              <td class="text-center">{{date('m/d/Y', strtotime($salary_data->paydate))}}</td>
              <td>{{$salary_data->name}}</td>
              <td>{{$salary_data->phone_no}}</td>
              <td>{{$salary_data->designation_name}}</td>
              <td class="text-right"> {{App\Library\farm::currency($salary_data->salary)}}
                <?php  
                    $totalSalary += $salary_data->salary;
                  ?>
              </td>
              <td class="text-right"> {{App\Library\farm::currency($salary_data->addition_money)}}
                <?php  
                    $totalAddition += $salary_data->addition_money;
                  ?>
              </td>
              <td class="text-right"> {{App\Library\farm::currency($salary_data->salary+$salary_data->addition_money)}}
                <?php 
                    $final += $salary_data->salary+$salary_data->addition_money;
                  ?>
              </td>
              <td class="text-center">{{$salary_data->note}}</td>
            </tr>
            @endforeach
            </tbody>
            
            <tfoot>
              <tr>
                <th class="text-right" colspan="4">{{__('same.total') }} : </th>
                <th class="text-right"> {{App\Library\farm::currency($totalSalary)}} </th>
                <th class="text-right"> {{App\Library\farm::currency($totalAddition)}} </th>
                <th class="text-right"> {{App\Library\farm::currency($final)}} </th>
                <th class="text-center">&nbsp;</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer"> </div>
    <!-- /.box-footer-->
  </div>
  @else
  <div class="box box-success">
    <div class="box-body" align="center" class="salarynoprintdata">{{__('same.empty_row') }}</div>
  </div>
  @endif
  @endif
  <!-- /.box -->
</section>
{!!Html::style('public/custom/css/report.css')!!}
<input type="hidden" id="print_url_1" value='{!!Html::style("public/custom/css/bootstrap.min.css")!!}' />
<input type="hidden" id="print_url_2" value='{!!Html::style("public/custom/css/report.css")!!}' />
<input type="hidden" id="print_url_3" value='{!!Html::style("public/custom/css/AdminLTE.css")!!}' />
<!-- /.content -->
@endsection 