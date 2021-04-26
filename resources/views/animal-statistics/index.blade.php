@extends('layouts.layout')
@section('title', __('reports.animal_statistics'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="fa fa-pie-chart"></i> {{__('reports.animal_statistics') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
	<li class="active">{{__('reports.animal_statistics') }}</li>
  </ol>
</section>
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="{{  url('animal-statistics')  }}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> <b> {{__('same.refresh') }}</b></a> &nbsp;&nbsp; </div>
    <div class="box-body">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading feed-heading"><i class="icon-list"></i>&nbsp;{{__('reports.animal_statistics_report') }} :</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="shed_no">{{__('reports.stall_no') }} <span class="validate">*</span> : </label>
                    <select class="form-control load-cow-statistics-page" name="shed_no" id="shed_no" data-url="{{URL::to('load-cow-report')}}" required>
                      	<option value="0">{{__('same.select') }}</option>
						@foreach($all_sheds as $sheds)
                      		<option value="{{$sheds->id}}" {{(!empty($single_data))?($sheds->id==$single_data->shed_no)?'selected':'':''}}>{{$sheds->shed_number}}</option>
						@endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="cow_id">{{__('reports.animal_id') }} <span class="validate">*</span> : </label>
                    <select class="form-control animal-ajax-statistics" name="cow_id" id="cow_id" data-url="{{URL::to('animal-monitor-statistics')}}" required>
                      	<option value="0">{{__('same.select') }}</option>
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
    </div>
  </div>
</section>
@endsection 