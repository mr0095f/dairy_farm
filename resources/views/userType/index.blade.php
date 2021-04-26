@extends('layouts.layout')
@section('title', __('user_type.title'))
@section('content')
<?php 
  use App\Library\UserRoleWiseAccess;
  $allControllerList = UserRoleWiseAccess::controllerMethods();
?>
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('user_type.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('user_type.title') }}</li>
  </ol>
</section>
<section class="content"> @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="#addNew" data-toggle="modal" class="btn btn-success btn-sm"> <i class="fa fa-plus-square"></i> <b>{{__('same.add_new') }}</b> </a> <a href="{{  url('user-type')  }}" class="btn btn-warning btn-sm"> <i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b> </a> </div>
    <div class="box-body">
      <div class="col-md-8 col-md-offset-2">
        <div class="table_scroll">
          <table class="table table-bordered table-striped table-responsive">
            	<th>{{__('same.sl') }}</th>
              	<th>{{__('user_type.user_type') }}</th>
              	<th>{{__('same.action') }}</th>
            <tbody>
              <?php                           
                $number = 1;
                $numElementsPerPage = 10; // How many elements per page
                $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
              ?>
            @if(isset($alldata) && count($alldata))
            @foreach($alldata as $data)
            <tr>
              <td><label class="label label-success">{{$currentNumber++}}</label></td>
              <td>{{  $data->user_type  }}</td>
              <td><div class="form-inline">
                  <div class = "input-group"> <a href="#editModal{{$data->id}}" class="btn btn-success btn-xs" data-toggle="modal" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                </div>
                <!-- Modal Start -->
                <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b><i class="fa fa-shield edit-color"></i> <span>{{__('user_type.update_user_type_access') }}</span></b></h4>
                      </div>
                      {!! Form::open(array('route' => ['user-type.update', $data->id],'class'=>'form-horizontal','method'=>'PUT')) !!}
                      <div class="modal-body">
                        <div class="form-group">
                          <div class="col-md-12">
                            <div class="col-md-12">
                              <label for="user_type">{{__('user_type.user_type') }} : <span class="validate">*</span></label>
                              <input type="text" name="user_type" value="{{$data->user_type}}" class="form-control" placeholder="{{__('user_type.user_type') }}" required>
                            </div>
                          </div>
                        </div>
                        <?php $selectedControllerArr = json_decode($data->user_role, true); ?>
                        <div class="form-group">
                          <div class="col-md-12 userTypeBg">
                            <div class="col-md-12">
                              <label class="checkbox-inline user-type-checkbox-inline">
                              <input type="checkbox" name="checkAll" class="checkAll" id="{{$data->id}}">
                              <span>{{__('user_type.give_all_access') }}</span> </label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-12">
                            <table class="table table-responsive table-striped table-bordered" id="checkboxBlock_{{$data->id}}">
                              <?php $j=1; ?>
                              @foreach($allControllerList as $controllerName => $accessName)
                              <tr>
                                <td class="box-middle"><label class="label label-success">{{$j}}</label>
                                </td>
                                <td class="ut-pt-2"> @foreach($accessName as $actionName => $actionText)
                                  @if(isset($selectedControllerArr[$controllerName][$actionName]))
                                  <div class="col-md-4">
                                    <label class="checkbox-inline checkbox-inline-box-2">
                                    <input type="checkbox" class="{{$data->id}}_subAction_{{$j}}" name="useraccess[{{$controllerName}}][{{$actionName}}]" value="{{$actionName}}" checked>
                                    {{$actionText}} </label>
                                  </div>
                                  @else
                                  <div class="col-md-4">
                                    <label class="checkbox-inline checkbox-inline-box-2">
                                    <input type="checkbox" class="{{$data->id}}_subAction_{{$j}}" name="useraccess[{{$controllerName}}][{{$actionName}}]" value="{{$actionName}}">
                                    {{$actionText}} </label>
                                  </div>
                                  @endif
                                  @endforeach </td>
                              </tr>
                              <?php $j++; ?>
                              @endforeach
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div class="col-md-12" align="right">
                          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"> {{__('same.close') }} </button>
                          {{Form::submit(__('same.update'),array('class'=>'btn btn-warning btn-sm'))}} </div>
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
              <td colspan="3" align="center"> {{__('same.empty_row') }} </td>
            </tr>
            @endif
            </tbody>
            
          </table>
        </div>
      </div>
    </div>
    <!-- Modal Start -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><b><i class="fa fa-shield color-monitor-text"></i> <span>{{__('user_type.add_user_type_access') }}</span></b></h4>
          </div>
          {!! Form::open(array('route' => ['user-type.store'],'class'=>'form-horizontal','method'=>'POST')) !!}
          <div class="modal-body">
            <div class="form-group">
              <div class="col-md-12">
                <div class="col-md-12">
                  <label for="user_type">{{__('user_type.user_type') }} : <span class="validate">*</span></label>
                  <input type="text" name="user_type" value="" class="form-control" placeholder="{{__('user_type.user_type') }}">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12 userTypeBg">
                <div class="col-md-12">
                  <label class="checkbox-inline user-type-checkbox-inline">
                  <input type="checkbox" name="checkAll" class="checkAll" id="all">
                  <span>{{__('user_type.give_all_access') }}</span> </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <table class="table table-responsive table-striped table-bordered" id="checkboxBlock_all">
                  <?php $j=1; ?>
                  @foreach($allControllerList as $controllerName => $accessName)
                  <tr>
                    <td class="box-middle"><label class="label label-success">{{$j}}</label>
                    </td>
                    <td class="ut-pt-2"> @foreach($accessName as $actionName => $actionText)
                      <div class="col-md-4">
                        <label class="checkbox-inline checkbox-inline-box-2">
                        <input type="checkbox" class="{{$data->id}}_subAction_{{$j}}" name="useraccess[{{$controllerName}}][{{$actionName}}]" value="{{$actionName}}">
                        {{$actionText}} </label>
                      </div>
                      @endforeach </td>
                  </tr>
                  <?php $j++; ?>
                  @endforeach
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="col-md-12" align="right">
              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"> {{__('same.close') }} </button>
              {{Form::submit(__('same.save'),array('class'=>'btn btn-success btn-sm'))}} </div>
          </div>
          {!! Form::close() !!} </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="box-footer"> </div>
  </div>
</section>
@endsection 