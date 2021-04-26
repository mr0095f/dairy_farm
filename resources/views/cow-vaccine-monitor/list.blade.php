@extends('layouts.layout')
@section('title', __('cow_vaccine_monitor.title'))
@section('content')
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('cow_vaccine_monitor.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('cow_vaccine_monitor.title') }}</li>
  </ol>
</section>
<section class="content"> @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="{{  url('vaccine-monitor/create')  }}" class="btn btn-success btn-sm"> <i class="fa fa-plus-square"></i> <b>{{__('same.add_new') }}</b> </a> <a href="{{URL::to('vaccine-monitor')}}" class="btn btn-warning btn-sm"> <i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b> </a> </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-responsive">
                <thead>
                  <tr>
                    <th>{{__('cow_vaccine_monitor.date') }}</th>
                    <th>{{__('cow_vaccine_monitor.stall_no') }}</th>
                    <th>{{__('cow_vaccine_monitor.cow_no') }}</th>
                    <th>{{__('cow_vaccine_monitor.note') }}</th>
                    <th>{{__('cow_vaccine_monitor.reported_by') }}</th>
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
                  <td>{{$data->name}} <b>({{$data->user_type}})</b></td>
                  <td><!-- Modal Start -->
                    <div class="modal fade" id="view{{$data->id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa fa-info-circle edit-color"></i> Vaccine Details</h4>
                          </div>
                          <div class="modal-body">
                            <table class="table table-bordered table-striped table-responsive">
                              <th>{{__('cow_vaccine_monitor.vaccine_name') }}</th>
                                <th>{{__('cow_vaccine_monitor.remarks') }}</th>
                                <th>{{__('cow_vaccine_monitor.given_time') }}</th>
                              <tbody>
                                <?php  
                                    $dtlsArr = DB::table('cow_vaccine_monitor_dtls')
                                            ->leftJoin('vaccines', 'vaccines.id','cow_vaccine_monitor_dtls.vaccine_id')
                                            ->where('cow_vaccine_monitor_dtls.monitor_id', $data->id)
                                            ->select('vaccines.vaccine_name', 'vaccines.months', 'cow_vaccine_monitor_dtls.*')
                                            ->get();
                                  ?>
                              @foreach($dtlsArr as $dtlsArrData)
                              <tr>
                                <td>{{$dtlsArrData->vaccine_name}} - ( {{$dtlsArrData->months}} {{__('cow_vaccine_monitor.months') }} )</td>
                                <td>{{$dtlsArrData->remarks}}</td>
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
                      <div class = "input-group"> <a href="{{ route('vaccine-monitor.edit', $data->id) }}" class="btn btn-success btn-xs" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                      <div class = "input-group"> {{Form::open(array('route'=>['vaccine-monitor.destroy',$data->id],'method'=>'DELETE'))}}
                        <button type="submit" confirm="Are you sure you want to delete this information ?" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
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