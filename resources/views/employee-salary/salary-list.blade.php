@extends('layouts.layout')
@section('title', __('salarylist.title'))
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><i class="icon-list"></i> {{__('salarylist.title') }}</h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::to('dashboard')}}"><i class="fa fa-dashboard"></i> {{__('same.home') }}</a></li>
    <li class="active"><a href="{{URL::to('employee-salary')}}">{{__('salarylist.title') }}</a></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Default box -->
  @include('common.message')
  @include('common.commonFunction')
  <?php $getMonthFromArr = months();?>
  <div class="box box-success">
    <div class="box-header with-border" align="right"> <a href="{{url('employee-salary/create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> <b>{{__('salarylist.add_new') }}</b></a> <a href="{{ url('employee-salary') }}" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> <b>{{__('same.refresh') }}</b></a> </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-responsive">
          <th>{{__('salarylist.sl') }}</th>
            <th>{{__('salarylist.image') }}</th>
            <th>{{__('salarylist.employee_name') }}</th>
            <th>{{__('salarylist.pay_date') }}</th>
            <th>{{__('salarylist.month') }}</th>
            <th>{{__('salarylist.year') }}</th>
            <th>{{__('salarylist.salary_amount') }}</th>
            <th>{{__('salarylist.addition_amount') }}</th>
            <th>{{__('salarylist.total') }}</th>
            <th>{{__('same.action') }}</th>
            <?php                           
                $number = 1;
                $numElementsPerPage = 10; // How many elements per page
                $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
              ?>
          <tbody id="mainList">
          
          @if(!empty($salaryList))
          @foreach($salaryList as $data)
          <tr>
            <td><label class="label label-success">{{$currentNumber++}}</label></td>
            <td> @if($data->image)
              <?php $img = "storage/app/public/uploads/human-resource/".$data->image; ?>
              @if(file_exists($img)) <img src='{{asset($img)}}' class="img-thumbnail list_img_box"> @else <img src='{{asset("public/custom/img/photo.png")}}' class="img-thumbnail list_img_box"> @endif
              @else <img src='{{asset("public/custom/img/photo.png")}}' class="img-thumbnail list_img_box"> @endif </td>
            <td>{{ $data->employee_name }}</td>
            <td>{{ date('m/d/Y', strtotime($data->paydate)) }}</td>
            <td>{{$getMonthFromArr[$data->month]}}</td>
            <td>{{$data->year}}</td>
            <td class="amounts">{{ App\Library\farm::currency($data->salary)}}</td>
            <td class="amounts">{{ App\Library\farm::currency($data->addition_money)}}</td>
            <td class="amounts">{{ App\Library\farm::currency($data->salary+$data->addition_money)}}</td>
            <td><div class="form-inline">
                <div class="input-group"> <a href="{{ route('employee-salary.edit', $data->id) }}" class="btn btn-success btn-xs" title="{{__('same.edit') }}"><i class="icon-pencil"></i></a> </div>
                <div class="input-group"> {{Form::open(array('route'=>['employee-salary.destroy',$data->id],'method'=>'DELETE'))}}
                  <button type="submit" class="btn btn-danger btn-xs confirm" confirm="{{__('same.delete_confirm') }}"  title="{{__('same.delete') }}"><i class="icon-trash"></i></button>
                  {!! Form::close() !!} </div>
              </div></td>
          </tr>
          @endforeach
          @else
          <tr>
            <td colspan="8" align="center">{{__('same.empty_row') }}</td>
          </tr>
          @endif
          </tbody>
        </table>
        <div>{{ $salaryList->render() }}</div>
      </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer"> </div>
    <!-- /.box-footer-->
  </div>
</section>
<!-- /.content -->
@endsection 