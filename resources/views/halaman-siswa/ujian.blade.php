@extends('layouts.app')
@section('title', Auth::user()->nama)
@section('breadcrumb')
  <h1>Paket Soal</h1>
@endsection
@section('content')
	<div class="col-md-12">
		<div class="row">
			@if($pakets->count())
				@foreach($pakets as $paket_soal)
					<?php
						$check		= App\Models\Jawab::where([['id_soal', $paket_soal->id], ['id_user', Auth::user()->id], ['status', 1]])->first();
						$tryCount	= DB::table("jawabs_count")->where([['id_soal', $paket_soal->id], ['id_user', Auth::user()->id]])->first();
						if(!empty($tryCount)){
							$tryCount = $tryCount->try_count;
						} else {
							$tryCount = 0;
						}
					?>
					<div class="col-sm-4">
						@if($check && $tryCount >= 3)
							<a href="{{ url('siswa/ujian/finish/'.$paket_soal->id) }}">
								<div class="info-box bg-yellow">
							<span class="info-box-icon"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
							<div class="info-box-content">
								<span class="info-box-text"><b>SELESAI DIKERJAKAN</b></span>
								<div class="progress">
								<div class="progress-bar" style="width: 100%"></div>
								</div>
							<span class="progress-description">{{ $paket_soal->paket }}</span>
							</div>
							</div>
							</a>
						@else
							<a href="{{ url('siswa/ujian/detail/'.$paket_soal->id) }}">
								<div class="info-box bg-green">
							<span class="info-box-icon"><i class="fa fa-pencil-square-o"></i></span>
							<div class="info-box-content">
								<span class="info-box-text"><b>BELUM DIKERJAKAN</b></span>
								<!-- <span class="info-box-number"></span> -->
								<div class="progress">
								<div class="progress-bar" style="width: 100%"></div>
								</div>
							<span class="progress-description">{{ $paket_soal->paket }}</span>
							</div>
							</div>
							</a>
						@endif
					</div>
				@endforeach
			@else
					<div class="col-md-12">Belum ada soal yang bisa dikerjakan.</div>
			@endif
		</div>
	</div>
@endsection
@push('css')
<style>
	.bg-aqua{
		background-color: #117e98 !important;
	}
</style>
@endpush