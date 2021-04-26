<div class="row">
  <div class="col-md-12 ajax-page-bb" align="center">
    <h3><b>{{__('reports.animal_statistics_report') }}</b></h3>
  </div>
</div>
<div class="row ajax-page-pt15">
  <div class="col-md-12">
    <div class="col-md-6"> @if(isset($cow_score->new_images) && !empty($cow_score->new_images))
      <div class="owl-carousel cm-slider"> @foreach(explode('_', $cow_score->new_images) as $imageName)
        <div class="img-thumbnail"><img src="{{asset('storage/app/public/uploads/animal/'.$imageName)}}" /></div>
        @endforeach </div>
      @else
      <div class="owl-carousel cm-slider"> @foreach(explode('_', $single_data->pictures) as $imageName)
        <div class="img-thumbnail"><img src="{{asset('storage/app/public/uploads/animal/'.$imageName)}}" /></div>
        @endforeach </div>
      @endif </div>
    <div class="col-md-6 border paymentsttausbox">
      <table class="table table-bordered table-striped table-responsive">
        <tr>
          <td><b>{{__('cow_monitor.date_of_birth') }}</b></td>
          <td>{{(!empty($single_data->DOB))?Carbon\Carbon::parse($single_data->DOB)->format('M d, Y'):''}}</td>
        </tr>
        <tr>
          <td><b>{{__('cow_monitor.animal_live_age') }}</b></td>
          <td>{{(!empty($single_data->age)) ? \App\Library\farm::animalAgeFormat($single_data->DOB) : ''}}</td>
        </tr>
        <tr>
          <td><b>{{__('cow_monitor.buy_time_to_current') }}</b></td>
          <td>{{(!empty($single_data->buy_date)) ? \App\Library\farm::animalAgeFormat($single_data->buy_date) : ''}}</td>
        </tr>
        <tr>
          <td><b>{{__('cow_monitor.animal_gender') }}</b></td>
          <td>{{$single_data->gender}}</td>
        </tr>
        <tr>
          <td><b>{{__('cow_monitor.animal_status') }}</b></td>
          <td>@if($single_data->sale_status == '0')
            <label class="label label-success lblfarm">{{__('cow_monitor.available') }}</label>
            @else
            <label class="label label-danger lblfarm">{{__('cow_monitor.sold_out') }}</label>
            @endif</td>
        </tr>
        <tr>
          <td><b>{{__('cow_monitor.animal_type') }}</b></td>
          <td><label class="label label-success lblfarm">{{ (!empty($single_data->type_name)) ? $single_data->type_name : '' }}</label></td>
        </tr>
        <tr>
          <td><b>{{__('cow_monitor.vaccine_status') }}</b></td>
          <td>@if(!empty($vaccine_pending))
            <label class="label label-danger lblfarm">{{__('cow_monitor.pending') }}</label>
            @else
            <label class="label label-success lblfarm">{{__('cow_monitor.perfect') }}</label>
            @endif</td>
        </tr>
        @if(!empty($cow_score->health_score))
        <tr>
          <td><b>{{__('cow_monitor.health_status') }}</b></td>
          <td><?php
						$color = '';
						$message = '';
						$hc = $cow_score->health_score;
						if((int)$hc >= 80){
							$color = 'green';
							$message = __('cow_monitor.good_condition');
						} else if((int)$hc < 80 && (int)$hc > 50){
							$color = 'yellow';
							$message = __('cow_monitor.warning_condition');
						} else if((int)$hc <= 50){
							$color = 'red';
							$message = __('cow_monitor.danger_condition');
						}
					?>
            <div class="progress-group"> <span class="progress-text"><?php echo $message; ?></span> <span class="progress-number"><b>{{$cow_score->health_score}} </b>/100</span>
              <div class="progress sm">
                <div class="progress-bar progress-bar-<?php echo $color; ?>" style="width: {{$cow_score->health_score}}%"></div>
              </div>
            </div></td>
        </tr>
        @endif
      </table>
      @if($single_data->sale_status == '1')
      <div class="ajax-sold-out"><img src="{{asset("public/common/sold_out.png")}}" /></div>
      @endif </div>
  </div>
