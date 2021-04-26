@extends('layouts.layout')
@section('title', __('cow_sale.title_entry'))
@section('content')  
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="fa fa-paw"></i> {{__('cow_sale.title_entry') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
	<li class="active">{{__('cow_sale.title_entry') }}</l
  ></ol>
</section>
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  <div class="box box-success">
  	@if(empty($single_data))
      {{  Form::open(array('route' => 'sale-cow.store', 'method' => 'post', 'files' => true))  }}
      <?php $btn_name = __('same.save'); ?>
    @else
      {{  Form::open(array('route' => ['sale-cow.update',$single_data->id], 'method' => 'PUT', 'files' => true))  }}
      <?php $btn_name = __('same.update'); ?>
    @endif 
    <div class="box-header with-border" align="right">
		<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-floppy-o"></i> <b>{{$btn_name}} {{__('same.information') }}</b></button>
		<a href="{{  url('sale-cow/create')  }}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> <b> {{__('same.refresh') }}</b></a>
		&nbsp;&nbsp; 	
	</div>
   	<div class="box-body">
	    <div class="col-md-10 col-md-offset-1">
	    	<div class="panel panel-default">
		    	<div class="panel-heading feed-heading"><i class="fa fa-info-circle"></i>&nbsp;{{__('same.information') }} :</div>
		    	<div class="panel-body">
		    		<div class="row">
		    			<div class="col-md-12"> 
		    				<div class="col-md-4"> 
								<div class="form-group">
							    	<label for="date">{{__('cow_sale.date') }} <span class="validate">*</span> : </label>
							    	<input type="text" name="sale_date" class="form-control wsit_datepicker" value="{{(!empty($single_data->date))?date('m/d/Y', strtotime($single_data->date)):''}}" required>
							   	</div>
							</div>
		    				<div class="col-md-4"> 
								<div class="form-group">
							    	<label for="customer_name">{{__('cow_sale.customer_name') }} <span class="validate">*</span> : </label>
							    	<input type="text" name="customer_name" class="form-control" value="{{(!empty($single_data->customer_name))?$single_data->customer_name:''}}" required>
							   	</div>
							</div>
							<div class="col-md-4"> 
								<div class="form-group">
							    	<label for="customer_number">{{__('cow_sale.customer_phone') }} <span class="validate">*</span> : </label>
							    	<input type="text" name="customer_number" class="form-control" value="{{(!empty($single_data->customer_number))?$single_data->customer_number:''}}" required>
							   	</div>
							</div>
							<div class="col-md-12"> 
								<div class="form-group">
							    	<label for="customer_number">{{__('cow_sale.customer_email') }} <span class="validate">*</span> : </label>
							    	<input type="text" name="email" class="form-control" value="{{(!empty($single_data->email))?$single_data->email:''}}" required>
							   	</div>
							</div>
							<div class="col-md-12"> 
								<div class="form-group">
							    	<label for="address">{{__('cow_sale.address') }} : </label>
							    	<textarea name="address" class="form-control">{{(!empty($single_data->address))?$single_data->address:''}}</textarea>
							   	</div>
							</div>
							<div class="col-md-12"> 
								<div class="form-group">
							    	<label for="note">{{__('cow_sale.note') }} : </label>
							    	<textarea name="note" class="form-control">{{(!empty($single_data->note))?$single_data->note:''}}</textarea>
							   	</div>
							</div>
						</div>
					</div>
				</div>
		  	</div>
		</div>

		<div class="col-md-10 col-md-offset-1">
	    	<div class="panel panel-default">
				<div class="panel-heading feed-heading">
					<i class="fa fa-info-circle"></i> {{__('cow_sale.cow_selection') }}
					<button type="button" name="" id="increaserf" onclick="addMoreImageForSellCow();" data-toggle="tooltip" class="btn btn-warning btn-xs pull-right"><i class="fa fa-plus-circle"></i>&nbsp; Add New </button>
				</div>
				<?php $num_row = 0; ?>
				<div class="panel-body">
					<table class="table table-responsive table-striped table-bordered">
						<th class="th-width-180">{{__('cow_sale.image') }}</th>
						<th>{{__('cow_sale.animal_type') }}</th>
						<th>{{__('cow_sale.animal_id') }}</th>
						<th>{{__('cow_sale.stall_no') }}</th>
						<th>{{__('cow_sale.sell_price') }}</th>
						<th>{{__('same.action') }}</th>
						<tbody id="cow_list">
							@if(isset($single_data))
								<?php  
									$cowInfo = DB::table('cow_sale_dtls')
                                          ->where('sale_id', $single_data->id)
                                          ->get();
									
								?>
								@foreach($cowInfo as $cowInfoData)
	                                <?php  
	                                  if($cowInfoData->cow_type==1){
	                                    $dataInfo = DB::table('animals')->leftJoin('sheds', 'sheds.id', 'animals.shade_no')
	                                    ->where('animals.id', $cowInfoData->cow_id)
	                                    ->select('animals.*', 'sheds.shed_number')->first();

	                                    $cowArr = DB::table('animals')
	                                    		->where('animals.branch_id', Session::get('branch_id'))
	                                    		->get();
	                                  }else{
	                                    $dataInfo = DB::table('calf')->leftJoin('sheds', 'sheds.id', 'calf.shade_no')
	                                    ->where('calf.id', $cowInfoData->cow_id)
	                                    ->select('calf.*', 'sheds.shed_number')->first();

	                                    $cowArr = DB::table('calf')
	                                    		->where('calf.branch_id', Session::get('branch_id'))
	                                    		->get();
	                                  }

	                                  	if(!empty($dataInfo->pictures) && file_exists("storage/app/public/uploads/animal/".explode('_', $dataInfo->pictures)[0])){
							                $picture="storage/app/public/uploads/animal/".trim(explode('_', $dataInfo->pictures)[0]);
							            }
							            else{
							                $picture = 'public/custom/img/noImage.jpg';
							            }
	                                ?>
									<tr id="tr_{{$num_row}}">
										<td>
											<img src="{{asset($picture)}}" id="img_{{$num_row}}" class="img-thumbnail img-width-150">
										</td>
										<td class="verticalAlign">
									    	<select class="form-control" id="cowtype_{{$num_row}}" name="cowdtls[{{$num_row}}][cow_type]" data-noimage="{{asset('public/custom/img/noImage.jpg')}}" data-url="{{URL::to('load-cow-calf')}}" onchange="loadCowSell('{{$num_row}}', this);">
									    		<option value="">{{__('same.select') }}</option>
									    		<option value="1" {{($cowInfoData->cow_type==1)?'selected':''}}>{{__('cow_sale.cow') }}</option>
										    	<option value="2" {{($cowInfoData->cow_type==2)?'selected':''}}>{{__('cow_sale.calf') }}</option>
										    </select>
										</td>
										<td class="verticalAlign">
											<select class="form-control" id="cowid_{{$num_row}}" name="cowdtls[{{$num_row}}][cow_id]" onchange="changeCow('{{$num_row}}');">
									    		<option value="">{{__('same.select') }}</option>
									    		@foreach($cowArr as $cowdata)
									    		<option value="{{$cowdata->id}}" {{($cowdata->id==$cowInfoData->cow_id)?'selected':''}}>
									    			000{{$cowdata->id}}
									    		</option>
									    		@endforeach
										    </select>
										</td>
										<td class="verticalAlign">
											<input type="hidden" id="shedno_{{$num_row}}" name="cowdtls[{{$num_row}}][shed_no]" class="form-control" value="{{$dataInfo->shade_no}}">
											<span class="stall_box_style" id="shedname_{{$num_row}}">
												{{$dataInfo->shed_number}}
											</span>
										</td>
										<td class="verticalAlign">
											<input type="text" id="sellprice_{{$num_row}}" name="cowdtls[{{$num_row}}][price]" class="form-control cowprice" onkeyup="totalPriceCowSell();" value="{{(!empty($cowInfoData->price))?$cowInfoData->price:'0.00'}}">
										</td>
										<td class="verticalAlign">
											<a href="javascript:;" onclick="$('#tr_{{$num_row}}').remove();" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></a>
										</td>
									</tr>
									<?php $num_row++; ?>
								@endforeach
							@else
								<tr id="tr_{{$num_row}}">
									<td>
										<img src="{{asset('public/custom/img/noImage.jpg')}}" id="img_{{$num_row}}" class="img-thumbnail img-width-150">
									</td>
									<td class="verticalAlign">
								    	<select class="form-control" id="cowtype_{{$num_row}}" name="cowdtls[{{$num_row}}][cow_type]" data-noimage="{{asset('public/custom/img/noImage.jpg')}}" data-url="{{URL::to('load-cow-calf')}}" onchange="loadCowSell('{{$num_row}}', this);">
								    		<option value="">{{__('same.select') }}</option>
								    		<option value="1">{{__('cow_sale.cow') }}</option>
									    	<option value="2">{{__('cow_sale.calf') }}</option>
									    </select>
									</td>
									<td class="verticalAlign">
										<select class="form-control" id="cowid_{{$num_row}}" name="cowdtls[{{$num_row}}][cow_id]" onchange="changeCow('{{$num_row}}');">
								    		<option value="">{{__('same.select') }}</option>
									    </select>
									</td>
									<td class="verticalAlign">
										<input type="hidden" id="shedno_{{$num_row}}" name="cowdtls[{{$num_row}}][shed_no]" class="form-control" value="{{(!empty($single_data->shed_no))?$single_data->shed_no:''}}">
										<span class="stall_box_style" id="shedname_{{$num_row}}"></span>
									</td>
									<td class="verticalAlign">
										<input type="text" id="sellprice_{{$num_row}}" name="cowdtls[{{$num_row}}][price]" class="form-control cowprice" onkeyup="totalPriceCowSell();" value="{{(!empty($cowInfoData->price))?$cowInfoData->price:'0.00'}}">
									</td>
									<td class="verticalAlign">
										<a href="javascript:;" onclick="$('#tr_{{$num_row}}').remove();" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></a>
									</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
		    </div>
		</div>

		<div class="col-md-10 col-md-offset-1">
	    	<div class="panel panel-default">
		    	<div class="panel-heading feed-heading"><i class="fa fa-info-circle"></i>&nbsp;{{__('cow_sale.payment_information') }} :</div>
		    	<div class="panel-body">
		    		<div class="row">
		    			<div class="col-md-12"> 
		    				<div class="col-md-4"> 
								<div class="form-group">
							    	<label for="total_price">{{__('cow_sale.total_price') }} <span class="validate">*</span> : </label>
							    	<input type="text" name="total_price" class="form-control" value="{{(!empty($single_data->total_price))?$single_data->total_price:''}}" id="total_price" onkeyup="calculateCowSell();" required>
							   	</div>
							</div>
							<div class="col-md-4"> 
								<div class="form-group">
							    	<label for="total_paid">{{__('cow_sale.total_paid') }} <span class="validate">*</span> : </label>
							    	<input type="text" name="total_paid" class="form-control" value="{{(!empty($single_data->total_paid))?$single_data->total_paid:''}}" id="total_paid" onkeyup="calculateCowSell();" required>
							   	</div>
							</div>
							<div class="col-md-4"> 
								<div class="form-group">
							    	<label for="due">{{__('cow_sale.due_amount') }} : </label>
							    	<input type="text" name="due" class="form-control" value="{{(!empty($single_data->due))?$single_data->due:''}}" id="due">
							   	</div>
							</div>
						</div>
					</div>
				</div>
		  	</div>
		</div>

	</div>
  	{!! Form::close() !!} 
   </div>
</section>
<input type="hidden" id="site_assets_url" value="{{asset('/')}}" />
<input type="hidden" id="num_row_cs" value="{{ $num_row }}" />
<input type="hidden" id="no_image" value="{{asset('public/custom/img/noImage.jpg')}}" />
<input type="hidden" id="ddl_select_lang" value="{{__('same.select') }}" />
<input type="hidden" id="ddl_cow_lang" value="{{__('cow_sale.cow') }}" />
<input type="hidden" id="ddl_calf_lang" value="{{__('cow_sale.calf') }}" />
<input type="hidden" id="ddl_data_url" value="{{URL::to('load-cow-calf')}}" />
@endsection
