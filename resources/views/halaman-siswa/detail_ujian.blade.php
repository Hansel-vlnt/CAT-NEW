<?php
	$check = App\Models\Jawab::where([['id_soal', $soal->id], ['id_user', Auth::user()->id], ['status', 1]])->first();
	$tryCount	= DB::table("jawabs_count")->where([['id_soal', $soal->id], ['id_user', Auth::user()->id]])->first();
	if(!empty($tryCount)){
		$tryCount = $tryCount->try_count;
	} else {
		$tryCount = 0;
	}
	if($check && $tryCount >= 3){
		header("Location: /siswa/ujian/finish/".$soal->id."");
  		exit();
	}
?>
@extends('layouts.app')
@section('title', Auth::user()->nama)
@section('breadcrumb')
<h1>Detail Soal Ujian</h1>
@endsection
@section('content')
<div class="col-md-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">{{ $soal->paket }}</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-sm-12">
					<div id="fsstatus" style="font-size: 14pt; margin: 0 0 20px 0; color: #888c8e"></div>
					<div style="border: dotted #0723e8; padding: 10px; margin-bottom: 15px;">
						<table class="table table-striped">
							<tr>
								<td style="width: 220px">Deskripsi</td>
								<td style="width: 15px">:</td>
								<td>{{ $soal->deskripsi }}</td>
							</tr>
							<tr>
								<td>Jumlah Soal Pilihan Ganda</td>
								<td>:</td>
								<td>{{ $soal->detailSoal ? number_format($soal->detailSoal->count()) : '0' }}</td>
							</tr>
							<tr>
								<td>Waktu</td>
								<td>:</td>
								<td>{{ $soal->waktu.' Detik' }}</td>
							</tr>
						</table>
						<button class="btn btn-success btn-lg btn-block" id="start-exam" onclick="$('#specialstuff').fullScreen(true)">Mulai</button>
					</div>
					<div style="padding:  10px; border: double #fff 15px; color: #fff; background: #b90000;">
						<p style="font-weight: bold;">Silahkan kerjakan soal yang telah disiapkan. Harap dipatuhi peraturan berikut ini!</p>
						<ul>
							<li>Jangan mereload/refresh browser, karena jawaban akan hilang!</li>
							<li>Jangan keluar dari mode fullscreen (jika ujian menggunakan PC/Laptop) atau berpindah ke aplikasi lain (jika menggunakan smartphone), karena ujian akan dianggap selesai dan jawaban akan otomatis dikirimkan.</li>
							<li>Jangan menekan tombol selesai saat mengerjakan soal, kecuali jika Anda telah menyelesaikan seluruh soal.</li>
							<li>Perhatikan sisa waktu ujian, sistem akan mengumpulkan jawaban saat waktu sudah habis.</li>
							<li>Waktu ujian akan dimulai saat tombol "<b>Mulai</b>" diklik.</li>
						</ul>
					</div>
					<!-- <div class="alert alert-success">Silahkan kerjakan soal yang telah disediakan.</div> -->
				</div>
			</div>
		</div>
	</div>
</div>

<!-- tampilkan soal disini -->
<div id="specialstuff" class="row" style="display: none; overflow-y: scroll !important;">
	<!--<div class="row">-->
		<div class="col-sm-8">
			<div class="box box-primary color-palette-box">
				<div class="box-header with-border">
					<h3 class="box-title" style="font-weight:bold;">
						@if($soals->count())
						@foreach($soals as $key_number=>$data_number)
						@if($key_number == 0) <span id="no_soal_detail">1</span> / <span>{{ $soals->count() }}</span> @endif
						@endforeach
						@endif
					</h3>
					<div class="box-tools">
						<span id="timer" style="color: #b90000;font-weight:bold;"></span>
					</div>
				</div>
				<div class="box-body">
					<span id="jumlah_soal" style="display: none;">{{ $soals->count() }}</span>
					<div id="wrap-soal" style="min-height: calc(100vh - 200px);max-height: calc(100vh - 200px);overflow-y:scroll;">
						@if($soals->count())
						@foreach($soals as $key=>$data)
						@if($key == 0)
						<span class="detail_soal_id" id="detail_soal_id" style="display: none;">{{ $data->id }}</span>
						<div class="soal">{!! $data->soal !!}</div>
						{!! $data->pila ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="A/'.$data->id.'/'.Auth::user()->id.'">
							<table width="100%">
								<tr>
									<td width="15px" valign="top"><span>A.</span></td>
									<td valign="top" class="pilihan">'.$data->pila.'</td>
								</tr>
							</table>
						</div>' : '' !!}
						{!! $data->pilb ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="B/'.$data->id.'/'.Auth::user()->id.'">
							<table width="100%">
								<tr>
									<td width="15px" valign="top"><span>B.</span></td>
									<td valign="top" class="pilihan">'.$data->pilb.'</td>
								</tr>
							</table>
						</div>' : '' !!}
						{!! $data->pilc ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="C/'.$data->id.'/'.Auth::user()->id.'">
							<table width="100%">
								<tr>
									<td width="15px" valign="top"><span>C.</span></td>
									<td valign="top" class="pilihan">'.$data->pilc.'</td>
								</tr>
							</table>
						</div>' : '' !!}
						{!! $data->pild ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="D/'.$data->id.'/'.Auth::user()->id.'">
							<table width="100%">
								<tr>
									<td width="15px" valign="top"><span>D.</span></td>
									<td valign="top" class="pilihan">'.$data->pild.'</td>
								</tr>
							</table>
						</div>' : '' !!}
						{!! $data->pile ? '<div class="jawab" soal-id="'.$data->id_soal.'" data-id="'.$data->id.'" data-jawab="E/'.$data->id.'/'.Auth::user()->id.'">
							<table width="100%">
								<tr>
									<td width="15px" valign="top"><span>E.</span></td>
									<td valign="top" class="pilihan">'.$data->pile.'</td>
								</tr>
							</table>
						</div>' : '' !!}
						@endif
						@endforeach
						@endif
					</div>
				</div>
				<div class="box-footer">
					<div class="row">
						<div id="confirm" style="display: none; margin: 15px 0; border: solid thin #aaa; padding: 10px;"></div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<div class="col-md-6" style="padding: 3px;">
								<button type="button" class="btn btn-primary" id="prev"><i class="fa fa-arrow-left" aria-hidden="true"></i> Sebelumnya</button>
								<button type="button" class="btn btn-primary" id="next"><i class="fa fa-arrow-right" aria-hidden="true"></i> Selanjutnya</button>
							</div>
							<div class="col-md-6" style="padding: 3px;">
								<button type="button" class="btn btn-danger" id="keluar"><i class="fa fa-times-circle" aria-hidden="true"></i> Batalkan Ujian</button>
								<button type="button" class="btn btn-success" id="kirim"><i class="fa fa-paper-plane" aria-hidden="true"></i> Selesai</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!--</div>-->
	<!--<div class="row">-->
		<div class="col-sm-4">
			<div class="row">
				<div class="col-sm-12">
					<div class="box box-success color-palette-box">
						<div class="box-body">
							@if($soals->count())
							<!--<span><u><b>Pilihan Ganda</b></u></span>-->
							<nav aria-label="Page navigation">
								<div style="min-height: calc(100vh - 40px);max-height: calc(100vh - 40px);overflow-y:scroll;">
								@foreach($soals as $key_number=>$data_number)
									@if ($key_number % 6 == 0)
										<div class="row">
											<div class="col-sm-12 text-center">
									@endif
												<span class="no_soal" id="{{ 'nav'.$data_number->id }}" data-id="{{ $data_number->id }}" data-no="{{ $key_number+1 }}">
													<a class="btn btn-danger" href="#" style="margin:2px;min-width:50px !important;max-width:50px !important;">{{ $key_number+1 }}</a>
												</span>
									@if (($key_number+1) % 6 == 0)
											</div>
										</div>
									@endif
								@endforeach
								@if($soals->count() % 6 != 0)
									</div>
								@endif
								</div>
								<!--<ul class="pagination" style="margin-top: 5px !important;">
									@foreach($soals as $key_number=>$data_number)
									<li class="no_soal" id="{{ 'nav'.$data_number->id }}" data-id="{{ $data_number->id }}" data-no="{{ $key_number+1 }}"><a href="#" style="width: auto !important;">{{ $key_number+1 }}</a></li>
									@endforeach
								</ul>-->
							</nav>
							@endif

							<!--@if($soal->detail_soal_essays->count())
							<span><u><b>Essay</b></u></span>
							<nav aria-label="Page navigation">
								<ul class="pagination" style="margin-top: 5px !important;">
									@foreach($soal->detail_soal_essays as $key_number => $data_number)
									<li class="no_soal_essay" id="{{ 'nav'.$data_number->id }}" data-id="{{ $data_number->id }}" data-no="{{ $key_number+1 }}"><a href="#" style="width: auto !important;">{{ $key_number+1 }}</a></li>
									@endforeach
								</ul>
							</nav>
							@endif-->
						</div>
					</div>
				</div>
			</div>
		</div>
	<!--</div>-->
</div>
<noscript>
	<style type="text/css">
		#specialstuff {
			display: none;
		}
	</style>
	<div class="noscriptmsg">
		You don't have javascript enabled. Good luck with that.
	</div>
</noscript>
@endsection
@push('css')
<style>
	.soal {
		font-size: 16px;
		line-height: 1.6;
		color: #0f172a;
		margin-bottom: 20px;
		font-weight: 500;
	}

	.jawab {
		cursor: pointer;
		margin-bottom: 12px;
		padding: 14px 18px;
		border-radius: 14px;
		border: 1.5px solid #e2e8f0;
		background: #ffffff;
		transition: all 0.15s ease-in-out;
		font-size: 15px;
		user-select: none;
	}

	.jawab:hover {
		border-color: #94a3b8;
		background: #f8fafc;
	}

	.jawab.dijawab {
		background: #eff6ff !important;
		border-color: #2563eb !important;
		color: #1e3a8a !important;
		font-weight: 600;
		box-shadow: 0 2px 6px -1px rgba(37, 99, 235, 0.15);
	}

	.jawab.dijawab td {
		color: #1e3a8a !important;
	}

	.timer {
		border: 1px solid #334155 !important;
		padding: 6px 16px !important;
		font-size: 15pt !important;
		font-weight: 800 !important;
		color: #f59e0b !important;
		background: #0f172a !important;
		border-radius: 12px !important;
		font-family: 'JetBrains Mono', monospace !important;
		display: inline-block;
	}

	.box-footer {
		border-top: 1px solid #f1f5f9 !important;
	}

	.pilihan p {
		margin: 0;
	}

	.no_soal a {
		border-radius: 10px !important;
		font-weight: 700 !important;
		min-width: 44px !important;
		height: 38px !important;
		line-height: 26px !important;
		transition: all 0.15s ease-in-out;
	}
</style>
@endpush
@push('scripts')
<script src="{{ url('js/jquery.fullscreen-min.js') }}"></script>
<!-- <script src="{{ url('assets/dist/js/sweetalert2.all.min.js') }}"></script> -->
<script>
	var mulaiUjian	= false;
	var submitJawaban = false;
	function mulaiTimer(){
		if(mulaiUjian == false){
			mulaiUjian = true;
			var waktuUjian	= "<?php echo $soal->waktu; ?>";
			var	count		= waktuUjian;

			var x = setInterval(function() {
				count = count - 1;
				if (count == -1) {
					clearInterval(x);
					kirimJawaban();
				}

				var seconds = Math.floor(count);
				var minutes = Math.floor(seconds / 60);
				var hours = Math.floor(minutes / 60);
				seconds %= 60;
				minutes %= 60;
				hours %= 60;

				//$("#timer").html(hours + " Jam " + minutes + " Menit " + seconds + " Detik");
				var formattedTime = hours.toString().padStart(2, '0') + " Jam " + 
                                minutes.toString().padStart(2, '0') + " Menit " +
                                seconds.toString().padStart(2, '0') + " Detik";

            	$("#timer").html(formattedTime);
				checkPrevNext();
			}, 1000);
		}
	}

	function kirimJawaban(){
		var id_soal = "<?php echo $soal->id; ?>";
		submitJawaban = true;
		$.ajax({
			type: "POST",
			url: "{{ url('siswa/ujian/kirim-jawaban') }}",
			data: {
				id_soal: id_soal,
				autoclose: 1
			},
			success: function(data) {
				window.location.href = "{{ url('siswa/ujian/finish/'.$soal->id) }}";
			}
		})
	}

	function checkPrevNext(){
		var current		= parseInt($("#no_soal_detail").text());
		var jumlah_soal = parseInt($("#jumlah_soal").text());
		if(current-1 != 0){
			$("#prev").show();
		} else {
			$("#prev").hide();
		}

		if(current+1 <= jumlah_soal){
			$("#next").show();
		} else {
			$("#next").hide();
		}
	}

	function batalUjian(){
		var id_soal = "<?php echo $soal->id; ?>";
		$.ajax({
			type: "POST",
			url: "{{ url('siswa/ujian/hapus-jawaban') }}",
			data: {
				id_soal: id_soal
			},
			success: function(data) {
				if(data == 1){
					window.location.reload();
				}	
			}
		})
	}


	$("#keluar").click(function(){
		batalUjian();
		$("#specialstuff").fullScreen(false);
		
	});

	$(document).bind("fullscreenchange", function(e) {
		if ($(document).fullScreen()) {
		} else {
			if(submitJawaban == false){
				kirimJawaban();
			}
			$("#specialstuff").hide();
		}
	});

	$(document).on('visibilitychange', function(){
		if(document.hidden) {
			if(submitJawaban == false && mulaiUjian == true){
				kirimJawaban();
			}
		}
	});

	//var countdownTimer = setInterval('timer()', 1000);
	$(document).ready(function() {

		if (typeof(Storage) !== "undefined") {
			// console.log('browser support localstorage');
		} else {
			// swal(
			// 	'Update Browser!',
			// 	'Browser tidak support untuk proses ujian ini!',
			// 	'warning'
			// )
		}

		$(document).on('click', '.no_soal_essay', function() {
			const id_soal_esay = $(this).data('id');
			$.ajax({
				url: "{{ url('siswa/ujian/get-detail-essay') }}",
				type: "GET",
				data: {
					id_soal_esay: id_soal_esay
				},
				success: function(data) {
					$("#wrap-soal").html(data);
				}
			});
		});

		$(document).on('click', '#simpan-essay', function() {
			const jawab_essay = $("#jawab_essay").val();
			const id_soal_esay = $(this).data('id');
			$.ajax({
				type: "GET",
				url: "{{ url('siswa/ujian/simpan-jawaban-essay') }}",
				data: {
					jawab_essay: jawab_essay,
					id_soal_esay: id_soal_esay
				},
				success: function(data) {
					console.log(data);
					if (data == 1) {
						$("#notif-essay").html('Jawaban berhasil disimpan.').show();
					}
				}
			})
		});

		$('.no_soal').click(function() {
			var $this = $(this);
			$('#wrap-soal').html('<center><i class="fa fa-spinner fa-spin" style="font-size: 30pt; color: #12b9cc; margin: 15px;" aria-hidden="true"></i></center>');
			$('#no_soal_detail').html($this.attr('data-no'));
			var id_soal = $this.attr('data-id');
			var id_soal2 = "<?php echo $soal->id; ?>";
			$.ajax({
				type: "POST",
				url: "{{ url('siswa/ujian/get-soal') }}",
				data: {
					id:id_soal,
					id_soal: id_soal2
				},
				success: function(data) {
					$('#wrap-soal').html(data);
				}
			})
		});

		$('#prev').click(function() {
			var prev = parseInt($("#no_soal_detail").text())-1;
			$("*[data-no='"+prev+"']").click();
		});

		$('#next').click(function() {
			var next = parseInt($("#no_soal_detail").text())+1;
			$("*[data-no='"+next+"']").click();
		});

		// ubah status jawab soal
		$('#kirim').click(function() {
			$('#confirm').html(`
				<p>Setelah mengirimkan jawaban, Anda tidak bisa kembali memeriksa jawaban. Apakah Anda yakin?</p>
  			<button type="button" class="btn btn-danger" id="batal"><i class="fa fa-ban" aria-hidden="true"></i> Tidak! Saya Mau Cek Lagi</button>
  			<button type="button" class="btn btn-success" id="kirim-jawaban" data-id="{{ $soal->id }}"><i class="fa fa-check-circle" aria-hidden="true"></i> Ya! Kirimkan Jawaban</button>
			`).show();
		});

		$(document).on('click', '#batal', function() {
			$('#confirm').hide();
		});

		$(document).on('click', '#kirim-jawaban', function() {
			var id_soal = "<?php echo $soal->id; ?>";
			$.ajax({
				type: "POST",
				url: "{{ url('siswa/ujian/kirim-jawaban') }}",
				data: {
					id_soal: id_soal
				},
				success: function(data) {
					window.location.href = "{{ url('siswa/ujian/finish/'.$soal->id) }}";
				}
			})
		});

		var jawab = [];
		var detail_soal_id = [];

		$("#start-exam").click(function() {
			$("#specialstuff").show();
			mulaiTimer();
			mulaiUjian = true;
		});

		$(document).on('click', ".jawab", function() {
			var $this = $(this);
			var get_jawab = $this.attr('data-jawab');
			var id_soal = $this.attr('data-id');
			var container = $this.closest('.opsi-container');
			var tipe = container.length ? container.attr('data-tipe') : 'single';

			if (tipe === 'multi') {
				$this.toggleClass('dijawab');
				var anySelected = container.find('.jawab.dijawab').length > 0;
				if (anySelected) {
					$('#nav' + id_soal).find('a').removeClass("btn-danger").addClass("btn-success");
				} else {
					$('#nav' + id_soal).find('a').removeClass("btn-success").addClass("btn-danger");
				}
			} else {
				$(".jawab").removeClass('dijawab');
				$this.addClass('dijawab');
				$('#nav' + id_soal).find('a').removeClass("btn-danger").addClass("btn-success");
			}

			$.ajax({
				type: "POST",
				url: "{{ url('siswa/ujian/jawab') }}",
				data: {
					get_jawab: get_jawab
				},
				success: function(data) {
					console.log(data);
				}
			});
		});
	});
</script>
@endpush