</div>
<div class="row ajax-page-pt15">
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <p class="text-center ajax-statistics-heading"> {{__('cow_monitor.animal') }} <span class="validate">{{__('cow_monitor.health') }} (%)</span> {{__('cow_monitor.chart_jan_to_dec') }}, {{date('Y', strtotime(date('m/d/Y')))}}</p>
            <div class="chart">
              <div class="wrapper">
                <canvas id="chart-0"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <p class="text-center ajax-statistics-heading"> {{__('cow_monitor.animal') }} <span class="validate">{{__('cow_monitor.weight_kg') }}</span> {{__('cow_monitor.chart_jan_to_dec') }}, {{date('Y', strtotime(date('m/d/Y')))}}</p>
            <div class="chart">
              <div class="wrapper">
                <canvas id="chart-1"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row ajax-page-pt15">
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <p class="text-center ajax-statistics-heading"> {{__('cow_monitor.animal') }} <span class="validate">{{__('cow_monitor.height_inch') }}</span> {{__('cow_monitor.chart_jan_to_dec') }}, {{date('Y', strtotime(date('m/d/Y')))}}</p>
            <div class="chart">
              <div class="wrapper">
                <canvas id="chart-2"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <p class="text-center ajax-statistics-heading"> {{__('cow_monitor.animal') }} <span class="validate">{{__('cow_monitor.milk_litre') }}</span> {{__('cow_monitor.chart_jan_to_dec') }}, {{date('Y', strtotime(date('m/d/Y')))}}</p>
            <div class="chart">
              <div class="wrapper">
                <canvas id="chart-3"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@if(isset($feed_chart_details))
<div class="row">
  <div class="col-md-12 ajax-page-bb" align="center">
    <h3><b>{{__('cow_monitor.daily_feed_list') }}</b></h3>
  </div>
</div>
<div class="row ajax-page-pt15">
  <div class="col-md-12">
    <table class="table table-bordered table-striped table-responsive">
      <thead>
        <tr>
          <th>{{__('cow_monitor.item_name') }}</th>
          <th>{{__('cow_monitor.item_quantity') }}</th>
          <th>{{__('cow_monitor.feeding_time') }}</th>
        </tr>
      </thead>
      <tbody>
      
      @foreach($feed_chart_details as $dtlsArrData)
      <tr>
        <td>{{$dtlsArrData->item_name}}</td>
        <td>{{$dtlsArrData->qty}} {{$dtlsArrData->unit_name}}</td>
        <td>{{$dtlsArrData->time}}</td>
      </tr>
      @endforeach
      </tbody>
      
    </table>
  </div>
</div>
@endif


@if(!empty($pregnancy_records))
<div class="row">
  <div class="col-md-12 ajax-page-bb" align="center">
    <h3><b>{{__('cow_monitor.pregnancy_records_list') }}</b></h3>
  </div>
