@extends('layouts.layout')
@section('title', __('sale_milk.due_title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('sale_milk.due_title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active"><a>{{__('sale_milk.due_title') }}</a></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success">
    <div class="box-body">
      <div class="form-group"> {!! Form::open(array('url' => 'get-milk-sale-history','class'=>'form-horizontal','autocomplete'=>'off','method' =>'GET')) !!}
        <div class="col-md-8 col-md-offset-2 mt20">
          <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-info-circle"></i> {{__('sale_milk.invoice_number') }}</div>
            <div class="panel-body pb250">
              <div class="col-md-8">
                <input name="invoice_id" value="{{isset($invoice_id)?$invoice_id:''}}" id="invoice_id" class="form-control decimal" placeholder="{{__('sale_milk.enter_invoice_number') }}" type="text">
              </div>
              <div class="col-md-4">
                <button type="submit" class="btn btn-success btn100"><i class="fa fa-search"></i> {{__('same.search') }}</button>
              </div>
            </div>
          </div>
        </div>
        {!! Form::close() !!}
        <div class="clearfix"></div>
      </div>
      <div class="col-md-12">
        <table class="table table-responsive table-striped table-bordered">
          <thead>
            <tr>
              <th>{{__('sale_milk.sl') }}</th>
              <th>{{__('sale_milk.date') }}</th>
              <th>{{__('sale_milk.invoice_number') }}</th>
              <th>{{__('sale_milk.paid_amount') }}</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php $sl = $totalPaid =0; ?>
          @if(isset($allData))
          @foreach($allData as $data)
          <?php $totalPaid += $data->pay_amount; ?>
          <tr>
            <td>{{++$sl}}</td>
            <td>{{date('F d, Y', strtotime($data->date))}}</td>
            <td>000{{$data->sale_id}}</td>
            <td>{{App\Library\farm::currency($data->pay_amount)}}</td>
            <td><div class = "input-group"> {{Form::open(array('route'=>['sale-milk-due-collection.destroy',$data->id],'method'=>'DELETE'))}}
                <input type="hidden" name="sale_id" value="{{$data->sale_id}}" />
                <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                {!! Form::close() !!} </div></td>
          </tr>
          @endforeach
          <tr>
            <td colspan="3" align="right"><b>{{__('sale_milk.total') }} {{__('sale_milk.paid') }} : </b></td>
            <td class="total-paid"><b>{{App\Library\farm::currency($totalPaid)}}</b></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="right"><b>{{__('sale_milk.total_amount') }} :</b></td>
            <td class="total-amount"><b>{{App\Library\farm::currency($data->total_amount)}}</b></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3" align="right"><b>{{__('sale_milk.due') }} :</b></td>
            <td class="due-amount"><b>{{App\Library\farm::currency($allData[0]->total_amount - $totalPaid)}}</b></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5" align="right"><a target="_blank" href="{{URL::to('sale-milk-invoice')}}/{{$data->sale_id}}" class="btn btn-default btn-sm"><b> <i class="icon-doc"></i> {{__('sale_milk.view_invoice') }}</b></a> @if($allData[0]->total_amount > $totalPaid) <a href="#paymentModal" data-toggle="modal" class="btn btn-success btn-sm"> <i class="fa fa-money"></i><b> {{__('sale_milk.pay_due') }}</b></a> @endif </td>
          </tr>
          @endif
          </tbody>
          
        </table>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="fa fa-plus-square total-paid"></i> {{__('sale_milk.add_new_payment') }}</h4>
            </div>
            {!! Form::open(array('url' =>['add-milk-sale-payment'],'class'=>'form-horizontal','method'=>'POST')) !!}
            <div class="modal-body">
              <div class="form-group">
                <div class="col-md-12"> {{Form::label('date', __('sale_milk.date'))}} <span class="validate">*</span> :
                  <input type="text" class="form-control wsit_datepicker" value="" name="date" placeholder="MM/DD/YYYY" required>
                  <input type="hidden" name="sale_id" value="{{isset($allData[0]->sale_id)?$allData[0]->sale_id:''}}">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-12"> {{Form::label('pay_amount', __('sale_milk.pay_amount'))}} <span class="validate">*</span> :
                  <input type="text" class="form-control decimal" value="" name="pay_amount" placeholder="{{__('sale_milk.enter_your_amount') }}" required>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-6"> </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12" align="right">
                      <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{__('same.close') }}</button>
					  {{Form::submit(__('same.save'),array('class'=>'btn btn-success  btn-sm'))}}
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
  </div>
  </div>
  <!-- /.box -->
</section>
<!-- /.content -->
@endsection 