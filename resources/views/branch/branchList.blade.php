@extends('layouts.layout')
@section('title', __('branch.title'))
@section('content')
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('branch.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('branch.title') }}</li>
  </ol>
</section>
<section class="content"> @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="#addModal" class="btn btn-success btn-sm" data-toggle="modal"> <i class="fa fa-plus"></i> <b>{{__('same.add_new') }}</b> </a> <a href="{{  url('branch')  }}" class="btn btn-warning btn-sm"> <i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b> </a> </div>
    <div class="box-body">
      <div class="table_scroll">
        <table class="table table-bordered table-striped table-responsive">
          	<th>{{__('branch.sl') }}</th>
            <th>{{__('branch.setup_date') }}</th>
            <th>{{__('branch.branch_name') }}</th>
            <th>{{__('branch.builder_name') }}</th>
            <th>{{__('branch.phone_no') }}</th>
            <th>{{__('branch.email') }}</th>
            <th>{{__('same.action') }}</th>
          <tbody>
            <?php                           
              $number = 1;
              $numElementsPerPage = 10; // How many elements per page
              $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
              $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
            ?>
          @if(isset($alldata) && count($alldata)>0)
          @foreach($alldata as $data)
          <tr>
            <td><label class="label label-success">{{  $currentNumber++  }}</label>
            </td>
            <td>{{  date('m/d/Y', strtotime($data->setup_date))  }}</td>
            <td>{{  $data->branch_name  }}</td>
            <td>{{  $data->builders_name  }}</td>
            <td>{{  $data->phone_number  }}</td>
            <td>{{  $data->email  }}</td>
            <td><div class="form-inline">
                <div class = "input-group"> <a href="#editModal{{$data->id}}" class="btn btn-success btn-xs" data-toggle="modal" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                <div class = "input-group"> {{Form::open(array('route'=>['branch.destroy',$data->id],'method'=>'DELETE'))}}
                  <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                  {!! Form::close() !!} </div>
              </div>
              <!-- Modal Start -->
              <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content branch-content-width">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"> <i class="fa fa-pencil edit-color"></i> <strong> {{__('branch.edit_branch') }}</strong> </h4>
                    </div>
                    {!! Form::open(array('route' => ['branch.update', $data->id],'class'=>'form-horizontal','method'=>'PUT')) !!}
                    <div class="modal-body">
                      <div class="form-group">
                        <div class="col-md-12">
                          <label for="branch_name">{{__('branch.branch_name') }} <span class="validate">*</span> : </label>
                          <input type="text" class="form-control" id="branch_name" value="{{  $data->branch_name  }}" name="branch_name" placeholder="{{__('branch.branch_name') }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <label for="builders_name">{{__('branch.builder_name') }} <span class="validate">*</span> : </label>
                          <input type="text" class="form-control" id="builders_name" value="{{  $data->builders_name  }}" name="builders_name" placeholder="{{__('branch.builder_name') }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <label for="phone_number">{{__('branch.phone_no') }} <span class="validate">*</span> : </label>
                          <input type="text" class="form-control" id="phone_number" value="{{  $data->phone_number  }}" name="phone_number" placeholder="{{__('branch.phone_no') }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <label for="email">{{__('branch.email') }} <span class="validate">*</span> : </label>
                          <input type="text" class="form-control" id="email" value="{{  $data->email  }}" name="email" placeholder="{{__('branch.email') }}" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <label for="branch_address">{{__('branch.address') }} <span class="validate">*</span> : </label>
                          <textarea class="form-control" id="branch_address" name="branch_address" required>{{  $data->branch_address  }}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <label for="setup_date">{{__('branch.setup_date') }} <span class="validate">*</span> : </label>
                          <input type="text" class="form-control wsit_datepicker" id="setup_date" value="{{  date('m/d/Y', strtotime($data->setup_date))  }}" name="setup_date" placeholder="{{__('branch.setup_date') }}" required>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                      {{Form::submit(__('same.update'),array('class'=>'btn btn-warning btn-sm'))}} </div>
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
            <td colspan="7" align="center"> {{__('same.empty_row') }}</td>
          </tr>
          @endif
          </tbody>
          
        </table>
        <div align="center">{{ $alldata->render() }}</div>
      </div>
    </div>
    <div class="box-footer"> </div>
  </div>
</section>
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content branch-content-width">
      <div class="modal-header">
        <h4 class="modal-title">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-plus-square branch-pencil"></i> <strong> {{__('branch.add_new_branch') }}</strong> </h4>
      </div>
      {!! Form::open(array('route' => ['branch.store'],'class'=>'form-horizontal','method'=>'POST')) !!}
      <div class="modal-body">
        <div class="form-group">
          <div class="col-md-12">
            <label for="branch_name">{{__('branch.branch_name') }} <span class="validate">*</span> : </label>
            <input type="text" class="form-control" id="branch_name" value="" name="branch_name" placeholder="{{__('branch.branch_name') }}" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="builders_name">{{__('branch.builder_name') }} <span class="validate">*</span> : </label>
            <input type="text" class="form-control" id="builders_name" value="" name="builders_name" placeholder="{{__('branch.builder_name') }}" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="phone_number">{{__('branch.phone_no') }} <span class="validate">*</span> : </label>
            <input type="text" class="form-control" id="phone_number" value="" name="phone_number" placeholder="{{__('branch.phone_no') }}" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="email">{{__('branch.email') }} <span class="validate">*</span> : </label>
            <input type="text" class="form-control" id="email" value="" name="email" placeholder="{{__('branch.email') }}" required>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="branch_address">{{__('branch.address') }} <span class="validate">*</span> : </label>
            <textarea class="form-control" id="branch_address" name="branch_address" required></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="setup_date">{{__('branch.setup_date') }} <span class="validate">*</span> : </label>
            <input type="text" class="form-control wsit_datepicker" value="" name="setup_date" placeholder="{{__('branch.setup_date') }}" required>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{__('same.close') }}</button>
        {{Form::submit(__('same.save'),array('class'=>'btn btn-success btn-sm'))}} </div>
      {!! Form::close() !!} </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection 