<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Abdi Praja Edukasi | Reset Password</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/plugins/ionicons-2.0.1/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/plugins/iCheck/square/blue.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/assets/plugins/sweetalert-master/themes/facebook/facebook.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/assets/plugins/sweetalert2-1.0.5/dist/sweetalert2.min.css') }}">
</head>
<body class="hold-transition" style="background-color: #381c06;">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}"><img style="width:120px;" src="/assets/dist/img/logo.jpg"/></a>
  </div>
  <div class="login-box-body">
    <form role="form" method="POST" action="{{ route('password.email') }}">
      {{ csrf_field() }}
      <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        <input id="email" type="email" class="form-control" name="email" placeholder="E-mail" value="{{ old('email') }}" required autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if ($errors->has('email'))
          <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
        @endif
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="row">
            <div class="col-xs-6">
              <button type="button" class="btn btn-secondary btn-block" onclick="location.href='/login'">Login</button>
            </div>
            <div class="col-xs-6">
              <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="{{ url('/assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script src="{{ url('/assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ url('/assets/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ url('/assets/plugins/sweetalert2-1.0.5/dist/sweetalert2.min.js') }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '10%'
    });
  });
</script>
@if(Session::has('status'))
<script>
    swal("", '{!! Session::get("status") !!}', "success");
</script>
@endif
</body>
</html>