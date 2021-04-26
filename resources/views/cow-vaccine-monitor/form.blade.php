@extends('layouts.layout')
@section('title', __('cow_vaccine_monitor.cow_vaccine_monitor'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="fa fa-eyedropper"></i> {{__('cow_vaccine_monitor.cow_vaccine_monitor') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
	<li class="active">{{__('cow_vaccine_monitor.cow_vaccine_monitor') }}</li>
  </ol>
</section>
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success"> @if(empty($single_data))
    {{  Form::open(array('route' => 'vaccine-monitor.store', 'method' => 'post', 'files' => true))  }}
    <?php $btn_name = __('same.save'); ?>
    @else
    {{  Form::open(array('route' => ['vaccine-monitor.update',$single_data->id], 'method' => 'PUT', 'files' => true))  }}
    <?php $btn_name = __('same.update'); ?>
    @endif
    <div class="box-header with-border" align="right">
      <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-floppy-o"></i> <b>{{$btn_name}} {{__('same.information') }}</b></button>
      <a href="{{  url('vaccine-monitor/create')  }}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> <b> {{__('same.refresh') }}</b></a> &nbsp;&nbsp; </div>
    <div class="box-body">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading feed-heading"><i class="fa fa-info-circle"></i>&nbsp;{{__('cow_vaccine_monitor.animal_information') }} :</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="shed_no">{{__('cow_vaccine_monitor.stall_no') }} <span class="validate">*</span> : </label>
                    <select class="form-control load-cow-vacine-page" name="shed_no" id="shed_no" data-url="{{URL::to('load-cow')}}" required>
                      <option value="">{{__('same.select') }}</option>
						@foreach($all_sheds as $sheds)
                      		<option value="{{$sheds->id}}" {{(!empty($single_data))?($sheds->id==$single_data->shed_no)?'selected':'':''}}>{{$sheds->shed_number}}</option>
						@endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="cow_id">{{__('cow_vaccine_monitor.cow_no') }} <span class="validate">*</span> : </label>
                    <select class="form-control animal-details-by-stall-no" name="cow_id" id="cow_id" data-url="{{URL::to('animal-details')}}" required>
                      <option value="">{{__('same.select') }}</option>
						@if(isset($single_data))
							@foreach($cowArr as $cowArrData)
	  							<option value="{{$cowArrData->id}}" {{($cowArrData->id==$single_data->cow_id)?'selected':''}}>000{{$cowArrData->id}}</option>
							@endforeach
						@endif
                    </select>
                  </div>
                </div>
                <div class="col-md-12" id="animal-details" align="center"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading feed-heading"><i class="fa fa-edit"></i>&nbsp;{{__('cow_vaccine_monitor.vaccine_date_note') }} :</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="date">{{__('cow_vaccine_monitor.date') }} <span class="validate">*</span> : </label>
                    <input type="text" name="date" class="form-control wsit_datepicker" value="{{(!empty($single_data->date))?date('m/d/Y', strtotime($single_data->date)):''}}" required>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="note">{{__('cow_vaccine_monitor.note') }} : </label>
                    <textarea name="note" class="form-control">{{(!empty($single_data->note))?$single_data->note:''}}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading feed-heading"><i class="icon-list"></i>&nbsp;{{__('cow_vaccine_monitor.vaccines_list') }} :</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <table class="table table-responsive table-bordered table-striped">
                  	<th>{{__('cow_vaccine_monitor.vaccine_name') }}</th>
                    <th>{{__('cow_vaccine_monitor.dose') }}</th>
                    <th>{{__('cow_vaccine_monitor.repeat') }}</th>
                    <th>{{__('cow_vaccine_monitor.remarks') }}</th>
                    <th>{{__('cow_vaccine_monitor.given_time') }}</th>
                  <tbody>
                    <?php $row = 1; ?>
                  @foreach($vaccine_arr as $vaccine_data)
                  @if(isset($single_data))
                  <?php  
						$checkData = DB::table('cow_vaccine_monitor_dtls')
									 ->where('monitor_id', $single_data->id)
									 ->where('vaccine_id', $vaccine_data->id)
									 ->exists();
						if($checkData==true){
							$savedData = DB::table('cow_vaccine_monitor_dtls')
									 ->where('monitor_id', $single_data->id)
									 ->where('vaccine_id', $vaccine_data->id)
									 ->first();
						}
					?>
                  @endif
                  <tr>
                    <td><label class="checkbox-inline">
                      <input class="cow-veccine" id="veccine_{{$vaccine_data->id}}" type="checkbox" name="cow_vaccine[{{$row}}][vaccine_id]" value="{{$vaccine_data->id}}" {{(isset($checkData)?($checkData==true)?'checked':'':'')}}>
                      {{$vaccine_data->vaccine_name}} - ( {{$vaccine_data->months}} {{__('cow_vaccine_monitor.days') }} ) </label>
                    </td>
                    <td> {{$vaccine_data->dose}} </td>
                    <td align="center">@if((bool)$vaccine_data->repeat_vaccine)<i class="fa fa-check"></i>@else<i class="fa fa-close"></i>@endif</td>
                    <td><input type="text" name="cow_vaccine[{{$row}}][remarks]" class="form-control" value="{{(isset($checkData)?($checkData==true)?$savedData->remarks:'':'')}}">
                    </td>
                    <td><input type="text" name="cow_vaccine[{{$row}}][time]" class="form-control" value="{{(isset($checkData)?($checkData==true)?$savedData->time:'':'')}}">
                    </td>
                  </tr>
                  <?php $row++; ?>
                  @endforeach
                  </tbody>
                  
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {!! Form::close() !!} </div>
</section>
@endsection 