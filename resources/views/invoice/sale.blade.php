@extends('layouts.layout')
@section('title', __('invoice.title'))
@section('content')
<section class="content-header">
  <h1><i class="icon-docs"></i> {{__('invoice.title') }}</h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-dashboard"></i> {{__('same.home') }}</li>
    <li class="active">{{__('same.invoice') }}</li>
  </ol>
</section>
<?php 
$configuration_data = \App\Library\farm::get_system_configuration('system_config'); 
$branchFullData = DB::table('branchs')->where('id', Session::get('branch_id'))->first();
?>
<section class="content"> @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="{{URL::to('sale-cow')}}" class="btn btn-default btn-sm"><i class="icon-list"></i> {{__('same.back') }}</a> <a href="javascript:;" class="btn btn-default btn-sm printReport"><i class="icon-printer"></i> {{__('same.print') }}</a> </div>
    <div class="box-body">
      <div class="container" id="print-box">
        <div class="card">
          <div class="card-header"> Invoice <strong> #000{{$single_data->id}}</strong> <span class="float-right"> <strong>Issue Date:</strong> {{Carbon\Carbon::parse($single_data->date)->format('d/m/Y')}}</span> </div>
          <div class="card-body">
            <div class="row mb-4">
              <div class="col-sm-8">
                <h6 class="mb-3">{{__('invoice.from') }}:</h6>
                <div> <strong>@if(!empty($configuration_data) && !empty($configuration_data->topTitle)){{ $configuration_data->topTitle }}@endif</strong> </div>
                <div>@if(!empty($branchFullData->branch_name)){{$branchFullData->branch_name}}@endif</div>
                <div>@if(!empty($branchFullData->branch_address)){{$branchFullData->branch_address}}@endif</div>
                <div>{{__('invoice.email') }}: @if(!empty($branchFullData->phone_number)){{$branchFullData->phone_number}}@endif</div>
                <div>{{__('invoice.phone') }}: @if(!empty($branchFullData->email)){{$branchFullData->email}}@endif</div>
              </div>
              <div class="col-sm-4">
                <h6 class="mb-3">{{__('invoice.to') }}:</h6>
                <div> <strong>@if(!empty($single_data) && !empty($single_data->customer_name)){{ $single_data->customer_name }}@endif</strong> </div>
                <div>{{__('invoice.phone') }}: @if(!empty($single_data) && !empty($single_data->customer_number)){{ $single_data->customer_number }}@endif</div>
                <div>{{__('invoice.email') }}: @if(!empty($single_data) && !empty($single_data->email)){{ $single_data->email }}@endif</div>
                <div>{{__('invoice.address') }}: @if(!empty($single_data) && !empty($single_data->address)){{ $single_data->address }}@endif</div>
              </div>
            </div>
            <div class="table-responsive-sm table_scroll">
              <table class="table table-striped invoice_table">
                <thead>
                  <tr>
                    <th class="center">#</th>
                    <th>{{__('invoice.item') }}</th>
                    <th>{{__('invoice.description') }}</th>
                    <th>{{__('invoice.price') }}</th>
                    <th class="right">{{__('invoice.total') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $cowInfo = DB::table('cow_sale_dtls')->where('sale_id', $single_data->id)->get(); ?>
                  <?php if(!empty($cowInfo)) { ?>
                @foreach($cowInfo as $cowInfoData)
                <?php  
									  if($cowInfoData->cow_type==1) {
                                        $dataInfo = DB::table('animals')
										->leftJoin('sheds', 'sheds.id', 'animals.shade_no')
										->leftJoin('animal_type', 'animal_type.id', 'animals.animal_type')
                                        ->where('animals.id', $cowInfoData->cow_id)
                                        ->select('animals.*', 'sheds.shed_number', 'animal_type.type_name')->first();
                                      } else {
                                          $dataInfo = DB::table('calf')
										  ->leftJoin('sheds', 'sheds.id', 'calf.shade_no')
                                          ->leftJoin('animal_type', 'animal_type.id', 'calf.animal_type')
										  ->where('calf.id', $cowInfoData->cow_id)
                                          ->select('calf.*', 'sheds.shed_number', 'animal_type.type_name')->first();
                                      }
									  
                                    ?>
                <tr>
                  <td class="center">000{{$dataInfo->id}}</td>
                  <td class="left strong">{{ $cowInfoData->cow_type==1 ? __('cow_sale.cow') : __('cow_sale.calf') }}</td>
                  <td class="left">{{ $dataInfo->type_name }} ({{ $dataInfo->gender }})</td>
                  <td class="right">{{App\Library\farm::currency($cowInfoData->price)}}</td>
                  <td class="right">{{App\Library\farm::currency($cowInfoData->price)}}</td>
                </tr>
                @endforeach
                <?php } ?>
                </tbody>
                
                <?php 
					$collect_payment = DB::table('cow_sale_payments')->where('sale_id', $single_data->id)->sum('pay_amount');
					$due_amount = 0;
					if(!empty($collect_payment) && (float)$collect_payment > 0){
						$due_amount = (float)$single_data->total_price - (float)$collect_payment;
					}
				?>
                <tfoot>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right"><strong>{{__('invoice.total') }} : </strong> </td>
                    <td align="left">{{App\Library\farm::currency($single_data->total_price)}}</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right"><strong>{{__('invoice.paid') }} : </strong> </td>
                    <td align="left">{{App\Library\farm::currency(!empty($collect_payment) ? $collect_payment : 0)}}</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right"><strong>{{__('invoice.due') }} : </strong> </td>
                    <td align="left">{{App\Library\farm::currency($due_amount)}}</td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="row"> @if(!empty($due_amount) && (float)$due_amount > 0)
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