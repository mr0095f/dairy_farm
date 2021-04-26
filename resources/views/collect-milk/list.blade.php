@extends('layouts.layout')
@section('title', __('collect_milk.title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('collect_milk.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('collect_milk.title') }}</li>
  </ol>
</section>
<?php
use App\Models\Animal;
?>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="#saveModal" data-toggle="modal" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> <b> {{__('collect_milk.collect_new') }}</b></a> <a href="{{  url('collect-milk')  }}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b></a> </div>
    <div class="box-body">
      <div class="form-group">
        <div class="clearfix"></div>
      </div>
      <div class="table_scroll">
        <table class="table table-bordered table-striped table-responsive">
          <th>#</th>
            <th>{{__('same.date') }}</th>
            <th>{{__('collect_milk.account_no') }}</th>
            <th>{{__('same.stall_no') }}</th>
            <th>{{__('collect_milk.animal_id') }}</th>
            <th>{{__('collect_milk.liter') }}</th>
            <th>{{__('collect_milk.fate') }}</th>
            <th>{{__('collect_milk.price') }}</th>
            <th>{{__('collect_milk.total') }}</th>
            <th>{{__('collect_milk.collected_from') }}</th>
            <th>{{__('collect_milk.added_by') }}</th>
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
            <td>{{  $data->account_number  }}</td>
            <td><label class="label label-success lblfarm">{{  $data->shed_number  }}</label></td>
            <td><label class="label label-primary lblfarm">000{{  $data->dairy_number  }}</label></td>
            <td>{{  $data->liter  }}</td>
            <td>{{  $data->fate  }}</td>
            <td>{{  App\Library\farm::currency($data->liter_price)  }}</td>
            <td>{{  App\Library\farm::currency($data->total)  }}</td>
            <td>{{  $data->name  }}</td>
            <td>{{  $data->added_name  }} <b>({{  $data->user_type  }})</b></td>
            <td><div class="form-inline">
                <div class = "input-group"> <a href="#editModal{{$data->id}}" data-toggle="modal" class="btn btn-success btn-xs" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                <div class = "input-group"> {{Form::open(array('route'=>['collect-milk.destroy',$data->id],'method'=>'DELETE'))}}
                  <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                  {!! Form::close() !!} </div>
              </div>
              <!-- Modal -->
              <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><i class="fa fa-edit edit-color" class="edit-color"></i> {{__('collect_milk.edit_information') }}</h4>
                    </div>
                    {!! Form::open(array('route' =>['collect-milk.update', $data->id],'class'=>'form-horizontal','method'=>'PUT')) !!}
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="col-md-6">
                              <label for="account_number">
                              {{__('collect_milk.account_number') }}
                              <label class="fa fa-question-circle tooltip-color" data-toggle="tooltip" title="{{__('collect_milk.validate_warning') }}"></label>
                              <span class="validate">*</span> :
                              </label>
                              <input type="text" name="account_number" class="form-control" value="{{(!empty($data->account_number))?$data->account_number:''}}" required>
                            </div>
                            <div class="col-md-6">
                              <label for="name">{{__('collect_milk.collected_from_name') }} <span class="validate">*</span> : </label>
                              <input type="text" name="name" class="form-control" value="{{(!empty($data->name))?$data->name:''}}" required >
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <label for="address">{{__('collect_milk.address') }} : </label>
                              <textarea name="address" class="form-control">{{(!empty($data->address))?$data->address:''}}</textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-6">
                              <label for="dairy_number_{{$data->id}}">{{__('collect_milk.stall_number') }} <span class="validate">*</span> : </label>
                              <select class="form-control load-animal-milk-collect-page" id="dairy_number_{{$data->id}}" name="dairy_number" data-url="{{URL::to('get-animal-details')}}" data-select="animal_{{$data->id}}" required>
                                <option value="">{{__('same.select') }}</option>
								@foreach($all_sheds as $sheds)
                                	<option value="{{$sheds->id}}" {{(!empty($data))?($sheds->id==$data->stall_no)?'selected':'':''}}>{{$sheds->shed_number}}</option>
								@endforeach
                              </select>
                            </div>
                            <?php
								$animals = Animal::where('id', $data->dairy_number)->get();
							?>
                            <div class="col-md-6">
                              <label for="dairy_number">{{__('collect_milk.animal_id') }} <span class="validate">*</span> : </label>
                              <select id="animal_{{$data->id}}" class="form-control" id="dairy_number" name="dairy_number" required>
                              <option value="">-- None --</option>
                              @if(!empty($animals))
                              @foreach($animals as $animal)
                              <option value="{{$animal->id}}" {{(!empty($data))?($animal->id==$data->dairy_number)?'selected':'':''}}>000{{$animal->id}}</option>
                              @endforeach
                              @endif
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-6">
                              <label for="liter">{{__('collect_milk.liter') }} <span class="validate">*</span> : </label>
                              <input type="text" name="liter" id="liter_{{$data->id}}" onkeyup="calculate('{{$data->id}}')" class="form-control decimal" value="{{(!empty($data->liter))?$data->liter:''}}" required >
                            </div>
                            <div class="col-md-6">
                              <label for="fate">{{__('collect_milk.fate') }} (%) : </label>
                              <input type="text" name="fate" class="form-control decimal" value="{{(!empty($data->fate))?$data->fate:''}}" >
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <label for="liter_price">{{__('collect_milk.price_liter') }} <span class="validate">*</span> : </label>
                              <input type="text" name="liter_price" id="liter_price_{{$data->id}}" onkeyup="calculate('{{$data->id}}')" class="form-control decimal" value="{{(!empty($data->liter_price))?$data->liter_price:''}}" required >
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <label for="total">{{__('collect_milk.total') }} : </label>
                              <input type="text" name="total" id="total_{{$data->id}}" class="form-control" value="{{(!empty($data->total))?$data->total:''}}" readonly>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12" align="right">
                              <button type="button" class="btn btn-default  btn-sm" data-dismiss="modal"> {{__('same.close') }} </button>
							  <button type="submit" name="update" class="btn btn-warning btn-sm"> {{__('same.update') }} </button>
							  </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    {!! Form::close() !!} </div>
                  <!-- /.modal-content -->
                  <div class="modal-footer"> </div>
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
            </td>
          </tr>
          @endforeach
          @if($countRow==0)
          <tr>
            <td colspan="11" align="center"><h2>{{__('same.empty_row') }}</h2></td>
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
          <h4 class="modal-title"><i class="fa fa-plus-square color-green"></i> {{__('collect_milk.collect_milk') }}</h4>
        </div>
        {!! Form::open(array('route' =>['collect-milk.store'],'class'=>'form-horizontal','method'=>'POST')) !!}
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-6">
                  <label for="account_number">
                  {{__('collect_milk.account_no') }}
                  <label class="fa fa-question-circle tooltip-color" data-toggle="tooltip" title="Maintain daily same custom account number to store milk that account. Example: 25122020 (dmy)"></label>
                  <span class="validate">*</span> :
                  </label>
                  <input type="text" name="account_number" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label for="name">{{__('collect_milk.collected_from_name') }} <span class="validate">*</span> : </label>
                  <input type="text" name="name" class="form-control" required >
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="address">{{__('collect_milk.address') }} : </label>
                  <textarea name="address" class="form-control"></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-6">
                  <label for="stall_no">{{__('collect_milk.stall_number') }} <span class="validate">*</span> : </label>
                  <select class="form-control load-animal-milk-collect-page" name="stall_no" data-url="{{URL::to('get-animal-details')}}" data-select="dairy_number" required>
                    <option value="">{{__('same.select') }}</option>
					@foreach($all_sheds as $sheds)
                    	<option value="{{$sheds->id}}">{{$sheds->shed_number}}</option>
					@endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="dairy_number">{{__('collect_milk.animal_id') }} <span class="validate">*</span> : </label>
                  <select class="form-control" id="dairy_number" name="dairy_number" required>
                    <option value="">{{__('same.select') }}</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-6">
                  <label for="liter">{{__('collect_milk.liter') }} <span class="validate">*</span> : </label>
                  <input type="text" name="liter" id="liter_0" onkeyup="calculate(0)" class="form-control decimal" required >
                </div>
                <div class="col-md-6">
                  <label for="fate">{{__('collect_milk.fate') }} (%) : </label>
                  <input type="text" name="fate" class="form-control decimal" >
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="liter_price">{{__('collect_milk.price_liter') }} <span class="validate">*</span> : </label>
                  <input type="text" name="liter_price" id="liter_price_0" onkeyup="calculate(0)" class="form-control decimal" required >
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="total">{{__('collect_milk.total') }} : </label>
                  <input type="text" name="total" id="total_0" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12" align="right">
                  <button type="button" class="btn btn-default  btn-sm" data-dismiss="modal"> {{__('same.close') }} </button>
                  <button type="submit" name="save" class="btn btn-success btn-sm"> {{__('same.save') }} </button>
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