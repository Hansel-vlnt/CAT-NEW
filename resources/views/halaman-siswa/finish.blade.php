@extends('layouts.app')
@section('title', Auth::user()->nama)
@section('breadcrumb')
  <h1>Detail Soal Ujian</h1>
@endsection
@section('content')
	<div class="col-md-12">
	  <div class="box box-primary">
	    <div class="box-header with-border">
	      <h3 class="box-title">Selesai Ujian</h3>
	    </div>
	    <div class="box-body">
	    	<center>
	    		<i class="fa fa-smile-o" aria-hidden="true" style="font-size: 50pt; color: #18b10f;"></i>
	    		<p style="color: #848383; font-size: 14pt; margin: 0">Selamat, kamu telah berhasil menyelesaikan ujian <b>{{ $soal->paket }}</b></p>
	    		<p style="color: #848383; font-size: 14pt; margin: 0"><small>Nilai yang kamu dapatkan adalah</small> <b>{{ number_format($nilai) }}</b></p>
	    	</center>
	    </div>
	  </div>
	</div>
@endsection