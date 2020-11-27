<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ app_name() }} | {{ $title ?? '' }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ url('admin_design')}}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('admin_design')}}/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('admin_design')}}/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('admin_design')}}/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('admin_design')}}/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a><b> {{ app_name() }} </b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">


    <p class="login-box-msg text-primary"> Reset Password </p>

    <form action="{{route('admin.do_reset_password' , $reset_password->token)}}" method="post">

      {{ csrf_field() }}


                    <div class="form-group  has-feedback">
                      <label for="email" class="control-label">Email*</label>
                      <input type="text" value="{{ old('email') }}" class="form-control" name="email" id="email" placeholder="Email">
                      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      @if ($errors->has('email'))
                          <span class="help-block alert alert-danger">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                    </div>
                    <div class="form-group has-feedback">
                      <label for="Password" class="control-label">Password</label>
                      <input type="password" class="form-control" name="password" placeholder="Password">
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      @if ($errors->has('password'))
                          <span class="help-block alert alert-danger">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                    </div>
                   <div class="form-group has-feedback">
                      <label for="confirmation_password" class="control-label">Password (re-type)*</label>
                      <input type="password" class="form-control" name="password_confirmation" placeholder="Password (re-type)*" id="password_confirmation">
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                      @if ($errors->has('password_confirmation'))
                          <span class="help-block alert alert-danger">
                              <strong>{{ $errors->first('password_confirmation') }}</strong>
                          </span>
                      @endif
                   </div>


      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary">
             Reset Your Password
          </button>

        </div>
        <!-- /.col -->
      </div>
    </form>



    <a class="alert-link alert" href=" {{ route('admin.login') }} ">Sign in</a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ url('admin_design')}}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('admin_design')}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{ url('admin_design')}}/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
