@extends('layouts.layout')
@section('title', __('supplier.title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('supplier.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('supplier.title') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="{{  url('supplier/create')  }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> <b>{{__('same.add_new') }}</b></a> <a href="{{  url('supplier')  }}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b></a> </div>
    <div class="box-body">
      <div class="form-group"> {{Form::open(array('url'=>['search-supplier'],'method'=>'GET'))}}
        <div class="row col-md-4">
          <div class="pull-left">
            <input name="search_supplier" value="{{(isset($search_supplier))?$search_supplier:''}}" class="form-control supplier-search" placeholder="{{__('supplier.search_by') }}" type="text" required>
          </div>
          <div class="pull-left">&nbsp;
            <button class="btn btn-default btn-sm" type="submit">{{__('same.search') }}</button>
          </div>
        </div>
        {!! Form::close() !!}
        <div class="clearfix"></div>
      </div>
      <div class="table_scroll">
        <table class="table table-bordered table-striped table-responsive">
          	<th>{{__('supplier.image') }}</th>
            <th>{{__('supplier.supplier_name') }}</th>
            <th>{{__('supplier.company_name') }}</th>
            <th>{{__('supplier.phone_number') }}</th>
            <th>{{__('supplier.email') }}</th>
            <th>{{__('same.action') }}</th>
          <tbody>
          
          @if(isset($alldata) && count($alldata)<1)
          <tr>
            <td colspan="6" align="center">{{__('same.empty_row') }}</td>
          </tr>
          @else
          
          @foreach($alldata as $data)
          <tr> @if($data->profile_image)
            <td> @if(file_exists('storage/app/public/uploads/suppliers/'.$data->profile_image)) <img src='{{asset("storage/app/public/uploads/suppliers/$data->profile_image")}}' class="img-thumbnail" width="40px"> @else <img src='{{asset("public/custom/img/photo.png")}}' width="40px" class="img-thumbnail"> @endif </td>
            @else
            <td><img src='{{asset("public/custom/img/photo.png")}}' width="40px" class="img-thumbnail"> </td>
            @endif
            <td>{{  $data->name  }}</td>
            <td>{{  $data->company_name  }}</td>
            <td>{{  $data->phn_number  }}</td>
            <td>{{  $data->mail_address  }}</td>
            <td><div class="form-inline">
                <div class = "input-group"> <a href="{{ route('supplier.edit', $data->id) }}" class="btn btn-success btn-xs" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                <div class = "input-group"> {{Form::open(array('route'=>['supplier.destroy',$data->id],'method'=>'DELETE'))}}
                  <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                  {!! Form::close() !!} </div>
              </div></td>
          </tr>
          @endforeach
          @endif
          </tbody>
          
        </table>
        <div align="center">{{ $alldata->render() }}</div>
      </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer"> </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->
</section>
<!-- /.content -->
@endsection 