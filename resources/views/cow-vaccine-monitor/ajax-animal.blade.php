<div class="row">
  <div class="col-md-12 ajax-page-bb" align="center">
    <h3>{{__('cow_monitor.cow_details') }}</h3>
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
@if(!empty($vaccine_pending))
<div class="row">
  <div class="col-md-12 ajax-page-bb" align="center">
    <h3 class="due-amount">{{__('cow_monitor.five_pending_vaccine') }}</h3>
  </div>
</div>
<div class="row ajax-page-pt15">
  <div class="col-md-12">
    <div class="col-md-12">
      <div>
        <table class="table table-bordered table-striped table-responsive">
          <thead>
            <tr>
              <th>{{__('cow_monitor.vaccine_name') }}</th>
              <th>{{__('cow_monitor.time_days') }}</th>
              <th class="th-center">{{__('cow_monitor.repeat') }}</th>
              <th>{{__('cow_monitor.dose') }}</th>
              <th>{{__('cow_monitor.note') }}</th>
            </tr>
          </thead>
          <tbody>
          
          @foreach($vaccine_pending as $pvl)
          <tr>
            <td>{{$pvl->vaccine_name}}</td>
            <td>{{$pvl->months}}</td>
            <td align="center">@if((bool)$pvl->repeat_vaccine)<i class="fa fa-check"></i>@else<i class="fa fa-close"></i>@endif</td>
            <td>{{$pvl->dose }}</td>
            <td>{{$pvl->note }}</td>
          </tr>
          @endforeach
          </tbody>
          
        </table>
      </div>
    </div>
  </div>
</div>
@endif



@if(!empty($vaccines))
<div class="row">
  <div class="col-md-12 ajax-page-bb" align="center">
    <h3 class="color-monitor-text">{{__('cow_vaccine_monitor.vaccine_done_list') }}</h3>
  </div>
</div>
<div class="row  ajax-page-pt15">
  <div class="col-md-12">
    <div class="col-md-12"> @foreach($vaccines as $key => $vaccine)
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="form-group" align="center"><b><u>{{__('cow_vaccine_monitor.vaccine_date') }} : {{Carbon\Carbon::parse($key)->format('m/d/Y')}}</u></b></div>
          @if(!empty($vaccine['list']))
          <div>
            <table class="table table-bordered table-striped table-responsive">
              <thead>
                <tr>
                  <th>{{__('cow_vaccine_monitor.vaccine_name') }}</th>
                  <th>{{__('cow_vaccine_monitor.remarks') }}</th>
                  <th>{{__('cow_vaccine_monitor.given_time') }}</th>
                </tr>
              </thead>
              @foreach($vaccine['list'] as $list)
              <tr>
                <td>{{$list->vaccine_name}}</td>
                <td>{{$list->remarks}}</td>
                <td>{{$list->time}}</td>
              </tr>
              @endforeach
            </table>
          </div>
          @endif
          <div class="col-md-12" align="right"><b>{{__('cow_monitor.reported_by') }} {{$vaccine['name']}}</b> ({{$vaccine['user_type']}})</div>
        </div>
      </div>
      @endforeach </div>
  </div>
</div>
@endif
