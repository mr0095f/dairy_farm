@extends('layouts.layout')
@section('title', __('supplier.add_update'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="icon-note"></i> {{__('supplier.add_update') }} </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('supplier.add_update') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> @include('common.message')
  <!-- Default box -->
  <div class="box box-success">
    <div class="box-header with-border" align="right">
      <?php $profileImageLink = "public/custom/img/photo.png"; ?>
      @if( !empty($singleData) )
      {{Form::open(array('route'=>['supplier.update',$singleData->id],'method'=>'PUT','files'=>true))}}
      <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-floppy-o"></i> <b>Update Information</b></button>
      <?php 
					if (file_exists("storage/app/public/uploads/suppliers/".$singleData->profile_image)){
						$profileImageLink = "storage/app/public/uploads/suppliers/".$singleData->profile_image;
					} 
				?>
      @else
      {{Form::open(array('route'=>['supplier.store'],'method'=>'POST','files'=>true))}}
      <button type="submit" class="btn btn-success  btn-sm"><i class="fa fa-floppy-o"></i> <b>{{__('supplier.save_information') }}</b></button>
      @endif 
     <a href="{{  url('supplier')  }}" class="btn btn-primary btn-sm"><i class="fa fa-align-justify"></i> <b> {{__('supplier.view_all_list') }}</b></a> </div>
    <div class="box-body">
      <div class="col-md-8">
		<div class="col-md-12">
          <div class="form-group">
            <label for="supplier_name">{{__('supplier.supplier_name') }} <span class="validate">*</span> : </label>
            <input type="text" class="form-control" id="supplier_name" value="{{  (isset($singleData->name))?$singleData->name:old('name')  }}" name="name" placeholder="{{__('supplier.supplier_name') }}" required>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="company_name">{{__('supplier.company_name') }} <span class="validate">*</span> : </label>
            <input type="text" class="form-control" id="company_name" value="{{  (isset($singleData->company_name))?$singleData->company_name:old('company_name')  }}" name="company_name" placeholder="{{__('supplier.company_name') }}" required>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="phn_number">{{__('supplier.phone_number') }} <span class="validate">*</span> : </label>
            <input type="text" class="form-control" id="phn_number" value="{{  (isset($singleData->phn_number))?$singleData->phn_number:old('phn_number')  }}" name="phn_number" placeholder="{{__('supplier.phone_number') }}" required>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="mail_address">{{__('supplier.email') }} <span class="validate">*</span> : </label>
            <input type="email" class="form-control" id="mail_address" value="{{  (isset($singleData->mail_address))?$singleData->mail_address:old('mail_address')  }}" name="mail_address" placeholder="{{__('supplier.email') }}" required>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="present_address">{{__('supplier.company_address') }} <span class="validate">*</span> : </label>
            <textarea id="present_address" class="form-control" name="present_address" required>{{  (isset($singleData->present_address))?$singleData->present_address:old('present_address')  }}</textarea>
          </div>
        </div>
      </div>
      <div class="col-md-4" align="center">
        <div class="form-group">
          <div class="select_image"> <label><u>{{__('supplier.profile_image') }}</u></label><br/><img class="img-thumbnail supplier-image-box" src="{{asset($profileImageLink)}}" id="profile-image"> </div>
          <div class="mt-5" align="center">
            <label class="btn btn-success btn-file btn-sm img_upload_btn supplier-image-upload-button">{{__('same.browse') }}
            <input type="file" name="profile_image" class="form-control hideme" id="profile-image-select" value="">
            </label>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</section>
<!-- /.content -->
@endsection 