</div>
<div class="row ajax-page-pt15">
  <div class="col-md-12">
    <table class="table table-bordered table-striped table-responsive">
      <thead>
        <tr>
          <th>{{__('cow_monitor.pregnancy_type') }}</th>
          <th>{{__('cow_monitor.semen_type') }}</th>
          <th>{{__('cow_monitor.semen_push_date') }}</th>
          <th>{{__('cow_monitor.pregnancy_start_date') }}</th>
          <th>{{__('cow_monitor.pregnancy_status') }}</th>
          <th>{{__('same.action') }}</th>
        </tr>
      </thead>
      <tbody>
      
      @foreach($pregnancy_records as $record)
      <tr>
        <td>{{$record->type_name}}</td>
        <td>{{$record->aTypeName}}</td>
        <td>{{ !empty($record->semen_push_date) ? Carbon\Carbon::parse($record->semen_push_date)->format('M d, Y') : ''}}</td>
        <td>{{!empty($record->pregnancy_start_date) ? Carbon\Carbon::parse($record->pregnancy_start_date)->format('M d, Y') : ''}}</td>
        <td>@if($record->status=='1')
          <label class="label label-warning lblfarm">{{__('cow_monitor.processing') }}</label>
          @elseif($record->status=='2')
          <label class="label label-success lblfarm">{{__('cow_monitor.delivered') }}</label>
          @else
          <label class="label label-danger lblfarm">{{__('cow_monitor.failed') }}</label>
          @endif</td>
        <td><!-- Modal Start -->
          <div class="modal fade" id="view{{$record->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><i class="icon-layers edit-color"></i> {{__('cow_monitor.pregnancy_details') }}</h4>
                </div>
                <div class="modal-body">
                  <table class="table table-bordered table-striped table-responsive">
                    <tr>
                      <td>{{__('cow_monitor.semen_cost') }} : </td>
                      <td>{{App\Library\farm::currency($record->semen_cost)}}</td>
                    </tr>
                    <tr>
                      <td>{{__('cow_monitor.other_cost') }} : </td>
                      <td>{{App\Library\farm::currency($record->other_cost)}}</td>
                    </tr>
                    <tr>
                      <td>{{__('cow_monitor.note') }} : </td>
                      <td>{{$record->note}}</td>
                    </tr>
                    <tr>
                      <td>{{__('cow_monitor.appox_delivery_date') }} : </td>
                      <td><b>
                        <?php
														$diff_value = 0;
														$str = App\Library\farm::appoxDeliveryDate($record->pregnancy_start_date);
														if(!empty($str['edd'])){
															echo Carbon\Carbon::parse($str['edd'])->format('M d, Y');
														}
														if(!empty($str['days'])){
															$diff_value = (float)((float)$str['days'] / 383) * 100;
															$diff_value = number_format($diff_value, 2);
														}
													?>
                        </b> </td>
                    </tr>
                    <tr>
                      <td>{{__('cow_monitor.pregnancy_progress') }} : </td>
                      <td><div class="progress-group"> <span class="progress-text">{{__('cow_monitor.delivery_progress') }}</span> <span class="progress-number"><b><?php echo !empty($str['days']) && $str['days'] > 0 ? $str['days'] : 0; ?> </b>/283</span>
                          <div class="progress sm">
                            <div id="appox-delivery-days" class="progress-bar progress-bar-green" style="width:<?php echo $diff_value; ?>%"></div>
                          </div>
                        </div></td>
                    </tr>
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
            <div class = "input-group"> <a href="#view{{$record->id}}" class="btn btn-primary btn-xs" data-toggle="modal" title="View Details"><i class="icon-eye"></i></a> </div>
          </div></td>
      </tr>
      @endforeach
      </tbody>
      
    </table>
  </div>
</div>
@endif

@if(!empty($calf_list))
<div class="row">
  <div class="col-md-12 ajax-page-bb" align="center">
    <h3><b>{{__('cow_monitor.calf_record_list') }}</b></h3>
  </div>
