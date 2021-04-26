<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ __('login.title') }}</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
{!!Html::style('public/custom/css/bootstrap.min.css')!!}
{!!Html::style('public/custom/css_icon/font-awesome/css/font-awesome.min.css')!!}
{!!Html::style('public/custom/css/AdminLTE.css')!!}
{!!Html::script('public/custom/js/plugins/jquery/dist/jquery.min.js')!!}
{!!Html::script('public/custom/js/plugins/bootstrap/dist/js/bootstrap.min.js')!!}
</head>
<body class="hold-transition skin-green-light sidebar-mini">

  <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 500px; margin: 0 auto;">
          <div class="modal-header">
            <h4 class="modal-title" align="center" style="color: #00A65A"><strong>{{ __('login.select-branch') }}</strong></h4>
          </div>

          <div class="modal-body">
            <?php  
              $admin_all_branches = DB::table('branchs')->get();
            ?>
            @foreach($admin_all_branches as $branch)
              <div class="">
                <a href="{{URL::To('admin-proceed-to-dashboard')}}/{{$branch->id}}" style="cursor: pointer;">
                  <div class="info-box" style="border: 1px solid #00A65A;">
                    <span class="info-box-icon bg-green"><i class="fa fa-home"></i></span>
                      <div class="info-box-content" > 
                        <span class="info-box-text" style="font-weight: bold;">{{$branch->branch_name}}</span> 
                        <span class="info-box-text">{{$branch->branch_address}}</span> 
                      </div>
                  </div>
                </a>
              </div>
            @endforeach
                
          </div>
          <div class="modal-footer"> 
              <div class="pull-right"> 
                <a id="__logout_system" href="{{ route('logout') }}" class="btn btn-danger btn-flat" onClick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('login.signout') }}</a> 
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
  <!-- /.modal -->

  <script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });

    $('#myModal').modal({
        backdrop: 'static',
        keyboard: false
    });
</script>

</body>
</html>
