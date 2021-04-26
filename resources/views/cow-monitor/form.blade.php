@extends('layouts.layout')
@section('title', __('cow_monitor.entry_title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="fa fa-tv"></i> {{__('cow_monitor.entry_title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
  </ol>
</section>
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success"> @if(empty($single_data))
    {{  Form::open(array('route' => 'cow-monitor.store', 'method' => 'post', 'files' => true))  }}
    <?php $btn_name = __('same.save'); ?>
    @else
    {{  Form::open(array('route' => ['cow-monitor.update',$single_data->id], 'method' => 'PUT', 'files' => true))  }}
    <?php $btn_name = __('same.update'); ?>
    @endif
    <div class="box-header with-border" align="right">
      <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-floppy-o"></i> <b>{{$btn_name}} {{__('same.information') }}</b></button>
      <a href="{{  url('cow-monitor/create')  }}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> <b> {{__('same.refresh') }}</b></a> &nbsp;&nbsp; </div>
    <div class="box-body">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading feed-heading"><i class="fa fa-info-circle"></i>&nbsp;{{__('cow_monitor.basic_information') }} :</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="shed_no">{{__('cow_monitor.stall_no') }} <span class="validate">*</span> : </label>
                    <select class="form-control loadCow" name="shed_no" id="shed_no" data-url="{{URL::to('load-cow')}}" required>
                      <option value="">{{__('same.select') }}</option>
						@foreach($all_sheds as $sheds)
                      		<option value="{{$sheds->id}}" {{(!empty($single_data))?($sheds->id==$single_data->shed_no)?'selected':'':''}}>{{$sheds->shed_number}}</option>
						@endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="cow_id">{{__('cow_monitor.cow_no') }} <span class="validate">*</span> : </label>
                    <select class="form-control animal-details-by-stall-no" name="cow_id" id="cow_id" data-url="{{URL::to('animal-monitor-details')}}" required>
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
          <div class="panel-heading feed-heading"><i class="fa fa-edit"></i>&nbsp;{{__('cow_monitor.notes_result') }} :</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="weight">{{__('cow_monitor.animal_updated_weight') }} <span class="validate">*</span> : </label>
                    <input id="weight" type="text" name="weight" class="form-control decimal" value="{{(!empty($single_data->weight))?$single_data->weight:''}}" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="height">{{__('cow_monitor.updated_height') }} <span class="validate">*</span> : </label>
                    <input id="height" type="text" name="height" class="form-control decimal" value="{{(!empty($single_data->height))?$single_data->height:''}}" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="milk">{{__('cow_monitor.updated_milk') }} : </label>
                    <input id="milk" type="text" name="milk" class="form-control decimal" value="{{(!empty($single_data->milk))?$single_data->milk:''}}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="date">{{__('cow_monitor.monitoring_date') }} <span class="validate">*</span> : </label>
                    <input id="date" type="text" name="date" class="form-control wsit_datepicker" value="{{(!empty($single_data->date))?date('m/d/Y', strtotime($single_data->date)):''}}" required>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="note">{{__('cow_monitor.reports') }} : </label>
                    <textarea id="note" name="note" class="form-control">{{(!empty($single_data->note))?$single_data->note:''}}</textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group" align="center">
                    <label for="note"><u>{{__('cow_monitor.cow_health_score') }}</u> </label>
                    <input type="text" id="health_score" name="health_score" value="" data-skin="big" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading feed-heading"> <i class="fa fa-image"></i> {{__('cow_monitor.updated_images') }}
            <button type="button" name="" id="increaserf" onclick="addMoreImage();" data-toggle="tooltip" class="btn btn-success btn-xs pull-right"><i class="fa fa-plus-circle"></i>&nbsp; {{__('cow_monitor.add_images') }}</button>
          </div>
          <?php $num_row = 0; ?>
          <div class="panel-body" id="imageBlock"> @if(isset($single_data->new_images) && !empty($single_data->new_images))
            @foreach(explode('_', $single_data->new_images) as $imageName)
            <div class="col-md-3 monitor-img-box" id="div_{{$num_row}}">
              <div class="monitor-img-box-2">
                <div class="upload-box-style"><a onclick="$('#div_{{$num_row}}').remove();" class="fa fa-times upload-builder-3a"></a> &nbsp; </div>
                <img src="{{asset('storage/app/public/uploads/animal/'.$imageName)}}" class="upload-builder-img" id="previewImage_{{$num_row}}">
                <div class="upload-builder-4">
                  <input type="hidden" class="imgHdn" name="exitesPreviousImage[]" value="{{$imageName}}">
                  <label class="btn btn-success btn-xs btn-file upload-builder-5"> <i class="fa fa-folder-open"></i>&nbsp;&nbsp; {{__('cow_monitor.upload_image') }}
                  <input type="file" class="hideme" name="animal_image[]" id="inputImage_{{$num_row}}" onchange="monitor_preview_Images(this);">
                  </label>
                </div>
              </div>
            </div>
            <?php $num_row++; ?>
            @endforeach
            @else
            <div class="col-md-3 monitor-img-box"id="div_{{$num_row}}">
              <div class="monitor-img-box-2">
                <div class="upload-box-style"><a onclick="$('#div_{{$num_row}}').remove();" class="fa fa-times upload-builder-3a"></a> &nbsp; </div>
                <img src="{{asset('public/custom/img/noImage.jpg')}}" class="upload-builder-img" id="previewImage_{{$num_row}}">
                <div class="upload-builder-4">
                  <label class="btn btn-success btn-xs btn-file upload-builder-5"> <i class="fa fa-folder-open"></i>&nbsp;&nbsp; {{__('cow_monitor.upload_image') }}
                  <input type="file" name="animal_image[]" id="inputImage_{{$num_row}}" onchange="monitor_preview_Images(this);" class="hideme">
                  </label>
                </div>
              </div>
            </div>
            @endif </div>
        </div>
      </div>
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading feed-heading"><i class="fa fa-info-circle"></i>&nbsp; {{__('cow_monitor.monitor_information') }} :</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <table class="table table-responsive table-bordered table-striped">
                  <th>{{__('cow_monitor.service_name') }}</th>
                    <th>{{__('cow_monitor.result') }}</th>
                    <th>{{__('cow_monitor.monitoring_time') }}</th>
                  <tbody>
                    <?php $row = 1; ?>
                  @foreach($service_arr as $service_data)
                  @if(isset($single_data))
                  <?php  
						$checkData = DB::table('cow_monitor_dtls')
									 ->where('monitor_id', $single_data->id)
									 ->where('service_id', $service_data->id)
									 ->exists();
						if($checkData==true){
							$savedData = DB::table('cow_monitor_dtls')
									 ->where('monitor_id', $single_data->id)
									 ->where('service_id', $service_data->id)
									 ->first();
						}
					?>
                  @endif
                  <tr>
                    <td><label class="checkbox-inline">
                      <input type="checkbox" name="cow_service[{{$row}}][service_id]" value="{{$service_data->id}}" {{(isset($checkData)?($checkData==true)?'checked':'':'')}}>
                      {{$service_data->service_name}} </label>
                    </td>
                    <td><input type="text" name="cow_service[{{$row}}][result]" class="form-control" value="{{(isset($checkData)?($checkData==true)?$savedData->result:'':'')}}">
                    </td>
                    <td><input type="text" name="cow_service[{{$row}}][time]" class="form-control" value="{{(isset($checkData)?($checkData==true)?$savedData->time:'':'')}}">
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
<input type="hidden" id="health_data" value="{{(!empty($single_data->health_score)) ? $single_data->health_score : 0}}" />
<input type="hidden" id="num_row" value="{{ $num_row }}" />
<input type="hidden" id="no_image" value="{{asset('public/custom/img/noImage.jpg')}}" />
<input type="hidden" id="upload_image" value="{{__('cow_monitor.upload_image') }}" />
@endsection 