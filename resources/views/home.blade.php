<?php use Carbon\Carbon; ?>
@extends('layouts.app')
@section('title', 'Home')
@section('breadcrumb')
  <h1>Dashboard</h1>
@endsection
@section('content')
  <?php include(app_path().'/functions/myconf.php'); ?>
  @if(Auth::user()->status == 'A' || Auth::user()->status == 'G')
    <div class="col-md-3 col-sm-4 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="ion ion-person-stalker"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Jumlah Siswa</span>
          <span class="info-box-number">{{ number_format($siswas) }} <small>siswa</small></span>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="ion ion-ios-list-outline"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Jumlah Paket Soal</span>
          <span class="info-box-number">{{ number_format($pakets) }} <small>paket</small></span>
          <span><b>{{ number_format($soals) }}</b> <small>soal</small></span>
        </div>
      </div>
    </div>
  @else
    @if(!empty($voucher["expiry_date"]))
      <div class="col-md-3 col-sm-4 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-id-card"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Masa Aktif Voucher</span>
            <span class="info-box-number">{{ date("d-m-Y", strtotime($voucher["expiry_date"])) }}</span>
          </div>
        </div>
      </div>
      @endif
      @if($voucher["status"] == 0)
      <div id="cekVoucher" class="row">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-12">
              <div class="alert alert-info">{{ $voucher["message"] }}</div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <form method="post" id="voucher" action="{{ route('aktivasi') }}" class="form-horizontal">
                {{ csrf_field() }}
                <div class="box-body">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="kode_voucher" id="kode_voucher" placeholder="Masukkan Kode Voucher">
                      </div>
                      <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary btn-md" id="aktivasi">Aktivasi</button>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endif
  @endif
@endsection
@push('css')
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
@endpush
@push('scripts')
  <script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
  @if(Session::has('success'))
    <script>
      swal("", '{!! Session::get("success") !!}', "success");
    </script>
  @endif
  @if(Session::has('error'))
    <script>
      swal("", '{!! Session::get("error") !!}', "error");
    </script>
  @endif
  @if(Session::has('status'))
  <script>
      swal("", '{!! Session::get("status") !!}', "success");
  </script>
  @endif
  <script>
  $(document).ready(function (){
    table_soal = $('#table_soal').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      lengthChange: true,
      ajax: {
        url: '{!! route('elearning.get-soal-home') !!}',
        
      },
      columns: [
        {data: 'paket', name: 'paket', orderable: true, searchable: true },
        {data: 'deskripsi', name: 'deskripsi', orderable: true, searchable: true },
        {data: 'waktu', name: 'waktu', orderable: true, searchable: true },
        {data: 'action', name: 'action', orderable: false, searchable: false, },
      ],
      "drawCallback": function (setting) {}
    });
    $("#btn-wrap-info").click(function() {
      $(this).hide();
      $("#wrap-info").show();
    });
  });
  </script>
@endpush