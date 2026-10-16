<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Portal Belajar') - Latihan Soal Abdi Praja</title>
  <!-- Responsive screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/ionicons-2.0.1/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('/assets/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins -->
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
        font-size: 15px !important;
        line-height: 1.6 !important;
        color: #1e293b;
        background-color: #f8fafc;
        -webkit-font-smoothing: antialiased;
    }
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        color: #0f172a;
        font-weight: 700;
        letter-spacing: -0.015em;
    }
    .main-header .navbar {
        background-color: #0f172a !important;
        border-bottom: 1px solid #1e293b;
        min-height: 54px;
    }
    .main-header .logo {
        background-color: #090d16 !important;
        color: #ffffff !important;
        font-weight: 800;
        letter-spacing: -0.02em;
        border-bottom: 1px solid #1e293b;
        height: 54px;
        line-height: 54px;
    }
    .main-sidebar, .left-side {
        background-color: #0f172a !important;
        border-right: 1px solid #1e293b;
    }
    .sidebar-menu > li.header {
        color: #64748b !important;
        background: #090d16 !important;
        font-weight: 700;
        letter-spacing: 0.06em;
        font-size: 11px;
        padding: 12px 20px 8px 20px;
    }
    .sidebar-menu > li > a {
        color: #94a3b8 !important;
        border-left: 3px solid transparent;
        font-weight: 600;
        font-size: 14px;
        padding: 12px 18px;
        transition: all 0.15s ease-in-out;
    }
    .sidebar-menu > li:hover > a, .sidebar-menu > li.active > a {
        color: #ffffff !important;
        background: #1e293b !important;
        border-left-color: #6366f1 !important;
    }
    .content-wrapper {
        background-color: #f8fafc !important;
        min-height: calc(100vh - 105px) !important;
    }
    .content-header {
        padding: 20px 24px 8px 24px !important;
    }
    .content-header > h1 {
        font-size: 24px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        letter-spacing: -0.02em;
        margin: 0;
    }
    .content {
        padding: 16px 24px 32px 24px !important;
    }
    .box {
        border-radius: 16px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px 0 rgba(15, 23, 42, 0.04) !important;
        background-color: #ffffff !important;
    }
    .box.box-primary {
        border-top: 3px solid #4f46e5 !important;
    }
    .box.box-default {
        border-top: 1px solid #e2e8f0 !important;
    }
    .box-header.with-border {
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 16px 20px !important;
    }
    .box-title {
        font-size: 17px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
    }
    .form-control {
        border-radius: 10px !important;
        border: 1px solid #cbd5e1 !important;
        font-size: 15px !important;
        height: 48px !important;
        padding: 10px 14px !important;
        color: #1e293b !important;
        box-shadow: none !important;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .form-control:focus {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
    }
    .btn {
        border-radius: 10px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        padding: 10px 18px !important;
        letter-spacing: 0.01em;
        transition: all 0.15s ease-in-out;
    }
    .btn-primary {
        background-color: #4f46e5 !important;
        border-color: #4f46e5 !important;
        color: #ffffff !important;
    }
    .btn-primary:hover, .btn-primary:focus {
        background-color: #4338ca !important;
        border-color: #4338ca !important;
    }
    .dataTable td {
        font-size: 14px !important;
        vertical-align: middle !important;
    }
    .main-footer {
        background-color: #ffffff !important;
        border-top: 1px solid #e2e8f0 !important;
        color: #64748b !important;
        font-size: 13px !important;
        padding: 16px 24px !important;
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
      <span class="logo-mini font-black text-indigo-400">AP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg flex items-center gap-2">
        <span class="w-7 h-7 rounded-lg bg-indigo-600 text-white flex items-center justify-center font-extrabold text-xs inline-flex shadow-sm">AP</span>
        <span class="font-bold tracking-tight text-white text-base">Latihan Soal Abdi Praja</span>
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
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              @if(Auth::user()->gambar != "")
                <img src="{{ url('/assets/img/user/'.Auth::user()->gambar) }}" class="user-image" alt="User Image">
              @else
                <img src="{{ url('/assets/dist/img/logo.jpg') }}" class="user-image" alt="User Image">
              @endif
              <span class="hidden-xs font-semibold">{{ Auth::user()->nama }}</span>
            </a>
            <ul class="dropdown-menu shadow-xl border border-slate-200 rounded-xl overflow-hidden">
              <li class="user-header" style="background-color: #0f172a !important; border-bottom: 1px solid #1e293b;">
                @if(Auth::user()->gambar)
                  <img src="{{ url('/assets/img/user/'.Auth::user()->gambar) }}" class="img-circle border-2 border-indigo-500" alt="User Image">
                @else
                  <img src="{{ url('/assets/dist/img/logo.jpg') }}" class="img-circle border-2 border-indigo-500" alt="User Image">
                @endif

                <p class="text-white font-bold text-base mt-2">
                  {{ Auth::user()->nama }}
                  <small class="text-slate-400 mt-1">
                    @if($user->status == 'A')
                      Administrator
                    @elseif($user->status == 'G')
                      Guru / Instruktur
                    @else
                      Siswa / Peserta Ujian
                    @endif
                  </small>
                </p>
              </li>
              <li class="user-footer bg-slate-50 p-3 flex justify-between items-center">
                <div class="pull-left">
                  <a href="{{ url('/pengaturan') }}" class="btn btn-default btn-sm text-slate-700 font-medium">Pengaturan</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-danger btn-sm font-medium">Keluar</a>
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
    <section class="sidebar">
      <ul class="sidebar-menu" style="margin-top: 10px">
        <li class="header">NAVIGASI UTAMA</li>
        <li class="{{ Request::is('/') == true || Request::is('home*') == true  ? 'active' : '' }}"><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        @if($user->status == 'G' or $user->status == 'A')
        <li class="treeview {{ Request::is('elearning*') == true  ? 'active' : '' }}">
          <a href="#">
            <i class="fa fa-graduation-cap"></i> <span>Bank Soal &amp; Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('elearning/soal*') == true  ? 'active' : '' }}"><a href="{{ url('/elearning/soal') }}"><i class="fa fa-circle-o"></i> Manajemen Soal</a></li>
            <li class="{{ Request::is('elearning/laporan*') == true  ? 'active' : '' }}"><a href="{{ url('/elearning/laporan') }}"><i class="fa fa-circle-o"></i> Rapor &amp; Laporan</a></li>
          </ul>
        </li>
        <li class="{{ Request::is('master/siswa*') == true ? 'active' : '' }}"><a href="{{ url('/master/siswa') }}"><i class="fa fa-users"></i> <span>Data Siswa</span></a></li>
        <li class="{{ Request::is('vouchers*') == true ? 'active' : '' }}"><a href="{{ url('/vouchers') }}"><i class="fa fa-id-card"></i> <span>Voucher Lisensi</span></a></li>
        @elseif($user->status == 'S')
        <li class="{{ Request::is('siswa/ujian*') == true ? 'active' : '' }}"><a href="{{ url('siswa/ujian') }}"><i class="fa fa-book"></i> <span>Katalog Latihan Soal</span></a></li>
        @endif
        <li class="{{ Request::is('pengaturan*') == true ? 'active' : '' }}"><a href="{{ url('/pengaturan') }}"><i class="fa fa-cog"></i> <span>Pengaturan Akun</span></a></li>
        <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> <span>Keluar</span></a></li>
      </ul>
    </section>
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
    <div class="pull-right hidden-xs text-slate-400">
      <b>Latihan Soal Abdi Praja</b> &bull; Versi 2.0 (Modern Bimbel)
    </div>
    <strong>Hak Cipta &copy; {{ date('Y') }} <a href="//abdipraja.co.id" target="_blank" class="text-indigo-600 hover:text-indigo-800 font-semibold">Latihan Soal Abdi Praja</a>.</strong> Seluruh hak cipta dilindungi.
  </footer>
</div>
<!-- ./wrapper -->

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="{{ url('/js/jquery-ui.min.js') }}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="{{ url('/assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ url('/assets/dist/js/moment.min.js') }}"></script>
<script src="{{ url('/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ url('/assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ url('assets/plugins/sweetalert2-1.0.5/dist/sweetalert2.min.js') }}"></script>
<script src="{{ url('/assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ url('/assets/plugins/fastclick/fastclick.js') }}"></script>
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
@stack('scripts')
</body>
</html>
