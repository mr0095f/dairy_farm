@extends('layouts.layout')
@section('title',  __('manage_cow.animal_information'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="fa fa-paw"></i> {{__('manage_cow.animal_information') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
	<li class="active">{{__('manage_cow.animal_information') }}</li>
  </ol>
</section>
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success"> @if(empty($single_data))
    {{  Form::open(array('route' => 'animal.store', 'method' => 'post', 'files' => true))  }}
    <?php $btn_name = __('same.save'); ?>
    @else
    {{  Form::open(array('route' => ['animal.update',$single_data->id], 'method' => 'PUT', 'files' => true))  }}
    <?php $btn_name = __('same.update'); ?>
    @endif
    <div class="box-header with-border" align="right">
      <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-floppy-o"></i> <b>{{$btn_name}} {{__('manage_cow.information') }}</b></button>
      <a href="{{  url('animal/create')  }}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> <b> {{__('same.refresh') }}</b></a> &nbsp;&nbsp; </div>
    <div class="box-body">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading feed-heading"><i class="fa fa-info-circle"></i>&nbsp;{{__('manage_cow.basic_information') }}</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="DOB">{{__('manage_cow.dob') }} <span class="validate">*</span> : </label>
                    <input id="DOB" type="text" name="DOB" placeholder="{{__('manage_cow.mmy') }}" class="form-control age_datepicker" value="{{(!empty($single_data->DOB))?Carbon\Carbon::parse($single_data->DOB)->format('m/d/Y'):''}}" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="age">{{__('manage_cow.age') }} <span class="validate">*</span> : </label>
                    <div class="input-group">
                      <input type="text" name="age" id="age" class="form-control" value="{{(!empty($single_data->age))?$single_data->age:''}}" required>
                      <span class="input-group-addon animal-month">{{(!empty($single_data->age))?number_format((float)$single_data->age / 30,2,".","."):'0 '}} Month</span> </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="weight">{{__('manage_cow.weight') }} <span class="validate">*</span> : </label>
                    <input type="text" name="weight" class="form-control" value="{{(!empty($single_data->weight))?$single_data->weight:''}}" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="height">{{__('manage_cow.height') }} <span class="validate">*</span> : </label>
                    <input type="text" name="height" class="form-control" value="{{(!empty($single_data->height))?$single_data->height:''}}" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="gender">{{__('manage_cow.gender') }} : </label>
                    <select class="form-control" name="gender">
                      <option value="{{__('manage_cow.male') }}" {{(!empty($single_data->gender))?($single_data->gender==__('manage_cow.male'))?'selected':'':''}}>{{__('manage_cow.male') }}</option>
                      <option value="{{__('manage_cow.female') }}" {{(!empty($single_data->gender))?($single_data->gender==__('manage_cow.female'))?'selected':'':''}}>{{__('manage_cow.female') }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="color">{{__('manage_cow.color') }} : </label>
                    <select class="form-control" name="color">
                      <option value="0">{{__('same.select') }}</option>
                      
							    		@foreach($all_colors as $colors)
							    		
                      <option value="{{$colors->id}}" {{(!empty($single_data))?($colors->id==$single_data->color)?'selected':'':''}}>{{$colors->color_name}}</option>
                      
							    		@endforeach
								    
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="animal_type">{{__('manage_cow.animal_type') }} <span class="validate">*</span> : </label>
                    <select class="form-control" name="animal_type" required>
                      <option value="">{{__('same.select') }}</option>
                      
								    	@foreach($all_animal_type as $animal_types)
							    		
                      <option value="{{$animal_types->id}}" {{(!empty($single_data))?($animal_types->id==$single_data->animal_type)?'selected':'':''}}>{{$animal_types->type_name}}</option>
                      
							    		@endforeach
								    
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pregnant_status">{{__('manage_cow.pregnant_status') }} : </label>
                    <select class="form-control" name="pregnant_status">
                      <option value="0" {{(!empty($single_data->pregnant_status))?($single_data->pregnant_status=='0')?'selected':'':''}}>{{__('same.no') }}</option>
                      <option value="1" {{(!empty($single_data->pregnant_status))?($single_data->pregnant_status=='1')?'selected':'':''}}>{{__('same.yes') }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="before_no_of_pregnant">{{__('manage_cow.nop') }} : </label>
                    <input type="text" name="before_no_of_pregnant" class="form-control" value="{{(!empty($single_data->before_no_of_pregnant))?$single_data->before_no_of_pregnant:''}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pregnancy_time">{{__('manage_cow.pregnancy_time') }} : </label>
                    <input type="text" name="pregnancy_time" class="form-control wsit_datepicker" placeholder="{{__('manage_cow.mmy') }}" value="{{(!empty($single_data->pregnancy_time))?date('m/d/Y', strtotime($single_data->pregnancy_time)):''}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="milk_ltr_per_day">{{__('manage_cow.milk_per_day') }} : </label>
                    <input type="text" name="milk_ltr_per_day" class="form-control" value="{{(!empty($single_data->milk_ltr_per_day))?$single_data->milk_ltr_per_day:''}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="buy_from">{{__('manage_cow.buy_form') }} : </label>
                    <input type="text" name="buy_from" class="form-control" value="{{(!empty($single_data->buy_from))?$single_data->buy_from:''}}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="buying_price">{{__('manage_cow.buying_price') }} <span class="validate">*</span> : </label>
                    <input type="text" name="buying_price" class="form-control" value="{{(!empty($single_data->buying_price))?$single_data->buying_price:''}}" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="buy_date">{{__('manage_cow.buy_date') }} <span class="validate">*</span> : </label>
                    <input type="text" name="buy_date" class="form-control wsit_datepicker" placeholder="Month/Day/Year" value="{{(!empty($single_data->buy_date))?date('m/d/Y', strtotime($single_data->buy_date)):''}}" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="shade_no">{{__('manage_cow.stall_no') }} <span class="validate">*</span> : </label>
                    <select class="form-control" name="shade_no" required>
                      <option value="">{{__('same.select') }}</option>
                      
								    	@foreach($all_sheds as $sheds)
							    		
                      <option value="{{$sheds->id}}" {{(!empty($single_data))?($sheds->id==$single_data->shade_no)?'selected':'':''}}>{{$sheds->shed_number}} <?php echo $sheds->status=='1' ? ' ('.__('manage_cow.booked').')' : ' ('.__('manage_cow.available').')'; ?></option>
                      
							    		@endforeach
								    
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="previous_vaccine_done">{{__('manage_cow.previous_vaccine_done') }} : </label>
                    <select class="form-control" name="previous_vaccine_done">
                      <option value="{{__('same.no') }}" {{(!empty($single_data->previous_vaccine_done))?($single_data->previous_vaccine_done==__('same.no'))?'selected':'':''}}>{{__('same.no') }}</option>
                      <option value="{{__('same.yes') }}" {{(!empty($single_data->previous_vaccine_done))?($single_data->previous_vaccine_done==__('same.no'))?'selected':'':''}}>{{__('same.yes') }}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="note">{{__('manage_cow.note') }} : </label>
                    <textarea id="note" name="note" class="form-control">{{(!empty($single_data->note))?$single_data->note:''}}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading feed-heading"><i class="fa fa-medkit"></i>&nbsp;{{__('manage_cow.select_previouse_vaccine_done') }}</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12"> @if(isset($single_data->vaccines))
                <?php $vaccines = json_decode($single_data->vaccines, true);?>
                @foreach($all_vaccines as $all_vaccine_info)
                <div class="col-md-4">
                  <label class="checkbox-inline">
                  <?php if(!empty($vaccines)) { ?>
                  <input type="checkbox" name="vaccines[]" value="{{$all_vaccine_info->id}}" {{in_array($all_vaccine_info->
                  id, $vaccines)?'checked':''}}>
                  {{$all_vaccine_info->vaccine_name}} - ( {{$all_vaccine_info->months}} {{__('manage_cow.day') }} )
                  <?php } else { ?>
                  <input type="checkbox" name="vaccines[]" value="{{$all_vaccine_info->id}}">
                  {{$all_vaccine_info->vaccine_name}} - ( {{$all_vaccine_info->months}} {{__('manage_cow.day') }} )
                  <?php } ?>
                  </label>
                </div>
                @endforeach
                @else
                @foreach($all_vaccines as $all_vaccine_info)
                <div class="col-md-4">
                  <label class="checkbox-inline">
                  <input type="checkbox" name="vaccines[]" value="{{$all_vaccine_info->id}}">
                  {{$all_vaccine_info->vaccine_name}} - ( {{$all_vaccine_info->months}} {{__('manage_cow.day') }} ) </label>
                </div>
                @endforeach
                @endif </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading feed-heading"> <i class="fa fa-image"></i> {{__('manage_cow.animal_images') }}
            <button type="button" name="" id="increaserf" onclick="manageCowImageRow();" data-toggle="tooltip" class="btn btn-success btn-xs pull-right"><i class="fa fa-plus-circle"></i>&nbsp; {{__('manage_cow.add_images') }}</button>
          </div>
          <?php $num_row = 0; ?>
          <div class="panel-body" id="imageBlock"> @if(isset($single_data->pictures) && !empty($single_data->pictures))
            @foreach(explode('_', $single_data->pictures) as $imageName)
            <div class="col-md-2 animal-box-height" id="div_{{$num_row}}">
              <div class="upload-builder-2">
                <div class="upload-builder-3"><a onclick="$('#div_{{$num_row}}').remove();" class="fa fa-times upload-builder-3a"></a> &nbsp; </div>
                <img src="{{asset('storage/app/public/uploads/animal/'.$imageName)}}" class="manage-animal-upload" id="previewImage_{{$num_row}}">
                <div class="manage-animal-upload-2">
                  <input type="hidden" class="imgHdn" name="exitesPreviousImage[]" value="{{$imageName}}">
                  <label class="btn btn-success btn-xs btn-file upload-builder-5"> <i class="fa fa-folder-open"></i>&nbsp;&nbsp; {{__('manage_cow.upload_image') }}
                  <input type="file" name="animal_image[]" id="inputImage_{{$num_row}}" class="hideme" onchange="preview_Images_manage_cow(this);">
                  </label>
                </div>
              </div>
            </div>
            <?php $num_row++; ?>
            @endforeach
            @else
            <div class="col-md-2 animal-box-height" id="div_{{$num_row}}">
              <div class="upload-builder-2">
                <div class="upload-builder-3"><a onclick="$('#div_{{$num_row}}').remove();" class="fa fa-times upload-builder-3a"></a> &nbsp; </div>
                <img src="{{asset('public/custom/img/noImage.jpg')}}" class="manage-animal-upload" id="previewImage_{{$num_row}}">
                <div class="manage-animal-upload-2">
                  <label class="btn btn-success btn-xs btn-file upload-builder-5"> <i class="fa fa-folder-open"></i>&nbsp;&nbsp; {{__('manage_cow.upload_image') }}
                  <input type="file" name="animal_image[]" id="inputImage_{{$num_row}}" class="hideme" onchange="preview_Images_manage_cow(this);">
                  </label>
                </div>
              </div>
            </div>
            @endif </div>
        </div>
      </div>
    </div>
    {!! Form::close() !!} </div>
</section>
<input type="hidden" id="num_row_cs" value="{{ $num_row }}" />
<input type="hidden" id="no_image" value="{{asset('public/custom/img/noImage.jpg')}}" />
@endsection 