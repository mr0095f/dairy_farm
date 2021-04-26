@extends('layouts.layout')
@section('title', __('expense.title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('expense.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('expense.title') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="#saveModal" data-toggle="modal" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> <b>{{__('same.add_new') }}</b></a> <a href="{{  url('expense-list')  }}" class="btn btn-warning  btn-sm"><i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b></a> </div>
    <div class="box-body">
      <div class="form-group">
        <div class="clearfix"></div>
      </div>
      <div class="table_scroll">
        <table class="table table-bordered table-striped table-responsive">
          <th>#</th>
            <th>{{__('expense.date') }}</th>
            <th>{{__('expense.purpose_name') }}</th>
            <th>{{__('expense.details') }}</th>
            <th>{{__('expense.expense_amount') }}</th>
            <th>{{__('expense.added_by') }}</th>
            <th>{{__('same.action') }}</th>
          <tbody>
            <?php                           
              $number = 1;
              $numElementsPerPage = 20; // How many elements per page
              $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
              $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
              $countRow = 0;
            ?>
          @foreach($allData as $data)
          <?php $countRow++; ?>
          <tr>
            <td><label class="label label-success">{{$currentNumber++}}</label>
            </td>
            <td>{{  date('m/d/Y',strtotime($data->date))  }}</td>
            <td>{{  $data->purpose_name  }}</td>
            <td><p>{{  $data->note  }}</p></td>
            <td>{{  App\Library\farm::currency($data->amount)  }}</td>
            <td>{{  $data->created_by  }} <b>({{  $data->user_type  }})</b></td>
            <td><div class="form-inline">
                <div class = "input-group"> <a href="#editModal{{$data->id}}" data-toggle="modal" class="btn btn-success btn-xs" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                <div class = "input-group"> {{Form::open(array('route'=>['expense-list.destroy',$data->id],'method'=>'DELETE'))}}
                  <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                  {!! Form::close() !!} </div>
              </div>
              <!-- Modal -->
              <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><i class="fa fa-edit edit-color"></i> {{__('expense.edit_expense') }}</h4>
                    </div>
                    {!! Form::open(array('route' =>['expense-list.update', $data->id],'class'=>'form-horizontal','method'=>'PUT')) !!}
                    <div class="modal-body">
                      <div class="form-group"> {{Form::label('purpose_id', __('expense.purpose_name').':', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                          <select name="purpose_id" for="purpose_id" class="form-control" >
                            <option value="">{{__('same.select') }}</option>
                            @foreach($allPurpose as $purpose)
                            <option value="{{$purpose->id}}" {{($data->purpose_id==$purpose->id) ? 'selected':''}}>{{$purpose->purpose_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group"> {{Form::label('date', __('expense.date').':', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                          <input type="text" name="date" class="form-control wsit_datepicker" value="{{date('m/d/Y',strtotime($data->date))}}">
                        </div>
                      </div>
                      <div class="form-group"> {{Form::label('note', __('expense.details').':', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                          <textarea name="note" class="form-control">{{$data->note}}</textarea>
                        </div>
                      </div>
                      <div class="form-group"> {{Form::label('amount', __('expense.expense_amount').':', array('class' => 'col-md-3 control-label'))}}
                        <div class="col-md-8">
                          <input type="text" name="amount" value="{{$data->amount}}" class="form-control decimal" >
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-4 pull-right">
                          <button type="button" class="btn btn-default" data-dismiss="modal">{{__('same.close') }}</button>
                          {{Form::submit(__('same.update'),array('class'=>'btn btn-warning'))}} </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                  <div class="modal-footer"> </div>
                  {!! Form::close() !!} </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
            </td>
          </tr>
          @endforeach
          @if($countRow==0)
          <tr>
            <td colspan="7" align="center"><h2>{{__('same.empty_row') }}</h2></td>
          </tr>
          @endif
          </tbody>
          
        </table>
        <div align="center">{{ $allData->render() }}</div>
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
          <h4 class="modal-title"><i class="fa fa-plus-square color-green"></i> {{__('expense.add_new_purpose') }}</h4>
        </div>
        {!! Form::open(array('route' =>['expense-list.store'],'class'=>'form-horizontal','method'=>'POST')) !!}
        <div class="modal-body">
          <div class="form-group"> {{Form::label('purpose_id', __('expense.purpose_name').':', array('class' => 'col-md-3 control-label'))}}
            <div class="col-md-8">
              <select name="purpose_id" for="purpose_id" class="form-control" required>
                <option value="">{{__('same.select') }}</option>
                @foreach($allPurpose as $purpose)
                <option value="{{$purpose->id}}">{{$purpose->purpose_name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group"> {{Form::label('date', __('expense.date').':', array('class' => 'col-md-3 control-label'))}}
            <div class="col-md-8">
              <input type="text" name="date" class="form-control wsit_datepicker" required>
            </div>
          </div>
          <div class="form-group"> {{Form::label('note', __('expense.details').':', array('class' => 'col-md-3 control-label'))}}
            <div class="col-md-8">
              <textarea name="note" class="form-control"></textarea>
            </div>
          </div>
          <div class="form-group"> {{Form::label('amount', __('expense.expense_amount').':', array('class' => 'col-md-3 control-label'))}}
            <div class="col-md-8">
              <input type="text" name="amount" class="form-control decimal" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-4 pull-right">
              <button type="button" class="btn btn-default" data-dismiss="modal">{{__('same.close') }}</button>
              {{Form::submit(__('same.save'),array('class'=>'btn btn-success'))}} </div>
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