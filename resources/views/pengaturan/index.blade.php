@extends('layouts.app')
@section('title', 'Pengaturan')
@section('breadcrumb')
  <h1>Pengaturan</h1>
@endsection
@section('content')
<div class="col-md-12">
  <div class="box box-default">
    <div class="box-body">
      <form method="post" id="form_profil" class="form-horizontal">
        {{ csrf_field() }}
        <div class="box-body">
          <div class="form-group">
            <label for="nama" class="col-md-3 control-label">Nama Lengkap</label>
            <div class="col-sm-5">
              <input type="hidden" name="id" value="{{ $user->id }}">
              <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Lengkap" value="{{ $user->nama }}">
            </div>
          </div>
          <div class="form-group">
            <label for="jk" class="col-md-3 control-label">Jenis Kelamin</label>
            <div class="col-sm-5">
              <div class="radio">
                <label>
                  <input type="radio" name="jk" id="laki_laki" value="L" <?php if ($user->jk == 'L') { echo "checked"; } ?>> Laki-laki
                </label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label>
                  <input type="radio" name="jk" id="perempuan" value="P" <?php if ($user->jk == 'P') { echo "checked"; } ?>> Perempuan
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="email" class="col-md-3 control-label">Email</label>
            <div class="col-sm-5">
              <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ $user->email }}">
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-md-3 control-label">Password</label>
            <div class="col-sm-5">
              <input type="password" class="form-control" data-toggle="tooltip" title="Kosongkan field ini jika password Anda tidak diubah" name="password" id="password" placeholder="Password" value="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
              <button type="button" class="btn btn-primary btn-md" id="update_profil">Update</button>
              <div id="notif" style="display: none; margin: 15px 0 0 0"></div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="overlay" id="loading" style="display: none;">
      <i class="fa fa-refresh fa-spin"></i>
    </div>
  </div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{ url('/assets/plugins/dropzone/dropzone.css') }}">
<style type="text/css">
  .panel {
    margin-bottom: 5px !important;
  }
  .form-group {
    margin-bottom: 5px;
  }
  .wrap-is {
    cursor: pointer;
  }
</style>
@endpush
@push('scripts')
<script src="{{ url('/assets/plugins/dropzone/dropzone.js') }}"></script>
<script>
$(document).ready(function(){
  $("#update_profil").click(function(){
    $(this).hide();
    $("#notif").hide();
    $("#loading").show();
    var formData = $("#form_profil").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/update-profil') }}",
      data: formData,
      success: function(data){
        $("#loading").hide();
        if(data == 'ok'){
          $("#notif").removeClass('alert alert-danger').addClass('alert alert-info').html("Data berhasil diperbaharui.").fadeIn(350);
          location.href = "{{ url('/pengaturan') }}";
        }else{
          $("#notif").removeClass('alert alert-info').addClass('alert alert-danger').html(data).fadeIn(350);
          $("#update_profil").show();
        }
      }
    })
  });
  $(".wrap-is").click(function() {
    $(this).hide();
    $(this).closest('td').find('.info-sekolah').show().focus();
    var jenis = $(this).closest('td').find('.info-sekolah').attr('name');
    $('.jenisInfo').val(jenis);
  });
  $(".info-sekolah").blur(function() {
    var formInfoSekolah = $("#formInfoSekolah").serialize();
    var jenisInfo = $('.jenisInfo').val();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/update-profil-sekolah') }}",
      data: formInfoSekolah+'&jenisInfo='+jenisInfo,
      context: this,
      success: function(data){
        $(this).hide();
        $(this).closest('td').find('.wrap-is').html(data).show()
      }
    })
  });
})
</script>
@endpush