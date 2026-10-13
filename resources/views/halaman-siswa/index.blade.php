@extends('layouts.app')
@section('title', "Abdi Praja Edukasi".Auth::user()->nama)
@section('breadcrumb')
  <h1>Home</h1>
@endsection
@section('content')
	<div class="col-md-8">
	  <div class="box box-primary">
	    <div class="box-header with-border">
	      <h3 class="box-title">Materi terbaru</h3>
	      <div class="box-tools pull-right">
	        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	      </div>
	    </div>
	    <div class="box-body">
	    	<table class="table table-hover table-striped" id="table_soal">
	    	<caption>Data materi yang bisa dipelajari</caption>
        <thead>
          <tr>
            <th>Judul materi</th>
            <th style="text-align: center; width: 110px">Aksi</th>
          </tr>
        </thead>
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
  table_soal = $('#table_soal').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    ajax: {
      url: '{!! route('siswa.materi') !!}',
      
    },
    columns: [
      {data: 'judul', name: 'judul', orderable: true, searchable: true },
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