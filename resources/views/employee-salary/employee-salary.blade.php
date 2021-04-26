@extends('layouts.layout')
@section('title', __('salarylist.salary_title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="icon-people"></i> {{__('salarylist.salary_title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active"> {{__('salarylist.salary_title') }}</li>
  </ol>
</section>
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> @if( !empty($employeeSalary) )
      {{Form::open(array('route'=>['employee-salary.update',$employeeSalary->id],'method'=>'PUT','files'=>true))}}
      <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-floppy-o"></i> <b>{{__('salarylist.update_information') }}</b></button>
      <?php $display = 'block'; ?>
      @else
      {!! Form::open(array('route' => 'employee-salary.store','class'=>'form-horizontal','method' =>'POST','files'=>true)) !!}
      <button type="submit" class="btn btn-success btn-sm" id="submit"><i class="fa fa-floppy-o"></i> <b>{{__('salarylist.save_information') }}</b></button>
      <?php $display = 'none'; ?>
      @endif
      &nbsp;&nbsp;<a href="{{  url('employee-salary')  }}" class="btn btn-primary btn-sm"><i class="fa fa-align-justify"></i> <b>{{__('salarylist.view_list') }}</b></a> </div>
    <div class="box-body">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="icon-list"></i> {{__('salarylist.salary_info') }}</div>
          <div class="panel-body">
            <div class="form-group">
              <label for="paydate">{{__('salarylist.pay_date') }} <span class="validate">*</span> :</label>
              <input type="text" name="paydate" id="paydate" value="{{isset($employeeSalary->paydate)?date('m/d/Y', strtotime($employeeSalary->paydate)):old('paydate')  }}" class="form-control wsit_datepicker" placeholder="MM/DD/YYYY" required>
            </div>
            <div class="form-group">
              <label for="years">{{__('salarylist.select_month') }} <span class="validate">*</span> :</label>
              <select class="form-control" name="month" id="years" required>
                <option value="">{{__('same.select') }}</option>
              	@if(isset($employeeSalary)) 
                	@foreach(months() as $key => $months)
                	<option value="{{$key}}" {{($employeeSalary->month==$key) ? 'selected':''}}>{{$months}}</option>
                	@endforeach
              	@else
                	@foreach(months() as $key => $months)
                		<option value="{{$key}}">{{$months}}</option>
                	@endforeach
              	@endif
              </select>
            </div>
            <div class="form-group">
              <label for="years">{{__('salarylist.select_year') }} <span class="validate">*</span> :</label>
              <select class="form-control" name="year" id="years" required>
                <option value="">{{__('same.select') }}</option>
                  @if(isset($employeeSalary))
                      @foreach(years() as $year)
                		<option value="{{$year}}" {{($employeeSalary->year==$year) ? 'selected':''}}>{{$year}}</option>
                      @endforeach
                  @else
                      @foreach(years() as $year)
                		<option value="{{$year}}">{{$year}}</option>
                      @endforeach
                  @endif
              </select>
            </div>
            <div class="form-group">
              <label for="employeeList">{{__('salarylist.select_employee') }} <span class="validate">*</span> :</label>
              <select class="form-control" name="employee_id" id="employeeList" required>
                <option value="">{{__('same.select') }}</option>
                  @if(!empty($employeeSalary))
                    @foreach($allEmployee as $employee)
                		<option value="{{$employee->id}}" {{($employeeSalary->employee_id==$employee->id) ? 'selected':''}} data-salary="{{$employee->gross_salary}}">{{$employee->name}} ( ID #{{$employee->id}} )</option>
                    @endforeach
                  @else
                  	@foreach($allEmployee as $employee)
                		<option value="{{$employee->id}}" data-salary="{{$employee->gross_salary}}"> {{$employee->name}} ( ID #{{$employee->id}} ) </option>
                    @endforeach
                  @endif
              </select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="salary">{{__('salarylist.month_salary') }} :</label>
                  <input type="text" name="salary" id="salary" value="{{isset($employeeSalary->salary)?$employeeSalary->salary:old('salary')  }}" class="form-control decimal" placeholder="Salary" required readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="addition_money">{{__('salarylist.addition_money') }} :</label>
                  <input type="text" name="addition_money" id="addition_money" value="{{isset($employeeSalary->addition_money)?$employeeSalary->addition_money:old('addition_money')  }}" class="form-control decimal" placeholder="Addition Money">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="note">{{__('salarylist.note') }} :</label>
              <textarea name="note" class="form-control">{{isset($employeeSalary->note)?$employeeSalary->note:old('note')  }}</textarea>
            </div>
          </div>
        </div>
      </div>
      {!! Form::close() !!} </div>
  </div>
</section>
@endsection 