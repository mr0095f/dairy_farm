@extends('layouts.layout')
@section('title', __('cow_monitor.title'))
@section('content')
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('cow_monitor.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('cow_monitor.title') }}</li>
  </ol>
</section>
<section class="content"> @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="{{  url('cow-monitor/create')  }}" class="btn btn-success btn-sm" data-toggle="modal"> <i class="fa fa-plus-square"></i> <b>{{__('same.add_new') }}</b> </a> <a href="{{URL::to('cow-monitor')}}" class="btn btn-warning btn-sm"> <i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b> </a> </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-responsive">
                <thead>
                  <tr>
                    <th>{{__('cow_monitor.date') }}</th>
                    <th>{{__('cow_monitor.stall_no') }}</th>
                    <th>{{__('cow_monitor.cow_no') }}</th>
                    <th>{{__('cow_monitor.note') }}</th>
                    <th>{{__('cow_monitor.health_status') }}</th>
                    <th>{{__('cow_monitor.reported_by') }}</th>
                    <th>{{__('same.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                
                @foreach($alldata as $data)
                <tr>
                  <td>{{date('M d, Y', strtotime($data->date))}}</td>
                  <td>{{$data->shed_number}}</td>
                  <td>000{{$data->cow_id}}</td>
                  <td>{{$data->note}}</td>
                  <td><?php
						$color = '';
						$message = '';
						$hc = $data->health_score;
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
                    <div class="progress-group"> <span class="progress-text"><?php echo $message; ?></span> <span class="progress-number"><b>{{$data->health_score}} </b>/100</span>
                      <div class="progress sm">
                        <div class="progress-bar progress-bar-<?php echo $color; ?>" style="width: {{$data->health_score}}%"></div>
                      </div>
                    </div></td>
                  <td>{{$data->name}} <b>({{$data->user_type}})</b></td>
                  <td><!-- Modal Start -->
                    <div class="modal fade" id="view{{$data->id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa fa-info-circle edit-color"></i> {{__('cow_monitor.services_details') }}</h4>
                          </div>
                          <div class="modal-body">
                            <table class="table table-bordered table-striped table-responsive">
                              	<th>{{__('cow_monitor.service_name') }}</th>
                                <th>{{__('cow_monitor.result') }}</th>
                                <th>{{__('cow_monitor.checkup_time') }}</th>
                              <tbody>
                                <?php  
                                    $dtlsArr = DB::table('cow_monitor_dtls')
                                            ->leftJoin('monitoring_services', 'monitoring_services.id', 'cow_monitor_dtls.service_id')
                                            ->where('cow_monitor_dtls.monitor_id', $data->id)
                                            ->select('monitoring_services.service_name', 'cow_monitor_dtls.*')
                                            ->get();
                                  ?>
                              @foreach($dtlsArr as $dtlsArrData)
                              <tr>
                                <td>{{$dtlsArrData->service_name}}</td>
                                <td>{{$dtlsArrData->result}}</td>
                                <td>{{$dtlsArrData->time}}</td>
                              </tr>
                              @endforeach
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
                      <div class = "input-group"> <a href="#view{{$data->id}}" data-toggle="modal" class="btn btn-primary btn-xs" title="{{__('same.view') }}"><i class="icon-eye"></i></a> </div>
                      <div class = "input-group"> <a href="{{ route('cow-monitor.edit', $data->id) }}" class="btn btn-success btn-xs" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                      <div class = "input-group"> {{Form::open(array('route'=>['cow-monitor.destroy',$data->id],'method'=>'DELETE'))}}
                        <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                        {!! Form::close() !!} </div>
                    </div></td>
                </tr>
                @endforeach
                </tbody>
                
              </table>
              <div class="col-md-12" align="center"> {{$alldata->render()}} </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer"> </div>
  </div>
</section>
@endsection 