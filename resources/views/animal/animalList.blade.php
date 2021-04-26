@extends('layouts.layout')
@section('title', __('manage_cow.title'))
@section('content')
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('manage_cow.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active">{{__('manage_cow.title') }}</li>
  </ol>
</section>
<section class="content"> @include('common.message')
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="{{  url('animal/create')  }}" class="btn btn-success btn-sm" data-toggle="modal"> <i class="fa fa-plus-square"></i> <b>{{__('same.add_new') }}</b> </a> <a href="{{URL::to('animal')}}" class="btn btn-warning btn-sm"> <i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b> </a> </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-responsive">
                <thead>
                  <tr>
                    <th>{{__('manage_cow.id') }}</th>
                    <th>{{__('manage_cow.image') }}</th>
                    <th>{{__('manage_cow.gender') }}</th>
                    <th>{{__('manage_cow.animal_type') }}</th>
                    <th>{{__('manage_cow.buy_date') }}</th>
                    <th>{{__('manage_cow.buying_price') }}</th>
                    <th>{{__('manage_cow.pregnant_status') }}</th>
                    <th>{{__('manage_cow.milk_per_day') }}</th>
                    <th>{{__('manage_cow.animal_status') }}</th>
                    <th>{{__('same.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                
                @foreach($all_animals as $animals)
                <tr>
                  <td><label class="label label-default lblfarm">000{{$animals->id}}</label></td>
                  <td> @if($animals->pictures !='')
                    @if(file_exists('storage/app/public/uploads/animal/'.explode('_', $animals->pictures)[0])) <img src='{{asset("storage/app/public/uploads/animal")}}/{{explode("_", $animals->pictures)[0]}}' class="img-thumbnail" width="50px"> @else <img src='{{asset("public/custom/img/noImage.jpg")}}' class="img-circle" width="60px"> @endif
                    @else <img src='{{asset("public/custom/img/noImage.jpg")}}' class="img-circle" width="60px"> @endif
                    <!-- Modal Start -->
                    <div class="modal fade" id="view{{$animals->id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa fa-info-circle edit-color"></i> {{__('manage_cow.animal_details') }}</h4>
                          </div>
                          <div class="modal-body">
                            <table class="table table-bordered table-striped table-responsive">
                              <tbody>
                                <tr>
                                  <td>{{__('manage_cow.stall_no') }}</td>
                                  <td> @if(isset($animals->animal_shed_object->shed_number))
                                    {{$animals->animal_shed_object->shed_number}}
                                    @endif </td>
                                </tr>
                                <tr>
                                  <td>{{__('manage_cow.dob') }}</td>
                                  <td>{{ Carbon\Carbon::parse($animals->DOB)->format('m/d/Y') }}</td>
                                </tr>
                                <tr>
                                  <td>{{__('manage_cow.age') }}</td>
                                  <td>{{$animals->age}} {{__('manage_cow.days_or') }} <?php echo number_format((float)$animals->age / 30,2,".","."); ?> {{__('manage_cow.month') }}</td>
                                </tr>
                                <tr>
                                  <td>{{__('manage_cow.weight') }}</td>
                                  <td>{{$animals->weight}} KG</td>
                                </tr>
                                <tr>
                                  <td>{{__('manage_cow.height') }}</td>
                                  <td>{{$animals->height}} Inch</td>
                                </tr>
                                <tr>
                                  <td>{{__('manage_cow.color') }}</td>
                                  <td> @if(isset($animals->animal_color_object->color_name))
                                    {{$animals->animal_color_object->color_name}}
                                    @endif </td>
                                </tr>
                                <tr>
                                  <td>{{__('manage_cow.nop') }}</td>
                                  <td>{{$animals->before_no_of_pregnant}}</td>
                                </tr>
                                <tr>
                                  <td>{{__('manage_cow.pregnancy_time') }}</td>
                                  <td> @if(!empty($animals->pregnancy_time))
                                    {{date('M d, Y', strtotime($animals->pregnancy_time))}}
                                    @endif </td>
                                </tr>
                                <tr>
                                  <td>{{__('manage_cow.buy_form') }}</td>
                                  <td>{{$animals->buy_from}}</td>
                                </tr>
                                <tr>
                                  <td>{{__('manage_cow.previous_vaccine_done') }}</td>
                                  <td>{{$animals->previous_vaccine_done}}</td>
                                </tr>
                                <tr>
                                  <td>{{__('manage_cow.note') }}</td>
                                  <td>{{$animals->note}}</td>
                                </tr>
                                <tr>
                                  <td>{{__('manage_cow.created_by') }}</td>
                                  <td>{{  $animals->name  }} <b>({{  $animals->user_type  }})</b></td>
                                </tr>
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
                  </td>
                  <td>{{$animals->gender}}</td>
                  <td> @if(isset($animals->animal_animalType_object->type_name))
                    <label class="label label-default lblfarm">{{$animals->animal_animalType_object->type_name}}</label>
                    @endif </td>
                  <td> @if(!empty($animals->buy_date))
                    {{date('M d, Y', strtotime($animals->buy_date))}}
                    @endif </td>
                  <td>{{App\Library\farm::currency($animals->buying_price)}}</td>
                  <td> @if($animals->pregnant_status==0)
                    <label class="label label-warning lblfarm">{{__('manage_cow.not_pregnant') }}</label>
                    @else
                    <label class="label label-success lblfarm">{{__('manage_cow.pregnant') }}</label>
                    @endif </td>
                  <td>{{$animals->milk_ltr_per_day}}</td>
                  <td> @if((bool)$animals->sale_status)
                    <label class="label label-warning lblfarm">{{__('manage_cow.sold') }}</label>
                    @else
                    <label class="label label-success lblfarm">{{__('manage_cow.available') }}</label>
                    @endif </td>
                  <td><div class="form-inline">
                      <div class = "input-group"> <a href="#view{{$animals->id}}" class="btn btn-primary btn-xs" data-toggle="modal" title="{{__('same.view') }}"><i class="icon-eye"></i></a> </div>
                      <div class = "input-group"> <a href="{{ route('animal.edit', $animals->id) }}" class="btn btn-success btn-xs" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                      <div class = "input-group"> {{Form::open(array('route'=>['animal.destroy',$animals->id],'method'=>'DELETE'))}}
                        <button type="submit" confirm="{{__('same.delete_confirm') }}" class="btn btn-danger btn-xs confirm" title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                        {!! Form::close() !!} </div>
                    </div></td>
                </tr>
                @endforeach
                </tbody>
              </table>
              <div class="col-md-12" align="center"> {{$all_animals->render()}} </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer"> </div>
  </div>
</section>
@endsection 