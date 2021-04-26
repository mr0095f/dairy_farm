@extends('layouts.layout')
@section('title', __('animal_pregnancy.title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="icon-symbol-female icons"></i> {{__('animal_pregnancy.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
	<li class="active">{{__('animal_pregnancy.title') }}</li>
  </ol>
</section>
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  {{  Form::open(array('route' => 'animal-pregnancy.store', 'method' => 'post', 'onsubmit' => 'return submitDeliveryForm();', 'files' => true))  }}
  <div class="box box-success">
    <div class="box-body">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading feed-heading"><i class="icon-list"></i>&nbsp;{{__('animal_pregnancy.animal_information') }} :</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="stall_no">{{__('animal_pregnancy.stall_no') }} <span class="validate">*</span> : </label>
                    <select class="form-control load-cow-pregnancy-page" name="stall_no" id="stall_no" data-url="{{URL::to('load-cow')}}" required>
                      <option value="">{{__('same.select') }}</option>
						@foreach($all_sheds as $sheds)
                      		<option value="{{$sheds->id}}" {{(!empty($single_data))?($sheds->id==$single_data->shed_no)?'selected':'':''}}>{{$sheds->shed_number}}</option>
						@endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="cow_id">{{__('animal_pregnancy.cow_no') }} <span class="validate">*</span> : </label>
                    <select class="form-control animal-details-by-stall-no" name="cow_id" id="cow_id" data-url="{{URL::to('animal-pregnancy-monitor')}}" required>
                      <option value="">{{__('same.select') }}</option>
							@if(isset($single_data))
								@foreach($cowArr as $cowArrData)
                      				<option value="{{$cowArrData->id}}" {{($cowArrData->id==$single_data->cow_id)?'selected':''}}>000{{$cowArrData->id}}</option>
								 @endforeach
							@endif
                    </select>
                  </div>
                </div>
                <div id="animal-details" align="center"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading feed-heading"><i class="icon-list"></i>&nbsp;{{__('animal_pregnancy.animal_pregnancy_details') }} :</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pregnancy_type_id">{{__('animal_pregnancy.pregnancy_type') }} <span class="validate">*</span> : </label>
                    <select class="form-control" name="pregnancy_type_id" id="pregnancy_type_id" required>
                      <option value="">{{__('same.select') }}</option>
						@foreach($pregnancy_types as $pregnancy_type)
                      		<option value="{{$pregnancy_type->id}}">{{$pregnancy_type->type_name}}</option>
						@endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="semen_type">{{__('animal_pregnancy.semen_type') }} : </label>
                    <select class="form-control" name="semen_type" id="semen_type">
                      <option value="0">{{__('same.select') }}</option>
						@foreach($animal_types as $animal_type)
                      		<option value="{{$animal_type->id}}">{{$animal_type->type_name}}</option>
						@endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="semen_push_date">{{__('animal_pregnancy.semen_push_date') }} : </label>
                    <input type="text" name="semen_push_date" placeholder="{{__('animal_pregnancy.mm_dd_YYYY') }}" class="form-control wsit_datepicker" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="pregnancy_start_date">{{__('animal_pregnancy.pregnancy_start_date') }} <span class="validate">*</span> : </label>
                    <input type="text" name="pregnancy_start_date" placeholder="{{__('animal_pregnancy.mm_dd_YYYY') }}" class="form-control wsit_datepicker_calc_p_date" value="" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="semen_cost">{{__('animal_pregnancy.semen_cost') }} : </label>
                    <input type="text" name="semen_cost" class="form-control" value="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="other_cost">{{__('animal_pregnancy.other_cost') }} : </label>
                    <input type="text" name="other_cost" class="form-control" value="">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="note">{{__('animal_pregnancy.note') }} : </label>
                    <textarea class="form-control" id="note" name="note"></textarea>
                  </div>
                </div>
                <div class="col-md-12" id="appx-dd">
                  <div class="form-group">
                    <div class="panel panel-default">
                      <div class="panel-body">
                        <div class="appox-dd">{{__('animal_pregnancy.axdd') }}</div>
                        <div id="app-date-box"></div>
                        <div class="progress-group" id="appox-progress-box"> <span class="progress-text">{{__('animal_pregnancy.approximate_delivery_progress') }}</span> <span class="progress-number"><b>0 </b>/283</span>
                          <div class="progress sm">
                            <div id="appox-delivery-days" class="progress-bar progress-bar-green pbar-init"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12" id="appx-dd">
                  <div class="form-group">
                    <div class="panel panel-default">
                      <div class="panel-body" align="right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <b>{{__('animal_pregnancy.save_information') }}</b></button>
                        <a href="{{  url('animal-pregnancy')  }}" class="btn btn-warning"><i class="fa fa-refresh"></i> <b> {{__('same.refresh') }}</b></a> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {!! Form::close() !!} </section>
@endsection 