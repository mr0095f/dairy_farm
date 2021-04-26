@extends('layouts.layout')
@section('title', __('sale_milk.title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('sale_milk.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('sale_milk.title') }}</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="#saveModal" data-toggle="modal" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> <b> {{__('sale_milk.sale_new') }}</b></a> <a href="{{  url('sale-milk')  }}" class="btn btn-warning  btn-sm"><i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b></a> </div>
    <div class="box-body">
      <div class="form-group">
        <div class="clearfix"></div>
      </div>
      <div class="table_scroll">
        <table class="table table-bordered table-striped table-responsive">
          <th>#</th>
            <th>{{__('sale_milk.invoice') }}</th>
            <th>{{__('sale_milk.date') }}</th>
            <th>{{__('sale_milk.account_no') }}</th>
            <th>{{__('sale_milk.name') }}</th>
            <th>{{__('sale_milk.contact') }}</th>
            <th>{{__('sale_milk.email') }}</th>
            <th>{{__('sale_milk.liter') }}</th>
            <th>{{__('sale_milk.price') }}</th>
            <th>{{__('sale_milk.total') }}</th>
            <th>{{__('sale_milk.paid') }}</th>
            <th>{{__('sale_milk.due') }}</th>
            <th>{{__('sale_milk.sold_by') }}</th>
            <th>{{__('same.action') }}</th>
          <tbody>
            <?php                           
              $number = 1;
              $numElementsPerPage = 40; // How many elements per page
              $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
              $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
              $countRow = 0;
            ?>
          @foreach($allData as $data)
          <?php $countRow++; ?>
          <?php 		  
			  $total_paid = $data->collectPayments()->sum('pay_amount');
			  $total_due = (float)$data->total_amount - (float)$total_paid;
		  ?>
          <tr>
            <td><label class="label label-success">{{$currentNumber++}}</label>
            </td>
            <td><label class="label label-default lblfarm">000{{  $data->id  }}</label></td>
            <td>{{  date('m/d/Y',strtotime($data->date))  }}</td>
            <td>{{  $data->milk_account_number  }}</td>
            <td>{{  $data->name  }}</td>
            <td>{{  $data->contact  }}</td>
            <td>{{  $data->email  }}</td>
            <td>{{  $data->litter  }}</td>
            <td>{{  App\Library\farm::currency($data->rate)  }}</td>
            <td>
            <label class="label label-success lblfarm">
            {{  App\Library\farm::currency($data->total_amount)  }}
            <label>
            </td>
            <td><label class="label label-warning lblfarm">{{  App\Library\farm::currency($total_paid) }}</label></td>
            <td><label class="label label-danger lblfarm">{{  App\Library\farm::currency($total_due) }}</label></td>
            <td>{{  $data->sold_by  }} <b>({{  $data->user_type  }})</b></td>
            <td><div class="form-inline">
                <div class = "input-group"> <a target="_blank" href="{{URL::to('sale-milk-invoice')}}/{{$data->id}}" class="btn btn-default btn-xs" title="{{__('same.invoice') }}"><i class="icon-doc"></i></a> </div>
                <div class = "input-group"> <a href="#editModal{{$data->id}}" data-toggle="modal" class="btn btn-success btn-xs" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                <div class = "input-group"> {{Form::open(array('route'=>['sale-milk.destroy',$data->id],'method'=>'DELETE'))}}
                  <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                  {!! Form::close() !!} </div>
              </div>
              <!-- Modal -->
              <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><i class="fa fa-edit edit-color"></i> {{__('sale_milk.edit_information') }}</h4>
                    </div>
                    {!! Form::open(array('route' =>['sale-milk.update', $data->id],'class'=>'form-horizontal','method'=>'PUT')) !!}
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <div class="col-md-6">
                              <label for="milk_account_number">{{__('sale_milk.account_number') }} <span class="validate">*</span> : </label>
                              <select name="milk_account_number" id="milk_account_number_{{$data->id}}" class="form-control" onchange="calculateSaleMilkSaleMilk('{{$data->id}}', this)" required>
                                <option value="">{{__('same.select') }}</option>
                                
                                 	@foreach($milkData as $milkDataInfo)
                                
                                <option value="{{$milkDataInfo->account_number}}" data-price="{{$milkDataInfo->liter_price}}" {{$milkDataInfo->account_number==$data->milk_account_number?'selected':''}}>
                                {{$milkDataInfo->account_number}} [ Date - {{date('M d, Y', strtotime($milkDataInfo->date))}}] [Collected Milk {{$milkDataInfo->liter}} Liter] </option>
                                
                                    @endforeach
                              
                              </select>
                            </div>
                            <div class="col-md-6">
                              <label for="supplier_id">{{__('sale_milk.supplier') }} : </label>
                              <select name="supplier_id" id="supplier_id_{{$data->id}}" class="form-control" onchange="loadSupplierData({{$data->id}})">
                                <option value="">{{__('same.select') }}</option>
                                
                                     @foreach($supplierArr as $supplierData)
                                
                                <option value="{{$supplierData->id}}" data-name="{{$supplierData->name}}" data-email="{{$supplierData->mail_address}}"data-phn_number="{{$supplierData->phn_number}}" data-address="{{$supplierData->present_address}}" {{$supplierData->id==$data->supplier_id?'selected':''}}>
                                {{$supplierData->name}} [ Company: {{$supplierData->company_name}}] </option>
                                
                                     @endforeach
                              
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-6">
                              <label for="name">{{__('sale_milk.name') }} <span class="validate">*</span> : </label>
                              <input type="text" name="name" id="name_{{$data->id}}" class="form-control" value="{{$data->name}}" required >
                            </div>
                            <div class="col-md-6">
                              <label for="contact">{{__('sale_milk.contact') }} : </label>
                              <input type="text" name="contact" id="contact_{{$data->id}}" value="{{$data->contact}}" class="form-control" >
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <label for="email">{{__('sale_milk.email') }} <span class="validate">*</span> : </label>
                              <input type="text" name="email" id="email_{{$data->id}}" class="form-control" value="{{$data->email}}" required >
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <label for="address">{{__('sale_milk.address') }} : </label>
                              <textarea name="address" id="address_{{$data->id}}" class="form-control">{{$data->address}}</textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-6">
                              <label for="litter">{{__('sale_milk.liter') }} <span class="validate">*</span> : </label>
                              <input type="text" name="litter" id="liter_{{$data->id}}" value="{{$data->litter}}" onkeyup="calculateSaleMilk('{{$data->id}}')" class="form-control decimal" required >
                            </div>
                            <div class="col-md-6">
                              <label for="rate">{{__('sale_milk.price_litre') }} : </label>
                              <input type="text" name="rate" id="liter_price_{{$data->id}}" value="{{$data->rate}}" onkeyup="calculateSaleMilk('{{$data->id}}')" class="form-control" required readonly >
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-6">
                              <label for="total_amount">{{__('sale_milk.total') }} : </label>
                              <input type="text" name="total_amount" id="total_{{$data->id}}" value="{{$data->total_amount}}" class="form-control" required readonly>
                            </div>
                            <div class="col-md-6">
                              <label for="paid">{{__('sale_milk.paid') }} : </label>
                              <input type="text" name="paid" id="paid_{{$data->id}}" value="{{$data->paid}}" onkeyup="calculateSaleMilk('{{$data->id}}')" class="form-control decimal">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <label for="due">{{__('sale_milk.due') }} <span class="validate">*</span> : </label>
                              <input type="text" name="due" id="due_{{$data->id}}" value="{{$data->due}}" class="form-control" readonly>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12" align="right">
                              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"> {{__('same.close') }} </button>
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
            <td colspan="12" align="center"><h2>{{__('same.empty_row') }}</h2></td>
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
          <h4 class="modal-title"><i class="fa fa-plus-square color-green"></i> {{__('sale_milk.sale_milk') }}</h4>
        </div>
        {!! Form::open(array('route' =>['sale-milk.store'],'class'=>'form-horizontal','method'=>'POST')) !!}
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-12">
                  <label for="milk_account_number">{{__('sale_milk.account_no') }} <span class="validate">*</span> : </label>
                  <select name="milk_account_number" id="milk_account_number_0" class="form-control" onchange="calculateSaleMilk(0, this)" required>
                    <option value="">{{__('same.select') }}</option>
                     @foreach($milkData as $milkDataInfo)
                    <option value="{{$milkDataInfo->account_number}}" data-stock="{{$milkDataInfo->liter}}" data-price="{{$milkDataInfo->liter_price}}"> {{$milkDataInfo->account_number}} [ Date - {{date('M d, Y', strtotime($milkDataInfo->date))}}] [Collected Milk {{$milkDataInfo->liter}} Liter] </option>
                     @endforeach
                  </select>
                </div>
              </div>
              <div class="panel panel-default" id="view-stock-info">
                <div class="panel-body">
                  <h4><u><b>{{__('sale_milk.account_information') }}</b></u></h4>
                  <div class="col-md-12 row">
                    <div class="col-md-6 row" id="milk-in-stock" align="center">
                      <div class="available">{{__('sale_milk.available') }} : <span></span> {{__('sale_milk.liter') }}</div>
                    </div>
                    <div class="col-md-3 row" id="stock-paid" align="center">
                      <div class="paid">{{__('sale_milk.paid') }} : <span></span></div>
                    </div>
                    <div class="col-md-3 row" id="stock-due" align="right">
                      <div class="due">{{__('sale_milk.due') }} : <span></span></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="supplier_id">{{__('sale_milk.supplier') }} : </label>
                  <select name="supplier_id" id="supplier_id_0" class="form-control" onchange="loadSupplierData(0)">
                    <option value="">{{__('same.select') }}</option>
                            @foreach($supplierArr as $supplierData)
                    <option value="{{$supplierData->id}}" data-name="{{$supplierData->name}}" data-email="{{$supplierData->mail_address}}" data-phn_number="{{$supplierData->phn_number}}" data-address="{{$supplierData->present_address}}"> {{$supplierData->name}} [ Company: {{$supplierData->company_name}}] </option>
                            @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-6">
                  <label for="name">{{__('sale_milk.name') }} <span class="validate">*</span> : </label>
                  <input type="text" name="name" id="name_0" class="form-control" required >
                </div>
                <div class="col-md-6">
                  <label for="contact">{{__('sale_milk.contact') }} : </label>
                  <input type="text" name="contact" id="contact_0" class="form-control" >
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="email">{{__('sale_milk.email') }} <span class="validate">*</span> : </label>
                  <input type="text" name="email" id="email_0" class="form-control" required >
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="address">{{__('sale_milk.address') }} : </label>
                  <textarea name="address" id="address_0" class="form-control"></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-6">
                  <label for="litter">{{__('sale_milk.liter') }} <span class="validate">*</span> : </label>
                  <input type="text" name="litter" id="liter_0" onkeyup="calculateSaleMilk(0)" class="form-control decimal" required >
                </div>
                <div class="col-md-6">
                  <label for="rate">{{__('sale_milk.price_litre') }} : </label>
                  <input type="text" name="rate" id="liter_price_0" onkeyup="calculateSaleMilk(0)" class="form-control" required readonly >
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-6">
                  <label for="total_amount">{{__('sale_milk.total') }} : </label>
                  <input type="text" name="total_amount" id="total_0" class="form-control" required readonly>
                </div>
                <div class="col-md-6">
                  <label for="paid">{{__('sale_milk.paid') }} <span class="validate">*</span> : </label>
                  <input type="text" name="paid" id="paid_0" onkeyup="calculateSaleMilk(0)" class="form-control decimal" required>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12">
                  <label for="due">{{__('sale_milk.due') }} : </label>
                  <input type="text" name="due" id="due_0" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12" align="right">
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"> {{__('same.close') }} </button>
                  <button type="submit" name="save" class="btn btn-success btn-sm"> {{__('same.save') }} </button>
				  <button type="submit" name="invoice" class="btn btn-warning btn-sm"> {{__('sale_milk.generate_invoice') }} </button>
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
  <input type="hidden" id="hdnStockUrl" value="{{URL::to('get-stock-status')}}" />
</section>
<!-- /.content -->
@endsection 