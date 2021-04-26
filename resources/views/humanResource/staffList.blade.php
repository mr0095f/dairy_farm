@extends('layouts.layout')
@section('title', __('stafflist.title'))
@section('content')
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('stafflist.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('stafflist.title') }}</li>
  </ol>
</section>
<section class="content"> @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="{{  url('human-resource/create')  }}" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> <b>{{__('stafflist.add_staff') }}</b> </a> <a href="{{  url('human-resource')  }}" class="btn btn-warning btn-sm"> <i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b> </a> </div>
    <div class="box-body">
      <div class="table_scroll">
        <table class="table table-bordered table-striped table-responsive">
          <th>{{__('stafflist.image') }}</th>
            <th>{{__('stafflist.staff_name') }}</th>
            <th>{{__('stafflist.email') }}</th>
            <th>{{__('stafflist.mobile_no') }}</th>
            <th>{{__('stafflist.designation') }}</th>
            <th>{{__('stafflist.joining_date') }}</th>
            <th>{{__('stafflist.salary') }}</th>
            <th>{{__('stafflist.status') }}</th>
            <th>{{__('same.action') }}</th>
          <tbody>
          
          @if(isset($allData) && count($allData)>0)
          
          @foreach($allData as $data)
          <tr>
            <td> @if($data->image !='') <img src='{{asset("storage/app/public/uploads/human-resource/$data->image")}}' class="img-thumbnail" width="35px;"> @else <img src='{{asset("public/custom/img/photo.png")}}' class="img-thumbnail" width="35px;"> @endif </td>
            <td>{{  $data->name }}</td>
            <td>{{  $data->email }}</td>
            <td>{{  $data->phone_number }}</td>
            <td><label class="label label-default lblfarm">{{  $data->designation_name }}</label></td>
            <!-- <td>{{  $data->
            user_type_name }}
            </td>
            -->
            <td> @if(!empty($data->joining_date))
              {{  date('m/d/Y', strtotime($data->joining_date)) }}
              @endif </td>
            <td class="amounts"> @if(!empty($data->gross_salary))
              {{  App\Library\farm::currency($data->gross_salary) }}
              @endif </td>
            <td> @if($data->status == 1)
              <label class="switch">
              <input type="checkbox" name="status" checked value="on" data-id="{{$data->id}}" data-url="{{URL::to('update-human-resource-status')}}" class="staffStatusUpdate">
              <span class="slider round"></span> </label>
              @else
              <label class="switch">
              <input type="checkbox" name="status" data-id="{{$data->id}}" class="staffStatusUpdate" data-url="{{URL::to('update-human-resource-status')}}">
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