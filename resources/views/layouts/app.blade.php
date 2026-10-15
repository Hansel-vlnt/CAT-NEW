<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/ionicons-2.0.1/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('/assets/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. -->
  <link rel="stylesheet" href="{{ url('/assets/dist/css/skins/_all-skins.min.css') }}">
  <!-- Tailwind CSS & Modern Font -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/iCheck/flat/blue.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/datepicker/datepicker3.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/assets/plugins/sweetalert-master/themes/facebook/facebook.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/assets/plugins/sweetalert2-1.0.5/dist/sweetalert2.min.css') }}">
  <link rel="icon" href="{{ url('/assets/img/favicon.jpg') }}" type="image/x-icon"/>
  <style type="text/css">
    body {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
        font-size: 14px;
        color: #1e293b;
        background-color: #f8fafc;
    }
    .main-header .navbar {
        background-color: #0f172a !important;
        border-bottom: 1px solid #1e293b;
    }
    .main-header .logo {
        background-color: #090d16 !important;
        color: #ffffff !important;
        font-weight: 800;
        letter-spacing: -0.025em;
        border-bottom: 1px solid #1e293b;
    }
    .main-sidebar, .left-side {
        background-color: #0f172a !important;
    }
    .sidebar-menu > li.header {
        color: #64748b !important;
        background: #090d16 !important;
        font-weight: 700;
        letter-spacing: 0.05em;
        font-size: 11px;
    }
    .sidebar-menu > li > a {
        color: #94a3b8 !important;
        border-left: 3px solid transparent;
        font-weight: 500;
    }
    .sidebar-menu > li:hover > a, .sidebar-menu > li.active > a {
        color: #ffffff !important;
        background: #1e293b !important;
        border-left-color: #3b82f6 !important;
    }
    .content-wrapper {
        background-color: #f8fafc !important;
    }
    .box {
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
    }
    .box.box-primary {
        border-top-color: #3b82f6 !important;
    }
    .box-header.with-border {
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .dataTable td{
      font-size: 11pt !important;
    }
  </style>
  @stack('css')
</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">
  <?php
    $user = App\User::findorfail(Auth::user()->id);
  ?>
  <header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini font-black text-blue-500">AP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg flex items-center gap-2">
        <span class="w-6 h-6 rounded-md bg-blue-600 text-white flex items-center justify-center font-extrabold text-xs inline-block">ED</span>
        <span>Abdi Praja Bank Soal</span>
      </span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!--<li class="nav-item d-none d-sm-inline-block mr-2 mt-2" style="margin-left: 5px; margin-top:11px; font-weight:bold; color: white;">
            <span class="imgtgl font-weight-bold mr-2 mt-2" id='tanggal'>
                &nbsp;
            </span>
          </li>

          <li class="nav-item d-none d-sm-inline-block mr-5 mt-2" style="margin-left: 5px; margin-top:11px; font-weight:bold; color: white;">
              <span class="imgjam font-weight-bold mr-3 mt-2" id='jam'>
                  &nbsp;
              </span>
          </li>-->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              @if(Auth::user()->gambar != "")
                <img src="{{ url('/assets/img/user/'.Auth::user()->gambar) }}" class="user-image" alt="User Image">
              @else
                <img src="{{ url('/assets/dist/img/logo.jpg') }}" class="user-image" alt="User Image">
              @endif
              <span class="hidden-xs">{{ Auth::user()->nama }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-header" style="background-color: #542c0e !important;">
                @if(Auth::user()->gambar)
                  <img src="{{ url('/assets/img/user/'.Auth::user()->gambar) }}" class="img-circle" alt="User Image">
                @else
                  <img src="{{ url('/assets/dist/img/logo.jpg') }}" class="img-circle" alt="User Image">
                @endif

                <p>
                  {{ Auth::user()->nama }}
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-right">
                  <a href="/logout" class="btn btn-default btn-flat">Logout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      {{-- <div class="user-panel" style="margin-top: 10px">
        <div class="pull-left image">
          @if(Auth::user()->gambar != "")
            <img src="{{ url('/assets/img/user/'.Auth::user()->gambar) }}" class="img-circle" alt="User Image">
          @else
            <img src="{{ url('/assets/dist/img/logo.png') }}" class="img-circle" alt="User Image">
          @endif
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->nama }}</p>
        </div>
      </div> --}}
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" style="margin-top: 10px">
        <li class="header">MAIN NAVIGATION</li>
        <li class="{{ Request::is('/') == true || Request::is('home*') == true  ? 'active' : '' }}"><a href="{{ url('/home') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
        @if($user->status == 'G' or $user->status == 'A')
        <li class="treeview {{ Request::is('elearning*') == true  ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-graduation-cap"></i> <span>Try Out</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('elearning/soal*') == true  ? 'active' : '' }}"><a href="{{ url('/elearning/soal') }}"><i class="fa fa-circle-o"></i> Soal</a></li>
            <li class="{{Request::is('elearning/laporan*') == true  ? 'active' : '' }}"><a href="{{ url('/elearning/laporan') }}"><i class="fa fa-circle-o"></i> Laporan</a></li>
          </ul>
        </li>
        <li class="{{ Request::is('vouchers*') == true ? 'active' : '' }}"><a href="{{ url('/vouchers') }}"><i class="fa fa-id-card"></i> <span>Vouchers</span></a></li>
        @elseif($user->status == 'S')
        <li class="{{ Request::is('siswa/ujian*') == true ? 'active' : '' }}"><a href="{{ url('siswa/ujian') }}"><i class="fa fa-list"></i> <span>Ujian</span></a></li>
        @endif
        <li class="{{ Request::is('pengaturan*') == true ? 'active' : '' }}"><a href="{{ url('/pengaturan') }}"><i class="fa fa-cog"></i> <span>Pengaturan</span></a></li>
        <li class=""><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @yield('breadcrumb')
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        @yield('content')
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.3.5
    </div>
    <strong>Copyright &copy; {{ date('Y') }} <a href="//abdipraja.co.id" target="_blank">Abdi Praja Edukasi</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<!-- <script src="{{ url('/assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('/js/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ url('/assets/bootstrap/js/bootstrap.min.js') }}"></script>

<script src="{{ url('/assets/dist/js/moment.min.js') }}"></script>
<script src="{{ url('/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ url('/assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Bootstrap Sweetalert -->
<!-- <script src="{{ url('/assets/plugins/sweetalert-master/dist/sweetalert.min.js') }}"></script> -->
<script src="{{ url('assets/plugins/sweetalert2-1.0.5/dist/sweetalert2.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ url('/assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ url('/assets/plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('/assets/dist/js/app.min.js') }}"></script>

<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(".numOnly").keydown(function (e) {
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
      (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
      (e.keyCode >= 35 && e.keyCode <= 40)) {
        return;
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
    }
  });
</script>
<!--<script type='text/javascript'>
  var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
      'November', 'Desember'
  ];
  var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
  var date = new Date();
  var day = date.getDate();
  var month = date.getMonth();
  var thisDay = date.getDay(),
      thisDay = myDays[thisDay];
  var yy = date.getYear();
  var year = (yy < 1000) ? yy + 1900 : yy;
  document.getElementById("tanggal").innerHTML = thisDay + ', ' + day + ' ' + months[month] + ' ' + year;
</script>
<script type="text/javascript">
  // 1 detik = 1000
  window.setTimeout("waktu()", 1000);

  function waktu() {
      var tanggal = new Date();
      var minutes = tanggal.getMinutes() < 10 ? '0' + tanggal.getMinutes() : tanggal.getMinutes();
      var seconds = tanggal.getSeconds() < 10 ? '0' + tanggal.getSeconds() : tanggal.getSeconds();
      setTimeout("waktu()", 1000);
      document.getElementById("jam").innerHTML = tanggal.getHours() + ":" + minutes + ":" + seconds + " WIB";
  }
</script>-->
@stack('scripts')
</body>
</html>
