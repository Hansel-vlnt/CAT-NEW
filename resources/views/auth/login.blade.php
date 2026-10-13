<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Abdi Praja Edukasi | Login</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/plugins/ionicons-2.0.1/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/plugins/iCheck/square/blue.css') }}">
</head>
<body class="hold-transition login-page" style="background-color: #381c06;">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}"><img style="width:120px;" src="/assets/dist/img/logo.jpg"/></a>
  </div>
  <div class="login-box-body">
    <form role="form" method="POST" action="{{ route('login') }}">
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
      <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
          <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
        @endif
      </div>
      <div class="row">
        <div class="col-xs-12">
          <span><a href="{{ route('password.request') }}">Lupa Password</a></span>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            </label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="row">
            <div class="col-xs-6">
              <button type="button" class="btn btn-secondary btn-block" onclick="location.href='/register'">Register</button>
            </div>
            <div class="col-xs-6">
              <button type="submit" class="btn btn-primary btn-block">Log In</button>
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
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '10%'
    });
  });
</script>
</body>
</html>

