@extends('layouts.layout')
@section('title', __('cow_sale.title'))
@section('content')
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('cow_sale.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('cow_sale.title') }}</li>
  </ol>
</section>
<section class="content"> @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="{{  url('sale-cow/create')  }}" class="btn btn-success btn-sm" data-toggle="modal"> <i class="fa fa-plus-square"></i> <b>{{__('same.add_new') }}</b> </a> <a href="{{URL::to('sale-cow')}}" class="btn btn-warning btn-sm"> <i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b> </a> </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-responsive">
                <thead>
                  <tr>
                    <th>#{{__('same.invoice') }}</th>
                    <th>{{__('cow_sale.date') }}</th>
                    <th>{{__('cow_sale.customer_name') }}</th>
                    <th>{{__('cow_sale.customer_phone') }} </th>
                    <th>{{__('cow_sale.customer_email') }} </th>
                    <th>{{__('cow_sale.address') }} </th>
                    <th>{{__('cow_sale.total_price') }}</th>
                    <th>{{__('cow_sale.total_paid') }}</th>
                    <th>{{__('cow_sale.due') }}</th>
                    <th>{{__('cow_sale.note') }}</th>
                    <th>{{__('same.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                
                @foreach($allData as $saleinfo)
                <?php
				  	$total_paid = $saleinfo->collectPayments()->sum('pay_amount');
			 		$total_due = (float)$saleinfo->total_price - (float)$total_paid;
				  ?>
                <tr>
                  <td><label class="label label-default lblfarm">000{{$saleinfo->id}}</label></td>
                  <td>{{date('M d, Y', strtotime($saleinfo->date))}}</td>
                  <td>{{$saleinfo->customer_name}}</td>
                  <td>{{$saleinfo->customer_number}}</td>
                  <td>{{$saleinfo->email}}</td>
                  <td>{{$saleinfo->address}}</td>
                  <td><label class="label label-success lblfarm">{{ App\Library\farm::currency($saleinfo->total_price)}}</label></td>
                  <td><label class="label label-warning lblfarm">{{ App\Library\farm::currency($total_paid)}}</label></td>
                  <td><label class="label label-danger lblfarm">{{ App\Library\farm::currency($total_due)}}</label></td>
                  <td><a href="#view{{$saleinfo->id}}" class="btn btn-info btn-xs" data-toggle="modal"> <i class="fa fa-info-circle"></i> </a>
                    <!-- Modal Start -->
                    <div class="modal fade" id="view{{$saleinfo->id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa fa-info-circle edit-color"></i> {{__('cow_sale.note') }}</h4>
                          </div>
                          <div class="modal-body">
                            <p class="text-equal">{{$saleinfo->note}}</p>
                          </div>
                          <div class="modal-footer"></div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                  </td>
                  <td><!-- Modal Start -->
                    <div class="modal fade" id="cow{{$saleinfo->id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa fa-info-circle edit-color"></i> {{__('cow_sale.cow_details') }}</h4>
                          </div>
                          <div class="modal-body">
                            <?php  $cowInfo = DB::table('cow_sale_dtls')->where('sale_id', $saleinfo->id)->get(); ?>
                            <table class="table table-bordered table-striped table-responsive">
                              	<th>{{__('cow_sale.image') }}</th>
                                <th>{{__('cow_sale.cow_no') }}</th>
                                <th>{{__('cow_sale.stall_no') }}</th>
                                <th>{{__('cow_sale.gender') }}</th>
                                <th>{{__('cow_sale.weight') }} ({{__('same.kg') }})</th>
                                <th>{{__('cow_sale.height') }} ({{__('same.inch') }})</th>
                              <tbody>
                                <?php if(!empty($cowInfo)) { ?>
                              @foreach($cowInfo as $cowInfoData)
                              <?php  
									  if($cowInfoData->cow_type==1) {
                                        $dataInfo = DB::table('animals')->leftJoin('sheds', 'sheds.id', 'animals.shade_no')
                                        ->where('animals.id', $cowInfoData->cow_id)
                                        ->select('animals.*', 'sheds.shed_number')->first();
                                      } else {
                                          $dataInfo = DB::table('calf')->leftJoin('sheds', 'sheds.id', 'calf.shade_no')
                                          ->where('calf.id', $cowInfoData->cow_id)
                                          ->select('calf.*', 'sheds.shed_number')->first();
                                      }
                                    ?>
                              <tr>
                                <td> @if($dataInfo->pictures !='')
                                  @if(file_exists('storage/app/public/uploads/animal/'.explode('_', $dataInfo->pictures)[0])) <img src='{{asset("storage/app/public/uploads/animal")}}/{{explode("_", $dataInfo->pictures)[0]}}' class="img-thumbnail" width="100px"> @else <img src='{{asset("public/custom/img/noImage.jpg")}}' class="img-thumbnail" width="100px"> @endif
                                  @else <img src='{{asset("public/custom/img/noImage.jpg")}}' class="img-thumbnail" width="100px"> @endif </td>
                                <td>000 {{$dataInfo->id}}</td>
                                <td>{{$dataInfo->shed_number}}</td>
                                <td>{{$dataInfo->gender}}</td>
                                <td>{{$dataInfo->weight}}</td>
                                <td>{{$dataInfo->height}}</td>
                              </tr>
                              @endforeach
                              <?php } ?>
                              </tbody>
                              
                            </table>
                          </div>
                          <div class="modal-footer"></div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <div class="form-inline">
                      <div class = "input-group"> <a target="_blank" href="{{URL::to('sale-invoice')}}/{{$saleinfo->id}}" class="btn btn-default btn-xs" title="{{__('same.invoice') }}"><i class="icon-doc"></i></a> </div>
                      <div class = "input-group"> <a href="#cow{{$saleinfo->id}}" class="btn btn-primary btn-xs" data-toggle="modal" title="{{__('same.view') }}"><i class="icon-eye"></i></a> </div>
                      <div class = "input-group"> <a href="{{ route('sale-cow.edit', $saleinfo->id) }}" class="btn btn-success btn-xs" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                      <div class = "input-group"> {{Form::open(array('route'=>['sale-cow.destroy',$saleinfo->id],'method'=>'DELETE'))}}
                        <button type="submit" confirm="Are you sure you want to delete this information ?" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                        {!! Form::close() !!} </div>
                    </div></td>
                </tr>
                @endforeach
                </tbody>
                
              </table>
              <div class="col-md-12" align="center"> {{$allData->render()}} </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer"> </div>
  </div>
</section>
@endsection 