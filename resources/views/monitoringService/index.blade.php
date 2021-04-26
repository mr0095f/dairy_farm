@extends('layouts.layout')
@section('title', __('monitoring_service.title'))
@section('content')
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('monitoring_service.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('monitoring_service.title') }}</li>
  </ol>
</section>
<section class="content"> @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="#addModal" class="btn btn-success btn-sm" data-toggle="modal"> <i class="fa fa-plus-square"></i> <b>{{__('same.add_new') }}</b> </a> <a href="{{URL::to('monitoring-service')}}" class="btn btn-warning btn-sm"> <i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b> </a> </div>
    <div class="box-body">
      <div class="col-md-10 col-md-offset-1">
        <div class="table_scroll">
          <table class="table table-bordered table-striped table-responsive">
              <th>{{__('same.sl') }}</th>
              <th>{{__('monitoring_service.name') }}</th>
              <th>{{__('same.action') }}</th>
              <?php                           
                $number = 1;
                $numElementsPerPage = 20; // How many elements per page
                $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
              ?>
            <tbody>
            
            @if(isset($alldata) && count($alldata)>0)
            @foreach($alldata as $data)
            <tr>
              <td><label class="label label-success">{{$currentNumber++}}</label></td>
              <td>{{  $data->service_name  }}</td>
              <td><div class="form-inline">
                  <div class = "input-group"> <a href="#editModal{{$data->id}}" class="btn btn-success btn-xs" data-toggle="modal" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                  <div class = "input-group"> {{Form::open(array('route'=>['monitoring-service.destroy',$data->id],'method'=>'DELETE'))}}
                    <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                    {!! Form::close() !!} </div>
                </div>
                <!-- Modal Start -->
                <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-edit edit-color"></i> {{__('monitoring_service.update_service') }}</h4>
                      </div>
                      {!! Form::open(array('route' => ['monitoring-service.update', $data->id],'class'=>'form-horizontal','method'=>'PUT')) !!}
                      <div class="modal-body">
                        <div class="form-group">
                          <div class="col-md-12">
                            <label for="service_name">{{__('monitoring_service.name') }} <span class="validate">*</span> : </label>
                            <input type="text" class="form-control" value="{{  $data->service_name  }}" name="service_name" placeholder="{{__('monitoring_service.name') }}" required>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div class="col-md-12" align="right"> {{Form::submit(__('same.update'),array('class'=>'btn btn-warning btn-sm'))}} </div>
                      </div>
                      {!! Form::close() !!} </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
              </td>
            </tr>
            @endforeach
            @else
            <tr>
              <td colspan="4" align="center"> {{__('same.empty_row') }}</td>
            </tr>
            @endif
            </tbody>
            
          </table>
          <div align="center">{{ $alldata->render() }}</div>
        </div>
      </div>
    </div>
    <div class="box-footer"> </div>
  </div>
</section>
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus-square color-green"></i> {{__('monitoring_service.new_service') }}</h4>
      </div>
      {!! Form::open(array('route' => ['monitoring-service.store'],'class'=>'form-horizontal','method'=>'POST')) !!}
      <div class="modal-body">
        <div class="form-group">
          <div class="col-md-12">
            <label for="service_name">{{__('monitoring_service.name') }} <span class="validate">*</span> : </label>
            <input type="text" class="form-control" value="" name="service_name" placeholder="{{__('monitoring_service.name') }}" required>
          </div>
        </div>
      </div>
      <div class="modal-footer" align="right">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{__('same.close') }}</button>
        {{Form::submit(__('same.save'),array('class'=>'btn btn-success btn-sm'))}} </div>
      {!! Form::close() !!} </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection 