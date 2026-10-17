<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Portal Belajar') - Latihan Soal Abdi Praja</title>
  <!-- Responsive screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
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
  <!-- KaTeX Formula Support -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">
  <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/contrib/auto-render.min.js" onload="if (window.renderMathInElement) { renderMathInElement(document.body, {delimiters: [{left: '$$', right: '$$', display: true}, {left: '$', right: '$', display: false}]}); }"></script>
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/iCheck/flat/blue.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ url('/assets/plugins/datepicker/datepicker3.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/assets/plugins/sweetalert-master/themes/facebook/facebook.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/assets/plugins/sweetalert2-1.0.5/dist/sweetalert2.min.css') }}">
  <link rel="icon" href="{{ url('/assets/img/favicon.jpg') }}" type="image/x-icon"/>
  <style type="text/css">
    html, body {
        width: 100% !important;
        min-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: hidden;
    }
    body {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
        font-size: 15.5px !important;
        line-height: 1.6 !important;
        color: #1e293b;
        background-color: #f8fafc;
        -webkit-font-smoothing: antialiased;
        position: relative !important;
    }
    .wrapper {
        width: 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
        margin: 0 !important;
        position: relative;
    }
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        color: #0f172a;
        font-weight: 700;
        letter-spacing: -0.015em;
    }
    h1 { font-size: 28px !important; font-weight: 800 !important; }
    h2 { font-size: 23px !important; font-weight: 800 !important; }
    h3 { font-size: 19px !important; font-weight: 700 !important; }
    h4 { font-size: 17px !important; font-weight: 700 !important; }

    .main-header .navbar {
        background-color: #0f172a !important;
        border-bottom: 1px solid #1e293b;
        min-height: 56px;
    }
    .main-header .logo {
        background-color: #090d16 !important;
        color: #ffffff !important;
        font-weight: 800;
        letter-spacing: -0.02em;
        border-bottom: 1px solid #1e293b;
        height: 56px;
        line-height: 56px;
    }
    .main-sidebar, .left-side {
        background-color: #0f172a !important;
        border-right: 1px solid #1e293b;
    }
    .sidebar-menu > li.header {
        color: #64748b !important;
        background: #090d16 !important;
        font-weight: 700;
        letter-spacing: 0.08em;
        font-size: 13.5px !important;
        padding: 16px 20px 8px 20px;
    }
    .sidebar-menu > li > a {
        color: #94a3b8 !important;
        border-left: 3px solid transparent;
        font-weight: 600;
        font-size: 16.5px !important;
        padding: 14px 20px;
        transition: all 0.15s ease-in-out;
    }
    .sidebar-menu > li:hover > a, .sidebar-menu > li.active > a {
        color: #ffffff !important;
        background: #1e293b !important;
        border-left-color: #6366f1 !important;
    }
    .sidebar-menu .treeview-menu > li > a {
        font-size: 15.5px !important;
        padding: 11px 18px 11px 24px;
    }
    .content-wrapper {
        width: calc(100% - 230px) !important;
        min-width: calc(100% - 230px) !important;
        margin-left: 230px !important;
        float: right !important;
        background-color: #f8fafc !important;
        min-height: calc(100vh - 105px) !important;
    }
    .sidebar-collapse .content-wrapper {
        width: calc(100% - 50px) !important;
        min-width: calc(100% - 50px) !important;
        margin-left: 50px !important;
    }
    @media (max-width: 767px) {
        .content-wrapper {
            width: 100% !important;
            min-width: 100% !important;
            margin-left: 0 !important;
            float: none !important;
        }
    }
    .main-footer {
        width: calc(100% - 230px) !important;
        margin-left: 230px !important;
        float: right !important;
        background-color: #ffffff !important;
        border-top: 1px solid #e2e8f0 !important;
        color: #64748b !important;
        font-size: 15px !important;
        padding: 16px 24px !important;
    }
    .sidebar-collapse .main-footer {
        width: calc(100% - 50px) !important;
        margin-left: 50px !important;
    }
    @media (max-width: 767px) {
        .main-footer {
            width: 100% !important;
            margin-left: 0 !important;
            float: none !important;
        }
    }
    .content > .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100% !important;
    }
    .content-header {
        padding: 24px 28px 10px 28px !important;
    }
    .content-header > h1 {
        font-size: 30px !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        letter-spacing: -0.02em;
        margin: 0;
    }
    .content {
        padding: 16px 28px 36px 28px !important;
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
        padding: 18px 24px !important;
    }
    .box-title {
        font-size: 21px !important;
        font-weight: 700 !important;
        color: #0f172a !important;
    }
    .form-control {
        border-radius: 12px !important;
        border: 1px solid #cbd5e1 !important;
        font-size: 15px !important;
        padding: 10px 16px !important;
        color: #1e293b !important;
        box-shadow: none !important;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    input.form-control, select.form-control {
        height: 46px !important;
        min-height: 46px !important;
    }
    textarea.form-control {
        height: auto !important;
        min-height: 80px;
    }
    .form-control:focus {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
    }
    label {
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #334155 !important;
        margin-bottom: 6px !important;
        line-height: 1.4 !important;
        display: inline-block !important;
    }
    .btn {
        border-radius: 12px !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        padding: 10px 20px !important;
        letter-spacing: 0.01em;
        transition: all 0.15s ease-in-out;
    }
    .btn-xs {
        font-size: 12px !important;
        padding: 5px 10px !important;
        border-radius: 6px !important;
    }
    .btn-sm {
        font-size: 13.5px !important;
        padding: 7px 14px !important;
        border-radius: 8px !important;
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
    .table th, .dataTable th {
        font-size: 14.5px !important;
        font-weight: 700 !important;
        color: #334155 !important;
        padding: 12px 14px !important;
        border-bottom: 2px solid #e2e8f0 !important;
    }
    .table td, .dataTable td {
        font-size: 14.5px !important;
        vertical-align: middle !important;
        padding: 12px 14px !important;
        color: #1e293b !important;
        line-height: 1.5 !important;
    }
    .dataTables_info, .dataTables_paginate, .dataTables_length, .dataTables_filter {
        font-size: 14px !important;
        color: #64748b !important;
        margin-top: 8px !important;
        margin-bottom: 8px !important;
    }
    .dataTables_filter input {
        border-radius: 10px !important;
        border: 1px solid #cbd5e1 !important;
        padding: 6px 12px !important;
        font-size: 14px !important;
        outline: none !important;
        margin-left: 8px !important;
    }
    .dataTables_filter input:focus {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
    }
    .dataTables_length select {
        border-radius: 8px !important;
        border: 1px solid #cbd5e1 !important;
        padding: 4px 8px !important;
        font-size: 14px !important;
        outline: none !important;
        margin: 0 6px !important;
    }
    /* DataTables Responsive icon fix so it NEVER overlaps text */
    table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child,
    table.dataTable.dtr-inline.collapsed > tbody > tr > th:first-child,
    table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control,
    table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control {
        padding-left: 38px !important;
        position: relative !important;
    }
    table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child:before,
    table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before {
        top: 50% !important;
        transform: translateY(-50%) !important;
        left: 10px !important;
        height: 16px !important;
        width: 16px !important;
        line-height: 16px !important;
        text-align: center !important;
        box-shadow: none !important;
    }
  </style>
  @stack('css')
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php
    $user = App\User::findorfail(Auth::user()->id);
  ?>
  <header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
        <img src="{{ url('/assets/dist/img/logo.jpg') }}" alt="Logo Abdi Praja" style="width: 32px; height: 32px; object-fit: contain; border-radius: 8px; display: inline-block; vertical-align: middle; margin-top: -2px;">
      </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg" style="display: flex; align-items: center; justify-content: center; gap: 8px; height: 56px; padding: 0 4px;">
        <img src="{{ url('/assets/dist/img/logo.jpg') }}" alt="Logo Abdi Praja" style="width: 28px; height: 28px; object-fit: contain; border-radius: 6px; flex-shrink: 0;">
        <span style="font-weight: 800; font-size: 13.5px; color: #ffffff; letter-spacing: -0.02em; white-space: nowrap;">Latihan Soal Abdi Praja</span>
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
            <i class="fa fa-graduation-cap"></i> <span>Bank Soal &amp; Materi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('elearning/soal*') == true  ? 'active' : '' }}"><a href="{{ url('/elearning/soal') }}"><i class="fa fa-circle-o"></i> Manajemen Soal</a></li>
            <li class="{{ Request::is('elearning/materi*') == true  ? 'active' : '' }}"><a href="{{ url('/elearning/materi') }}"><i class="fa fa-circle-o"></i> Materi Pembelajaran</a></li>
            <li class="{{ Request::is('elearning/laporan*') == true  ? 'active' : '' }}"><a href="{{ url('/elearning/laporan') }}"><i class="fa fa-circle-o"></i> Rapor &amp; Laporan</a></li>
          </ul>
        </li>
        <li class="{{ Request::is('master*') == true ? 'active' : '' }}"><a href="{{ url('/master/siswa') }}"><i class="fa fa-users"></i> <span>Data Siswa</span></a></li>
        <li class="{{ Request::is('vouchers*') == true ? 'active' : '' }}"><a href="{{ url('/vouchers') }}"><i class="fa fa-id-card"></i> <span>Voucher Lisensi</span></a></li>
        @elseif($user->status == 'S')
        <li class="{{ Request::is('siswa/ujian*') == true ? 'active' : '' }}"><a href="{{ url('siswa/ujian') }}"><i class="fa fa-book"></i> <span>Katalog Latihan Soal</span></a></li>
        <li class="{{ Request::is('siswa/materi*') == true ? 'active' : '' }}"><a href="{{ url('siswa/materi') }}"><i class="fa fa-file-text-o"></i> <span>Materi Pembelajaran</span></a></li>
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

  $(".numOnly").on("keydown", function (e) {
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
      ((e.keyCode === 65 || e.keyCode === 67 || e.keyCode === 86 || e.keyCode === 88 || e.keyCode === 90) && (e.ctrlKey === true || e.metaKey === true)) || 
      (e.keyCode >= 35 && e.keyCode <= 40)) {
        return;
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
    }
  }).on("input", function() {
    this.value = this.value.replace(/[^0-9.]/g, '');
  });
</script>
@stack('scripts')
</body>
</html>
