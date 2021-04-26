<div class="row">
  <div class="col-md-12 ajax-page-bb" align="center">
    <h3><b>{{__('cow_monitor.cow_details') }}</b></h3>
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
    <div class="col-md-6 border">
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
    </div>
  </div>
</div>
@if(!empty($pregnancy_records))
<div class="row">
  <div class="col-md-12 ajax-page-bb" align="center">
    <h3><b>{{__('animal_pregnancy.pregnancy_records_list') }}</b></h3>
  </div>
</div>
<div class="row ajax-page-pt15">
  <div class="col-md-12">
    <table class="table table-bordered table-striped table-responsive">
      <thead>
        <tr>
          <th>{{__('animal_pregnancy.stall_no') }}</th>
          <th>{{__('animal_pregnancy.pregnancy_type') }}</th>
          <th>{{__('animal_pregnancy.semen_type') }}</th>
          <th>{{__('animal_pregnancy.semen_push_date') }}</th>
          <th>{{__('animal_pregnancy.pregnancy_start_date') }}</th>
          <th>{{__('animal_pregnancy.pregnancy_status') }}</th>
          <th>{{__('same.action') }}</th>
        </tr>
      </thead>
      <tbody>
      
      @foreach($pregnancy_records as $record)
      <tr>
        <td>{{$record->shed_number}}</td>
        <td>{{$record->type_name}}</td>
        <td>{{$record->aTypeName}}</td>
        <td>{{ !empty($record->semen_push_date) ? Carbon\Carbon::parse($record->semen_push_date)->format('M d, Y') : ''}}</td>
        <td>{{!empty($record->pregnancy_start_date) ? Carbon\Carbon::parse($record->pregnancy_start_date)->format('M d, Y') : ''}}</td>
        <td>@if($record->status=='1')
          <label class="label label-warning lblfarm">{{__('animal_pregnancy.ps_processing') }}</label>
          @elseif($record->status=='2')
          <label class="label label-success lblfarm">{{__('animal_pregnancy.ps_delivered') }}</label>
          @else
          <label class="label label-danger lblfarm">{{__('animal_pregnancy.ps_failed') }}</label>
          @endif</td>
        <td><!-- Modal Start -->
          <div class="modal fade" id="view{{$record->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><i class="icon-layers edit-color"></i> {{__('animal_pregnancy.pregnancy_details') }}</h4>
                </div>
                <div class="modal-body">
                  <table class="table table-bordered table-striped table-responsive">
                    <tr>
                      <td>{{__('animal_pregnancy.semen_cost') }} : </td>
                      <td>{{App\Library\farm::currency($record->semen_cost)}}</td>
                    </tr>
                    <tr>
                      <td>{{__('animal_pregnancy.other_cost') }} : </td>
                      <td>{{App\Library\farm::currency($record->other_cost)}}</td>
                    </tr>
                    <tr>
                      <td>{{__('animal_pregnancy.note') }} : </td>
                      <td>{{$record->note}}</td>
                    </tr>
                    <tr>
                      <td>{{__('animal_pregnancy.axdd') }} : </td>
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
                      <td>{{__('animal_pregnancy.pregnancy_progress') }} : </td>
                      <td><div class="progress-group"> <span class="progress-text">{{__('animal_pregnancy.delivery_progress') }}</span> <span class="progress-number"><b><?php echo !empty($str['days']) && $str['days'] > 0 ? $str['days'] : 0; ?> </b>/283</span>
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
		  
		   {!! Form::open(array('route' =>['animal-pregnancy.update', $record->id],'class'=>'form-horizontal','method'=>'PUT')) !!}
          <!-- Modal update Start -->
          <div class="modal fade" id="edit{{$record->id}}" tabindex="-1" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><i class="icon-note edit-color"></i> {{__('animal_pregnancy.edit_pregnancy_details') }}</h4>
                </div>
                <div class="modal-body">
                  <table class="table table-bordered table-striped table-responsive">
                    <tr>
                      <td><label for="pregnancy_type_id">{{__('animal_pregnancy.pregnancy_type') }} <span class="validate">*</span> :</td>
                      <td><select class="form-control" name="pregnancy_type_id" id="pregnancy_type_id" required>
                          <option value="">{{__('same.select') }}</option>
							@foreach($pregnancy_types as $pregnancy_type)
                          		<option @if($record->pregnancy_type_id==$pregnancy_type->id) selected @endif value="{{$pregnancy_type->id}}">{{$pregnancy_type->type_name}}</option>
							@endforeach
                        </select></td>
                    </tr>
                    <tr>
                      <td><label for="semen_type">{{__('animal_pregnancy.semen_type') }} :</label> </td>
                      <td><select class="form-control" name="semen_type" id="semen_type">
                      				<option value="0">{{__('same.select') }}</option>
								@foreach($animal_types as $animal_type)
                      				<option @if($record->semen_type==$animal_type->id) selected @endif value="{{$animal_type->id}}">{{$animal_type->type_name}}</option>
							    @endforeach
                    		</select></td>
                    </tr>
                    <tr>
                      <td><label for="semen_push_date">{{__('animal_pregnancy.semen_push_date') }} :</label> </td>
                      <td><input type="text" name="semen_push_date" id="semen_push_date" value="{{!empty($record->semen_push_date) ? Carbon\Carbon::parse($record->semen_push_date)->format('m/d/Y') : ''}}" placeholder="mm/dd/YYYY" class="form-control wsit_datepicker"></td>
                    </tr>
                    <tr>
                      <td><label for="semen_push_date">{{__('animal_pregnancy.pregnancy_start_date') }}</label> <span class="validate">*</span> : </td>
                      <td><input type="text" name="pregnancy_start_date" placeholder="mm/dd/YYYY" class="form-control wsit_datepicker" value="{{!empty($record->pregnancy_start_date) ? Carbon\Carbon::parse($record->pregnancy_start_date)->format('m/d/Y') : ''}}"></td>
                    </tr>
					<tr>
                      <td><label for="semen_cost">{{__('animal_pregnancy.semen_cost') }} : </label> </td>
                      <td><input type="text" name="semen_cost" class="form-control" value="{{!empty($record->semen_cost) ? $record->semen_cost : ''}}"></td>
                    </tr>
					<tr>
                      <td><label for="other_cost">{{__('animal_pregnancy.other_cost') }} :</label> </td>
                      <td><input type="text" name="other_cost" id="other_cost" class="form-control" value="{{!empty($record->other_cost) ? $record->other_cost : ''}}"></td>
                    </tr>
					<tr>
                      <td><label for="note">{{__('animal_pregnancy.note') }} :</label> </td>
                      <td><textarea class="form-control" id="note" name="note">{{!empty($record->note) ? $record->note : ''}}</textarea></td>
                    </tr>
					<tr>
                      <td><label for="status">{{__('animal_pregnancy.pregnancy_status') }} :</label> </td>
                      <td><select class="form-control" name="status" id="status" required>
                          <option value="1" @if($record->status==1) selected @endif>{{__('animal_pregnancy.ps_processing') }}</option>
						  <option value="2" @if($record->status==2) selected @endif>{{__('animal_pregnancy.ps_delivered') }}</option>
						  <option value="3" @if($record->status==3) selected @endif>{{__('animal_pregnancy.ps_failed') }}</option>
							
                        </select></td>
                    </tr>
                  </table>
                </div>
                <div class="modal-footer">
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-floppy-o"></i> <b>Update</b></button>
				</div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
		  {!! Form::close() !!}
		  
          <div class="form-inline">
            <div class = "input-group"> <a href="#view{{$record->id}}" class="btn btn-primary btn-xs" data-toggle="modal" title="{{__('same.view') }}"><i class="icon-eye"></i></a> </div>
            <div class = "input-group"> <a href="#edit{{$record->id}}" class="btn btn-success btn-xs" data-toggle="modal" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
            <div class = "input-group"> {{Form::open(array('route'=>['animal-pregnancy.destroy',$record->id],'method'=>'DELETE'))}}
              <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm-ap" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
              {!! Form::close() !!} </div>
          </div></td>
      </tr>
      @endforeach
      </tbody>
      
    </table>
  </div>
</div>
@endif
<input type="hidden" id="pregnant_progress" value="{{$pregnant_current_status}}">
