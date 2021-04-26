@extends('layouts.layout')
@section('title', __('human_resource_form.title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="icon-user-follow"></i> {{__('human_resource_form.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
	<li class="active">{{__('human_resource_form.title') }}</li>
  </ol>
</section>
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> @if( !empty($editData) )
      {{Form::open(array('route'=>['human-resource.update',$editData->id],'method'=>'PUT','files'=>true))}}
      <button type="submit" class="btn btn-success  btn-sm"><i class="fa fa-floppy-o"></i> <b>Update Information</b></button>
      @else
      {{Form::open(array('route'=>['human-resource.store'],'method'=>'POST','files'=>true))}}
      <button type="submit" class="btn btn-success  btn-sm" id="saveInfo"><i class="fa fa-floppy-o"></i> <b>{{__('same.save_information') }}</b></button>
      @endif &nbsp; <a href="{{  url('human-resource/create')  }}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> <b> {{__('same.refresh') }}</b></a> </div>
    <div class="box-body">
      <div class="col-md-7">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="icon-list"></i>&nbsp;{{__('human_resource_form.title') }}:</div>
          <div class="panel-body">
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="name">{{__('human_resource_form.full_name') }} : <span class="validate">*</span></label>
              <div class="col-md-8">
                <input type="text" name="name" class="form-control" value="{{  (isset($editData->name))?$editData->name:old('name')  }}" placeholder="{{__('same.enter') }} {{__('human_resource_form.full_name') }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="email">{{__('human_resource_form.email_address') }} : <span class="validate">*</span></label>
              <div class="col-md-8">
                <input type="email" name="email" class="form-control" value="{{  (isset($editData->email))?$editData->email:old('email')  }}" placeholder="somthing@example.com" id="email" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="phone_number">{{__('human_resource_form.phone_number') }} : <span class="validate">*</span></label>
              <div class="col-md-8">
                <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{  (isset($editData->phone_number))?$editData->phone_number:old('phone_number')  }}"  placeholder="01***********">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="nid">{{__('human_resource_form.nid') }} :</label>
              <div class="col-md-8">
                <input type="text" name="nid" class="form-control" id="nid" value="{{  (isset($editData->nid))?$editData->nid:old('nid')  }}" placeholder="{{__('human_resource_form.enter_national_ID_number') }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="designation">{{__('human_resource_form.designation') }} : <span class="validate">*</span></label>
              <div class="col-md-8">
                <select class="form-control" name="designation" required="">
                  <option value="0">{{__('same.select') }}</option>
                  
					    		@foreach($designations as $designation)
					    		
                  <option value="{{$designation->id}}" {{(!empty($editData))?($designation->id==$editData->designation)?'selected':'':''}}>{{$designation->name}}</option>
                  
					    		@endforeach
					    	
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="user_type">{{__('human_resource_form.user_type') }} :</label>
              <div class="col-md-8">
                <select class="form-control" name="user_type" required="">
                  <option value="0">{{__('same.select') }}</option>
                  
					    		@foreach($user_types as $user_type)
					    		
                  <option value="{{$user_type->id}}" {{(!empty($editData))?($user_type->id==$editData->user_type)?'selected':'':''}}>{{$user_type->user_type}}</option>
                  
					    		@endforeach
					    	
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="present_address">{{__('human_resource_form.present_address') }} : <span class="validate">*</span></label>
              <div class="col-md-8">
                <textarea class="form-control" name="present_address" id="present_address" required>{{(isset($editData->present_address))?$editData->present_address:old('present_address')}}</textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="parmanent_address">{{__('human_resource_form.permanent_address') }} :</label>
              <div class="col-md-8">
                <textarea class="form-control" name="parmanent_address" id="parmanent_address" required>{{(isset($editData->parmanent_address))?$editData->parmanent_address:old('parmanent_address')}}</textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="basic_salary">{{__('human_resource_form.basic_salary') }} : <span class="validate">*</span></label>
              <div class="col-md-8">
                <input type="text" name="basic_salary" class="form-control" id="basic_salary" placeholder="{{__('same.enter') }} {{__('human_resource_form.basic_salary') }}" value="{{  (isset($editData->basic_salary))?$editData->basic_salary:old('basic_salary')  }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="gross_salary">{{__('human_resource_form.gross_salary') }} : <span class="validate">*</span></label>
              <div class="col-md-8">
                <input type="text" name="gross_salary" class="form-control" id="gross_salary" placeholder="{{__('same.enter') }} {{__('human_resource_form.gross_salary') }}" value="{{  (isset($editData->gross_salary))?$editData->gross_salary:old('gross_salary')  }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="joining_date">{{__('human_resource_form.joining_date') }} : <span class="validate">*</span></label>
              <div class="col-md-8">
                <input type="text" name="joining_date" class="form-control wsit_datepicker" id="joining_date" placeholder="{{__('same.enter') }} {{__('human_resource_form.joining_date') }}" value="{{(!empty($editData->joining_date))?date('m/d/Y', strtotime($editData->joining_date)):''}}" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="resign_date">{{__('human_resource_form.resign_date') }} : </label>
              <div class="col-md-8">
                <input type="text" name="resign_date" class="form-control wsit_datepicker" id="resign_date" placeholder="{{__('same.enter') }} {{__('human_resource_form.resign_date') }}" value="{{(!empty($editData->resign_date))?date('m/d/Y', strtotime($editData->resign_date)):''}}">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="icon-picture"></i>&nbsp;{{__('human_resource_form.profile_image') }}:</div>
          <div class="panel-body">
            <div class="staffimagebox">
              <div class="select_image"> @if(!empty($editData))
                @if($editData->image !='') <img src='{{asset("storage/app/public/uploads/human-resource/$editData->image")}}' id="image"> @else <img src='{{asset("public/custom/img/photo.png")}}' id="image"> @endif
                @else <img src='{{asset("public/custom/img/photo.png")}}' id="image"> @endif </div>
              <label class="btn btn-success btnImgUp"> {{__('same.browse') }}
              <input type="file" name="image" class="form-control" id="image-select">
              </label>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-unlock-alt"></i>&nbsp;{{__('human_resource_form.password') }}:</div>
          <div class="panel-body staffpassbox">
            <div class="form-group row">
              <label class="col-md-5 col-form-label" for="pass1">{{__('human_resource_form.password') }} :</label>
              <div class="col-md-7">
                <input type="password" name="password" class="form-control" id="pass1" placeholder="**********">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-5 col-form-label" for="pass2">{{__('human_resource_form.confirm_password') }} :</label>
              <div class="col-md-7">
                <input type="password" name="confirm_password" class="form-control" id="pass2" placeholder="**********">
                <span id="confirmMsg"></span> </div>
            </div>
          </div>
        </div>
      </div>
      @if(!empty($editData))
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-file"></i>&nbsp;{{__('human_resource_form.resign_description') }} :</div>
          <div class="panel-body rbox-pad">
            <textarea class="resign_desc" name="resign_desc">{{$editData->resign_desc}}</textarea>
          </div>
        </div>
      </div>
      @endif </div>
    {!! Form::close() !!} </div>
</section>
@endsection 