</div>
<div class="row ajax-page-pt15">
  <div class="col-md-12">
    <table class="table table-bordered table-striped table-responsive">
      <thead>
        <tr>
          <th>{{__('cow_monitor.stall_no') }}</th>
          <th>{{__('cow_monitor.animal_type') }}</th>
          <th>{{__('cow_monitor.gender') }}</th>
          <th>{{__('cow_monitor.date_of_birth') }}</th>
		  <th>{{__('cow_monitor.current_age') }}</th>
		  <th>{{__('cow_monitor.weight_kg') }}</th>
		  <th>{{__('cow_monitor.height_inch') }}</th>
          <th>{{__('cow_monitor.status') }}</th>
          <th>{{__('same.action') }}</th>
        </tr>
      </thead>
      <tbody>
      
      @foreach($calf_list as $calfRecord)
      <?php
	  	//here we finding last update infomation
		$calf_score = DB::table('cow_monitor')->Where('cow_id',$calfRecord->id)->first();
	  ?>
	  <tr>
        <td>{{$calfRecord->shed_number}}</td>
        <td>{{$calfRecord->type_name}}</td>
        <td>{{$calfRecord->gender}}</td>
        <td>{{Carbon\Carbon::parse($calfRecord->DOB)->format('M d, Y')}}</td>
		<td>{{(!empty($calfRecord->DOB)) ? \App\Library\farm::animalAgeFormat($calfRecord->DOB) : ''}}</td>
		<td>{{isset($calf_score->weight) ? $calf_score->weight : $calfRecord->weight}}</td>
		<td>{{isset($calf_score->height) ? $calf_score->height : $calfRecord->height}}</td>
        <td> @if($calfRecord->sale_status == '0')
          <label class="label label-success lblfarm">{{__('cow_monitor.available') }}</label>
          @else
          <label class="label label-danger lblfarm">{{__('cow_monitor.sold_out') }}</label>
          @endif </td>
        <td><a href="#calf_view_{{$calfRecord->id}}" class="btn btn-default btn-xs" data-toggle="modal" title="View Details"><i class="fa fa-bar-chart"></i></a>
          <!-- Modal Start -->
          <div class="modal fade" id="calf_view_{{$calfRecord->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><i class="fa fa-info-circle edit-color"></i> {{__('cow_monitor.calf_details') }}</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12 calf-image">
                      
					  @if(isset($calf_score->new_images) && !empty($calf_score->new_images))
					  	<div class="owl-carousel cm-slider">
							@foreach(explode('_', $calf_score->new_images) as $picture)
								<div class="img-thumbnail"><img src="{{asset('storage/app/public/uploads/animal/'.$picture)}}" /></div>
							@endforeach </div>
                      	</div>
					  @else
					  	<div class="owl-carousel cm-slider">
							@foreach(explode('_', $calfRecord->pictures) as $picture)
								<div class="img-thumbnail"><img src="{{asset('storage/app/public/uploads/animal/'.$picture)}}" /></div>
							@endforeach </div>
                      	</div>
					  @endif
                  </div>
                  
				  
				  <?php if(isset($calf_score->health_score)) { ?>
				  <div class="row ajax-page-pt15">
				  
				  	<div class="col-md-12">
						<?php
							$color = '';
							$message = '';
							$hc = $calf_score->health_score;
							if((int)$hc >= 80){
								$color = 'green';
								$message = __('cow_monitor.good_condition');
							} else if((int)$hc < 80 && (int)$hc > 50){
								$color = 'yellow';
								$message = __('cow_monitor.warning_condition');
							} else if((int)$hc <= 50){
								$color = 'red';
								$message = __('cow_monitor.danger_condition');
							}
						?>
						<div class="progress-group"> <span class="progress-text"><?php echo $message; ?></span> <span class="progress-number"><b>{{$calf_score->health_score}} </b>/100</span>
						  <div class="progress sm">
							<div class="progress-bar progress-bar-<?php echo $color; ?>" style="width: {{$calf_score->health_score}}%"></div>
						  </div>
						</div>
					  
					  </div>
				  </div>
				   <?php } ?>
				  <?php
							
							$calf_feed_chart_details = array();
							if(!empty($calfRecord->shade_no)){
								$calf_feed_chart = DB::table('cow_feed')->where('branch_id', Session::get('branch_id'))->where('cow_id', $calfRecord->id)->first();
								if(!empty($calf_feed_chart->id)){
									$calf_feed_chart_details = DB::table('cow_feed_dtls')
															->leftJoin('food_items', 'food_items.id', 'cow_feed_dtls.item_id')
															->leftJoin('food_units', 'food_units.id', 'cow_feed_dtls.unit_id')
															->where('feed_id', $calf_feed_chart->id)
															->select('food_items.name as item_name', 'food_units.name as unit_name', 'cow_feed_dtls.qty', 'cow_feed_dtls.time')
															->get();
									
									
								}
							}
							
							
							?>
                  @if(isset($calf_feed_chart_details))
                  <div class="row">
                    <div class="col-md-12 ajax-page-bb" align="center">
                      <h3><b>{{__('cow_monitor.daily_feed_list') }}</b></h3>
                    </div>
                  </div>
                  <div class="row ajax-page-pt15">
                    <div class="col-md-12">
                      <table class="table table-bordered table-striped table-responsive">
                        <thead>
                          	<tr>
                            	<th>{{__('cow_monitor.item_name') }}</th>
								<th>{{__('cow_monitor.item_quantity') }}</th>
								<th>{{__('cow_monitor.feeding_time') }}</th>
                          	</tr>
                        </thead>
                        <tbody>
                        
                        @foreach($calf_feed_chart_details as $dtlsArrData)
                        <tr>
                          <td>{{$dtlsArrData->item_name}}</td>
                          <td>{{$dtlsArrData->qty}} {{$dtlsArrData->unit_name}}</td>
                          <td>{{$dtlsArrData->time}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                        
                      </table>
                    </div>
                  </div>
                  @endif </div>
                <div class="modal-footer"></div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
        </td>
      </tr>
      @endforeach
      </tbody>
      
    </table>
  </div>
</div>
<input type="hidden" id="chart_data_0" value="<?php echo json_encode($chart_data[0]); ?>" />
<input type="hidden" id="chart_data_1" value="<?php echo json_encode($chart_data[1]); ?>" />
<input type="hidden" id="chart_data_2" value="<?php echo json_encode($chart_data[2]); ?>" />
<input type="hidden" id="chart_data_3" value="<?php echo json_encode($chart_data[3]); ?>" />
{!!Html::script('public/custom/js/asr.js')!!}
@endif



