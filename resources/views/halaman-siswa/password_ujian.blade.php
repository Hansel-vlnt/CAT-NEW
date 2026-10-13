@extends('layouts.app')
@section('title', "Abdi Praja Edukasi")
@section('breadcrumb')
  <h1>Password Soal</h1>
@endsection
@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="alert alert-info">Silahkan masukkan <b>password paket soal</b> untuk membuka paket soal ini.</div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <form method="post" id="password_soal" class="form-horizontal">
      {{ csrf_field() }}
      <div class="box-body">
        <div class="form-group">
          <div class="row">
            <div class="col-sm-6" style="padding: 3px;">
              <input type="text" class="form-control" name="password" id="password" placeholder="Masukkan Password" autocomplete="off">
            </div>
            <div class="col-sm-6" style="padding: 3px;">
              <button type="submit" class="btn btn-primary btn-md" id="aktivasi">Lanjutkan</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
@push('scripts')
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
@endpush