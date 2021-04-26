<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ __('login.title') }}</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.7 -->
{!!Html::style('public/custom/css/bootstrap.min.css')!!}
<!-- Font Awesome -->
{!!Html::style('public/custom/css_icon/font-awesome/css/font-awesome.min.css')!!}
<!-- Ionicons -->
{!!Html::style('public/custom/css_icon/Ionicons/css/ionicons.min.css')!!}
{!!Html::style('public/custom/css/reset.min.css')!!}

{!!Html::style('public/custom/css/login.css')!!}
<!-- jQuery 3 -->
{!!Html::script('public/custom/js/plugins/jquery/dist/jquery.min.js')!!}
<!-- Bootstrap 3.3.7 -->
{!!Html::script('public/custom/js/plugins/bootstrap/dist/js/bootstrap.min.js')!!}
</head>
<body>
<div class="container"> </div>
<?php $configuration_data = \App\Library\farm::get_system_configuration('system_config'); ?>
<div class="form">
  <div class="image_holder"> @if(!empty($configuration_data) && !empty($configuration_data->logo))<img src="{{asset("storage/app/public/uploads/$configuration_data->logo")}}"/>@endif
    <div class="login-page-title">@if(!empty($configuration_data) && !empty($configuration_data->loginTitle)){{$configuration_data->loginTitle}}@endif</div>
  </div>
  @if(Session::get('error'))
  <div class="custom-alerts alert alert-danger fade in">
    <ul>
      <li><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ Session::get('error') }}</li>
      <?php Session::put('error', NULL); ?>
    </ul>
  </div>
  @elseif ($errors->has('email'))
  <div class="custom-alerts alert alert-danger fade in"> <strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ $errors->first('email') }}</strong> </div>
  @endif
  <form name="form" action="{{ url('/login')}}"  class="login-form" method="POST" id="form">
    {{ csrf_field() }}
    <input id="email" type="text" name="email" value="{{ old('email') }}" placeholder="{{ __('login.email') }}" required>
    <input id="password" type="password" name="password" placeholder="{{ __('login.password') }}" required>
    <button type="submit" class="btn btn-primary"> {{ __('login.login') }}</button>
  </form>
</div>
</body>
</html>
