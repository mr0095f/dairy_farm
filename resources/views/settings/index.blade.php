@extends('layouts.layout')
@section('title', __('settings.title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="fa fa-wrench"></i> {{__('settings.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active"><a href="{{URL::to('system')}}"><i class="fa fa-wrench"></i> {{__('settings.title') }}</a></li>
  </ol>
</section>
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> {{Form::open(array('route'=>['system.update',$alldata->system_key_id],'method'=>'PUT','files'=>true))}}
      <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> <b>{{__('settings.update_settings') }}</b></button>
    </div>
    <div class="box-body">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-dollar"></i>&nbsp;{{__('settings.currency_setup') }} :</div>
          <div class="panel-body">
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="name">{{__('settings.currency_symbol') }} <span class="validate">*</span></label>
              <div class="col-md-8">
                <input type="text" name="config[currencySymbol]" class="form-control" value="{{  (isset($config_data->currencySymbol))?$config_data->currencySymbol:old('currencySymbol')  }}" placeholder="Ex: $" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="name">{{__('settings.currency_position') }}</label>
              <div class="col-md-8">
                <select name="config[currencyPosition]" id="currencyPosition" class="form-control">
                  <option @if(isset($config_data->currencyPosition) && $config_data->currencyPosition=='left') selected="selected" @endif value="left">Left</option>
                  <option @if(isset($config_data->currencyPosition) && $config_data->currencyPosition=='right') selected="selected" @endif value="right">Right</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="name">{{__('settings.currency_separator') }}</label>
              <div class="col-md-8">
                <select name="config[currencySeparator]" id="currencySeparator" class="form-control">
                  <option @if(isset($config_data->currencySeparator) && $config_data->currencySeparator=='.') selected="selected" @endif value=".">10.00</option>
                  <option @if(isset($config_data->currencySeparator) && $config_data->currencySeparator==',') selected="selected" @endif value=",">10,00</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="name">{{__('settings.space_between') }} </label>
              <div class="col-md-8">
                <input @if(isset($config_data->currencySpace)) checked @endif type="checkbox" name="config[currencySpace]"> </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="name">{{__('settings.disable_currency') }} </label>
              <div class="col-md-8">
                <input type="checkbox" @if(isset($config_data->
                currencySpace)) checked @endif  name="config[currencyDisable]"> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-plug"></i>&nbsp;{{__('settings.application_setup') }} :</div>
          <div class="panel-body">
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="name">{{__('settings.login_page_top_text') }} <span class="validate">*</span></label>
              <div class="col-md-8">
                <input type="text" name="config[loginTitle]" class="form-control" value="{{  (isset($config_data->loginTitle))?$config_data->loginTitle:old('loginTitle')  }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="name">{{__('settings.login_page_logo') }}(256X256) <span class="validate">*</span></label>
              <div class="col-md-8">
                <div class="form-group"> @if(!empty($config_data) && !empty($config_data->logo))
                  <div class="setting-mb-10"><img id="system-logo-img" src="{{asset("storage/app/public/uploads/$config_data->logo")}}"></div>
                  @endif
                  <label for="system-logo" class="btn btn-success btn-file btn-xs setting-file-upload"> {{__('settings.upload_logo') }}
                  <input type="file" name="system-logo" class="form-control" id="system-logo" class="hideme">
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="name">{{__('settings.super_admin_photo') }} (256X256) </label>
              <div class="col-md-8">
                <div class="form-group"> @if(!empty($config_data) && !empty($config_data->super_admin_logo))
                  <div class="setting-mb-10"><img id="super_admin_logo-img" src="{{asset("storage/app/public/uploads/$config_data->super_admin_logo")}}"></div>
                  @endif
                  <label for="super_admin_logo" class="btn btn-success btn-file btn-xs setting-file-upload">{{__('settings.upload_logo') }}
                  <input type="file" name="super_admin_logo" class="form-control" id="super_admin_logo" class="hideme">
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="name">{{__('settings.top_title') }} <span class="validate">*</span></label>
              <div class="col-md-8">
                <input type="text" name="config[topTitle]" class="form-control" value="{{  (isset($config_data->topTitle))?$config_data->topTitle:old('topTitle')  }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="name">{{__('settings.footer_text') }} <span class="validate">*</span></label>
              <div class="col-md-8">
                <input type="text" name="config[copyrightText]" class="form-control" value="{{  (isset($config_data->copyrightText))?$config_data->copyrightText:old('copyrightText')  }}" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-4 col-form-label" for="name">{{__('settings.copyright_link') }} <span class="validate">*</span></label>
              <div class="col-md-8">
                <input type="text" name="config[copyrightLink]" class="form-control" value="{{  (isset($config_data->copyrightLink))?$config_data->copyrightLink:old('copyrightLink')  }}" required>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {!! Form::close() !!} </div>
</section>
@endsection 