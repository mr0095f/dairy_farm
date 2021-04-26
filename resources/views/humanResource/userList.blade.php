@extends('layouts.layout')
@section('title', __('userlist.title'))
@section('content')
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('userlist.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('userlist.title') }}</li>
  </ol>
</section>
<section class="content"> @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="{{  url('human-resource/create')  }}" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> <b>{{__('userlist.add_user') }}</b> </a> <a href="{{  url('user-list')  }}" class="btn btn-warning btn-sm"> <i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b> </a> </div>
    <div class="box-body">
      <div class="table_scroll">
        <table class="table table-bordered table-striped table-responsive">
          <th>{{__('userlist.image') }}</th>
            <th>{{__('userlist.id') }}</th>
            <th>{{__('userlist.user_name') }}</th>
            <th>{{__('userlist.email') }}</th>
            <th>{{__('userlist.mobile_no') }}</th>
            <th>{{__('userlist.designation') }}</th>
            <th>{{__('userlist.user_type') }}</th>
            <th>{{__('userlist.joining_date') }}</th>
            <th>{{__('userlist.status') }}</th>
            <th>{{__('same.action') }}</th>
          <tbody>
          @if(isset($allData) && count($allData)>0)
          @foreach($allData as $data)
          <tr>
            <td> @if($data->image !='') <img src='{{asset("storage/app/public/uploads/human-resource/$data->image")}}' class="img-thumbnail" width="35px"> @else <img src='{{asset("public/custom/img/photo.png")}}' class="img-circle" width="35px"> @endif </td>
            <td>{{  $data->id }}</td>
            <td>{{  $data->name }}</td>
            <td>{{  $data->email }}</td>
            <td>{{  $data->phone_number }}</td>
            <td><label class="label label-default lblfarm">{{  $data->designation_name }}</label></td>
            <td><label class="label label-success lblfarm">{{  $data->user_type_name }}</label></td>
            <td> @if(!empty($data->joining_date))
              {{  date('m/d/Y', strtotime($data->joining_date)) }}
              @endif </td>
            <td> @if($data->status == 1)
              <label class="switch">
              <input type="checkbox" name="status" checked value="on" data-id="{{$data->id}}"  data-url="{{URL::to('update-human-resource-status')}}" class="staffStatusUpdate">
              <span class="slider round"></span> </label>
              @else
              <label class="switch">
              <input type="checkbox" name="status" data-id="{{$data->id}}"  data-url="{{URL::to('update-human-resource-status')}}" class="staffStatusUpdate">
              <span class="slider round"></span> </label>
              @endif </td>
            <td><div class="form-inline">
                <div class = "input-group"> <a href="{{ route('human-resource.edit', $data->id) }}" class="btn btn-success btn-xs" title="Edit"><i class="icon-pencil"></i></a> </div>
                <div class = "input-group"> {{Form::open(array('route'=>['human-resource.destroy',$data->id],'method'=>'DELETE'))}}
                  <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm" title="Delete"><i class="icon-trash"></i></button>
                  {!! Form::close() !!} </div>
              </div></td>
          </tr>
          @endforeach
          @else
          <tr>
            <td colspan="10" align="center">{{__('same.empty_row') }}</td>
          </tr>
          @endif
          </tbody>
          
        </table>
        <div align="center">{{$allData->render()}}</div>
      </div>
    </div>
    <div class="box-footer"> </div>
  </div>
</section>
@endsection 