@extends('layouts.layout')
@section('title', __('stall.title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('stall.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('stall.title') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="#saveModal" data-toggle="modal" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> <b>{{__('same.add_new') }}</b></a> <a href="{{  url('sheds')  }}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b></a> </div>
    <div class="box-body">
      <div class="form-group">
        <div class="clearfix"></div>
      </div>
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-list"></i> {{__('stall.all_stall_list') }}</div>
          <div class="panel-body">
            <div class="table_scroll">
            <table class="table table-bordered table-striped table-responsive table-hover">
              <th>#</th>
                <th>{{__('stall.stall_no') }}</th>
                <th>{{__('stall.status') }}</th>
                <th>{{__('stall.details') }}</th>
                <th>{{__('same.action') }}</th>
              <tbody>
                <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;
                    ?>
              @foreach($allData as $data)
              <?php $rowCount++; ?>
              <tr>
                <td><label class="label label-success">{{$currentNumber++}}</label>
                </td>
                <td>{{  $data->shed_number  }}</td>
                <td>@if($data->status == 1)
                  <label class="label label-danger lblfarm">{{__('stall.booked') }}</label>
                  @else
                  <label class="label label-success lblfarm">{{__('stall.available') }}</label>
                  @endif</td>
                <td>{{  $data->description  }}</td>
                <td><div class="form-inline">
                    <div class = "input-group"> <a href="#editModal{{$data->id}}" data-toggle="modal" class="btn btn-success btn-xs" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                    <div class = "input-group"> {{Form::open(array('route'=>['sheds.destroy',$data->id],'method'=>'DELETE'))}}
                      <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                      {!! Form::close() !!} </div>
                  </div>
                  <!-- Modal -->
                  <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title"><i class="fa fa-edit edit-color"></i> {{__('stall.edit_stall') }}</h4>
                        </div>
                        {!! Form::open(array('route' =>['sheds.update', $data->id],'class'=>'form-horizontal','method'=>'PUT')) !!}
                        <div class="modal-body">
                          <div class="form-group">
                            <div class="col-md-12"> {{Form::label('shed_number', __('stall.stall_no'))}} <span class="validate">*</span> :
                              <input type="text" class="form-control" value="{{  $data->shed_number  }}" name="shed_number" placeholder="Stall Number | Name" required>
                            </div>
                            {{Form::hidden('id',$data->id)}} </div>
                          <div class="form-group">
                            <div class="col-md-12"> {{Form::label('description', __('stall.details'))}} :
                              <textarea class="form-control" name="description">{{  $data->description  }}</textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-6"> </div>
                            <div class="col-md-6">
                              <div class="row">
                                <div class="col-md-12" align="right">
                                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{__('same.close') }}</button>
								  {{Form::submit(__('same.update'),array('class'=>'btn btn-warning btn-sm'))}}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer"> </div>
                      {!! Form::close() !!} </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
              </div>
              
              <!-- /.modal -->
              </td>
              
              </tr>
              
              @endforeach
              @if($rowCount==0)
              <tr>
                <td colspan="4" align="center"><h2>{{__('same.empty_row') }}</h2></td>
              </tr>
              @endif
              </tbody>
              
            </table>
            <div align="center">{{ $allData->render() }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
  <div class="box-footer"> </div>
  <!-- /.box-footer-->
  </div>
  <!-- /.box -->
  <!-- Modal -->
  <div class="modal fade" id="saveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-plus-square" style="color: green"></i> {{__('stall.add_stall') }}</h4>
        </div>
        {!! Form::open(array('route' =>['sheds.store'],'class'=>'form-horizontal','method'=>'POST')) !!}
        <div class="modal-body">
          <div class="form-group">
            <div class="col-md-12"> {{Form::label('shed_number', __('stall.stall_no'))}} <span class="validate">*</span> :
              <input type="text" class="form-control" id="shed_number" value="" name="shed_number" placeholder="Stall Number | Name" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-12"> {{Form::label('description', __('stall.details'))}} :
              <textarea class="form-control" name="description"></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6"> </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-12" align="right">
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{__('same.close') }}</button>
				  {{Form::submit(__('same.save'),array('class'=>'btn btn-success btn-sm'))}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer"> </div>
      {!! Form::close() !!} </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
</section>
<!-- /.content -->
@endsection 