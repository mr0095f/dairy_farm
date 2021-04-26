@extends('layouts.layout')
@section('title', __('vaccine_list.title'))
@section('content')
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('vaccine_list.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('vaccine_list.title') }}</li>
  </ol>
</section>
<section class="content"> @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="#addModal" class="btn btn-success btn-sm" data-toggle="modal"> <i class="fa fa-plus-square"></i> <b>{{__('same.add_new') }}</b> </a> <a href="{{URL::to('vaccines')}}" class="btn btn-warning btn-sm"> <i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b> </a> </div>
    <div class="box-body">
      <div class="col-md-10 col-md-offset-1">
        <div class="table_scroll">
          <table class="table table-bordered table-striped table-responsive">
              <th>{{__('same.sl') }}</th>
              <th>{{__('vaccine_list.name') }}</th>
              <th>{{__('vaccine_list.period') }}</th>
              <th>{{__('vaccine_list.repeat') }}</th>
              <th>{{__('vaccine_list.dose') }}</th>
              <th>{{__('vaccine_list.note') }}</th>
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
              <td>{{  $data->vaccine_name  }}</td>
              <td>{{  $data->months }}</td>
              <td>@if((bool)$data->repeat_vaccine)
                <label class="label label-success">{{__('same.yes') }}</label>
                @else
                <label class="label label-danger">{{__('same.no') }}</label>
                @endif</td>
              <td>{{  $data->dose }}</td>
              <td>{{  $data->note }}</td>
              <td><div class="form-inline">
                  <div class = "input-group"> <a href="#editModal{{$data->id}}" class="btn btn-success btn-xs" title="{{__('same.edit') }}" data-toggle="modal"><i class="icon-pencil"></i></a> </div>
                  <div class = "input-group"> {{Form::open(array('route'=>['vaccines.destroy',$data->id],'method'=>'DELETE'))}}
                    <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                    {!! Form::close() !!} </div>
                </div>
                <!-- Modal Start -->
                <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa fa-edit edit-color"></i> {{__('vaccine_list.update_vaccine') }}</h4>
                      </div>
                      {!! Form::open(array('route' => ['vaccines.update', $data->id],'class'=>'form-horizontal','method'=>'PUT')) !!}
                      <div class="modal-body">
                        <div class="form-group">
                          <div class="col-md-12">
                            <label for="vaccine_name">{{__('vaccine_list.name') }} <span class="validate">*</span> : </label>
                            <input type="text" class="form-control" value="{{  $data->vaccine_name  }}" name="vaccine_name" placeholder="{{__('vaccine_list.name') }}" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-12">
                            <label for="months">{{__('vaccine_list.period') }} : </label>
                            <input type="text" class="form-control" value="{{  $data->months  }}" name="months" placeholder="{{__('vaccine_list.days') }}" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-12">
                            <label for="dose">{{__('vaccine_list.dose') }} : </label>
                            <input type="text" class="form-control" value="{{  $data->dose  }}" name="dose" placeholder="{{__('vaccine_list.dose_ex') }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-12">
                            <label for="months">
                            {{__('vaccine_list.repeat') }} :
                            <label class="fa fa-question-circle color-green" data-toggle="tooltip" title="{{__('vaccine_list.repeat_note') }}"></label>
                            </label>
                            <select class="form-control" name="repeat_vaccine">
                              <option @if(!(bool)$data->repeat_vaccine) selected="selected" @endif value="0">{{__('same.no') }}</option>
                              <option @if((bool)$data->repeat_vaccine) selected="selected" @endif value="1">{{__('same.yes') }}</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-12">
                            <label for="months">{{__('vaccine_list.note') }} : </label>
                            <textarea class="form-control" name="note">{{  $data->note  }}</textarea>
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
        <h4 class="modal-title"><i class="fa fa-plus-square color-green"></i> {{__('vaccine_list.add_new_vaccine') }}</h4>
      </div>
      {!! Form::open(array('route' => ['vaccines.store'],'class'=>'form-horizontal','method'=>'POST')) !!}
      <div class="modal-body">
        <div class="form-group">
          <div class="col-md-12">
            <label for="vaccine_name">{{__('vaccine_list.name') }} <span class="validate">*</span> : </label>
            <input type="text" class="form-control" value="" name="vaccine_name" placeholder="{{__('vaccine_list.name') }}" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="months">{{__('vaccine_list.period') }} <span class="validate">*</span> : </label>
            <input type="text" class="form-control" value="" name="months" placeholder="{{__('vaccine_list.days') }}" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="months">
            {{__('vaccine_list.repeat') }} :
            <label class="fa fa-question-circle color-green" data-toggle="tooltip" title="{{__('vaccine_list.repeat_note') }}"></label>
            </label>
            <select class="form-control" name="repeat_vaccine">
              <option value="0">{{__('same.no') }}</option>
              <option value="1">{{__('same.yes') }}</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="dose">{{__('vaccine_list.dose') }} : </label>
            <input type="text" class="form-control" value="" name="dose" placeholder="{{__('vaccine_list.dose_ex') }}">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="months">{{__('vaccine_list.note') }} : </label>
            <textarea class="form-control" name="note"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer" align="right">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{__('same.close') }}</button>
        {{Form::submit('Save',array('class'=>'btn btn-success btn-sm'))}} </div>
      {!! Form::close() !!} </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection 