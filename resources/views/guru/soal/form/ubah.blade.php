@extends('layouts.app')
@section('title', 'Aplikasi Ujian Berbasis Komputer')
@section('breadcrumb')
  <h1>Dashboard</h1>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Ubah Paket Soal</h3>
    </div>
    <form class="form-horizontal" id="formSoal">
      {{ csrf_field() }}
      <input type="hidden" name="id" value="{{$soal->id}}">
      <div class="box-body">
        <div class="form-group">
          <label for="paket" class="col-sm-2 control-label">Paket</label>
          <div class="col-sm-10">
            <input id="paket" type="text" class="form-control" name="paket" placeholder="Nama paket" value="{{ $soal->paket }}">
          </div>
        </div>
        <div class="form-group">
          <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
          <div class="col-sm-10">
            <textarea id="deskripsi" name="deskripsi" class="form-control" placeholder="Deskripsi">{{ $soal->deskripsi }}</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="waktu" class="col-sm-2 control-label">Waktu (<small>Detik</small>)</label>
          <div class="col-sm-2">
            <input id="waktu" type="text" class="form-control numOnly" data-toggle="tooltip" title="Masukan waktu ujian dalam satuan detik" name="waktu" placeholder="Waktu" value="{{ $soal->waktu }}">
          </div>
        </div>
        <div class="form-group">
          <label for="tipe_waktu" class="col-sm-2 control-label">Jenis Soal</label>
          <div class="col-sm-2">
            <select id="jenis" class="form-control" data-toggle="tooltip" name="jenis">
              <option value="0" @if($soal->jenis_soal == 0) {{ "selected" }} @endif>Normal</option>
              <option value="1" @if($soal->jenis_soal == 1) {{ "selected" }} @endif>Cerdas Cermat</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="col-sm-2 control-label">Password</label>
          <div class="col-sm-2">
            <input id="password" type="text" class="form-control" data-toggle="tooltip" title="Masukkan password untuk soal" name="password" placeholder="Password" value="{{ $soal->password }}">
          </div>
        </div>
        <div class="form-group">
        	<div class="col-sm-offset-2 col-sm-10">
        		<div id="wrap-btn">
	        		<button type="button" class="btn btn-danger" onclick="self.history.back()">Kembali</button>
			        <button type="button" class="btn btn-info" id="btnSimpan">Simpan</button>
			      </div>
            <div id="notif" style="display: none; margin-top: 15px""></div>
        	</div>
        </div>
        <div class="overlay" id="loading" style="display: none;"><i class="fa fa-refresh fa-spin" ></i></div>
      </div>
    </form>
  </div>
</div>
@endsection
@push('css')
<style type="text/css">
  .panel {
    margin-bottom: 5px !important;
  }
  .form-group {
    margin-bottom: 5px;
  }
</style>
@endpush
@push('scripts')
<script>
$(document).ready(function(){
	$("#btnSimpan").click(function(){
		$("#wrap-btn").hide();
    $("#loading").show();
    var dataString = $("#formSoal").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/simpan-soal') }}",
      data: dataString,
      success: function(data){
        console.log(data);
        if (data == 'ok') {
          $("#loading").hide();
          $("#wrap-btn").show();
          $("#notif").removeClass('alert alert-danger').addClass('alert alert-info').html("<i class='fa fa-info-circle'></i> Data berhasil disimpan.").fadeIn(350);
          window.location.href = "{{ url('elearning/soal/detail/'.$soal->id) }}";
        }else{
          $("#loading").hide();
          $("#wrap-btn").show();
          $("#notif").removeClass('alert alert-info').addClass('alert alert-danger').html(data).fadeIn(350);
        }
      }
    })
	});
});
</script>
@endpush