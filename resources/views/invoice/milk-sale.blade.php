@extends('layouts.layout')
@section('title', __('sale_milk.invoice_title'))
@section('content')
<section class="content-header">
  <h1><i class="icon-docs"></i> {{__('sale_milk.invoice_title') }}</h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-dashboard"></i> {{__('same.home') }}</li>
    <li class="active">{{__('sale_milk.invoice') }}</li>
  </ol>
</section>
<?php 
$configuration_data = \App\Library\farm::get_system_configuration('system_config'); 
$branchFullData = DB::table('branchs')->where('id', Session::get('branch_id'))->first();
?>
<section class="content"> @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="{{URL::to('sale-milk')}}" class="btn btn-default btn-sm"><i class="icon-list"></i> {{__('same.back') }}</a> <a href="javascript:;" class="printReport btn btn-default btn-sm"><i class="icon-printer"></i> {{__('same.print') }}</a> </div>
    <div class="box-body">
      <div class="container" id="print-box">
        <div class="card">
          <div class="card-header"> {{__('sale_milk.invoice') }} <strong> #000{{$single_data->id}}</strong> <span class="float-right"> <strong>{{__('sale_milk.issue_date') }} :</strong> {{Carbon\Carbon::parse($single_data->date)->format('d/m/Y')}}</span> </div>
          <div class="card-body">
            <div class="row mb-4">
              <div class="col-sm-8">
                <h6 class="mb-3">{{__('sale_milk.form') }} :</h6>
                <div> <strong>@if(!empty($configuration_data) && !empty($configuration_data->topTitle)){{ $configuration_data->topTitle }}@endif</strong> </div>
                <div>@if(!empty($branchFullData->branch_name)){{$branchFullData->branch_name}}@endif</div>
                <div>@if(!empty($branchFullData->branch_address)){{$branchFullData->branch_address}}@endif</div>
                <div>Email: @if(!empty($branchFullData->phone_number)){{$branchFullData->phone_number}}@endif</div>
                <div>Phone: @if(!empty($branchFullData->email)){{$branchFullData->email}}@endif</div>
              </div>
              <div class="col-sm-4">
                <h6 class="mb-3">{{__('sale_milk.to') }} :</h6>
                <div> <strong>@if(!empty($single_data) && !empty($single_data->name)){{ $single_data->name }}@endif</strong> </div>
                <div>Phone: @if(!empty($single_data) && !empty($single_data->contact)){{ $single_data->contact }}@endif</div>
                <div>Email: @if(!empty($single_data) && !empty($single_data->email)){{ $single_data->email }}@endif</div>
                <div>Address: @if(!empty($single_data) && !empty($single_data->address)){{ $single_data->address }}@endif</div>
              </div>
            </div>
            <div class="table-responsive-sm overflowauto">
              <table class="table table-striped invoice_table">
                <thead>
                  <tr>
                    <th class="center">{{__('sale_milk.account_no') }}</th>
                    <th>{{__('sale_milk.description') }}</th>
                    <th>{{__('sale_milk.liter') }}</th>
                    <th>{{__('sale_milk.price') }}</th>
                    <th class="right">{{__('sale_milk.total') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="center">{{$single_data->milk_account_number}}</td>
                    <td class="left">{{__('sale_milk.milk_sale') }}</td>
                    <td class="center">{{$single_data->litter}}</td>
                    <td class="right">{{App\Library\farm::currency($single_data->rate)}}</td>
                    <td class="right">{{App\Library\farm::currency($single_data->total_amount )}}</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right"><strong>{{__('sale_milk.total') }} : </strong> </td>
                    <td align="left">{{App\Library\farm::currency($single_data->total_amount)}}</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right"><strong>{{__('sale_milk.paid') }} : </strong> </td>
                    <td align="left">{{App\Library\farm::currency($sale_paid_amount)}}</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right"><strong>{{__('sale_milk.due') }} : </strong> </td>
                    <td align="left">{{App\Library\farm::currency($sale_due_amount)}}</td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="row"> @if(!empty($sale_due_amount) && (float)$sale_due_amount > 0)
              <div class="col-lg-8 paymentsttausbox">
                <div><img class="payment_status_icon" src="{{asset("public/common/due.png")}}" /></div>
              </div>
              @else
              <div class="col-lg-8"><img class="payment_status_icon" src="{{asset("public/common/paid.png")}}" /></div>
              @endif </div>
            <br/>
            <br/>
          </div>
        </div>
      </div>
      <div class="box-footer"> </div>
    </div>
  </div>
</section>
{!!Html::style('public/custom/css/print.css')!!}
<input type="hidden" id="print_url_1" value='{!!Html::style("public/custom/css/bootstrap.min.css")!!}' />
<input type="hidden" id="print_url_2" value='{!!Html::style("public/custom/css/print.css")!!}' />
@endsection 