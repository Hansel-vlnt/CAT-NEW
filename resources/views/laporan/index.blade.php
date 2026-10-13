@extends('layouts.app')
@section('title', 'Laporan')
@section('breadcrumb')
  <h1>Laporan</h1>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="box box-primary">
  	<div class="box-header with-border">
      <h3 class="box-title">Laporan</h3>
    </div>
    <div class="box-body">
      <table class="table table-condensed table-hover" id="table_detail">
        <thead>
          <tr>
            <th>Nama Paket Soal</th>
            <th style="text-align: center;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($soal as $s)
            <tr>
              <td>{{ $s->paket }}</td>
              <td><div style="text-align:center"><a href="/elearning/laporan/paket/{{ $s->id }}" class="btn btn-primary btn-xs">Detail</a></div></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
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
<script>
$(document).ready(function (){
  table_paket_soal = $('#table_detail').DataTable({
    responsive: true,
    lengthChange: true,
    columns: [
      {data: 'nama', name: 'nama', orderable: true, searchable: true },
      {data: 'action', name: 'action', orderable: false, searchable: false, },
    ],
    "drawCallback": function (setting) {}
  });
});
</script>
@endpush