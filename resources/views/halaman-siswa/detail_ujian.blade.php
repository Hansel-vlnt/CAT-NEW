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
<div class="col-md-12" id="pre-exam-box">
  <div class="max-w-3xl mx-auto space-y-6">

    <!-- HERO BRIEFING CARD -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl">
      <div class="flex items-center gap-2 mb-2">
        <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
          Persiapan Latihan
        </span>
        <span class="px-3 py-1 rounded-full bg-white/10 text-slate-200 text-xs font-medium">
          {{ $soal->kategori_utama ?? 'Kedinasan / UTBK' }}
        </span>
      </div>
      <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">{{ $soal->paket }}</h2>
      <p class="text-slate-300 text-xs sm:text-sm mt-1">
        {{ $soal->deskripsi ?: 'Simulasi latihan soal dengan timer real-time dan evaluasi kunci jawaban.' }}
      </p>

      <!-- SPECS GRID -->
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
        <div class="bg-white/5 rounded-2xl p-4 border border-white/10">
          <div class="text-xs text-slate-300 font-medium">Jumlah Butir</div>
          <div class="text-2xl font-black text-amber-400 mt-0.5">
            {{ $soal->detailSoal ? number_format($soal->detailSoal->count()) : '0' }} Soal
          </div>
        </div>
        <div class="bg-white/5 rounded-2xl p-4 border border-white/10">
          <div class="text-xs text-slate-300 font-medium">Durasi Pengerjaan</div>
          <div class="text-2xl font-black text-amber-400 mt-0.5">
            {{ round($soal->waktu / 60) }} Menit
          </div>
        </div>
        <div class="bg-white/5 rounded-2xl p-4 border border-white/10 col-span-2 sm:col-span-1">
          <div class="text-xs text-slate-300 font-medium">Target Passing Grade</div>
          <div class="text-2xl font-black text-emerald-400 mt-0.5">
            KKM {{ $soal->kkm ?? 70 }}
          </div>
        </div>
      </div>
    </div>

    <!-- PETUNJUK PENGERJAAN -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-4">
      <h3 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
        <i class="fa fa-shield text-blue-600"></i> Petunjuk &amp; Peraturan Pengerjaan
      </h3>

      <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-900 leading-relaxed space-y-2">
        <div class="font-bold flex items-center gap-1.5 text-amber-800">
          <i class="fa fa-exclamation-triangle"></i> Harap Dipatuhi Selama Latihan Berlangsung:
        </div>
        <ul class="list-disc pl-5 space-y-1 text-slate-700">
          <li>Jangan me-refresh atau menutup browser saat pengerjaan agar progres jawaban tidak hilang.</li>
          <li>Waktu hitung mundur berjalan otomatis sejak Anda menekan tombol <b>Mulai Latihan Sekarang</b>.</li>
          <li>Gunakan panel nomor soal di sebelah kanan untuk melompat antar nomor secara bebas.</li>
          <li>Setelah waktu habis atau Anda menekan tombol Selesai, nilai dan <b>pembahasan trik cepat</b> akan otomatis ditampilkan.</li>
        </ul>
      </div>

      <div class="pt-2">
        <button class="w-full py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-base shadow-lg transition tracking-wide flex items-center justify-center gap-2" id="start-exam" onclick="$('#specialstuff').fullScreen(true)">
          <i class="fa fa-play-circle"></i> Mulai Latihan Sekarang &rarr;
        </button>
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
						<?php
							$jawab_siswa = '';
							$multi_jawabs = [];
							if ($data->checkJawab) {
								$jawab_siswa = $data->checkJawab->pilihan;
								if ($data->tipe_soal == 'multi') {
									$decoded = json_decode($data->checkJawab->jawaban_multi, true);
									$multi_jawabs = is_array($decoded) ? $decoded : explode(',', $jawab_siswa);
								}
							}
						?>
						<span class="detail_soal_id" id="detail_soal_id" style="display: none;">{{ $data->id }}</span>

						<div style="margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
							@if($data->tipe_soal == 'multi')
								<span class="label label-warning" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
									<i class="fa fa-check-square-o"></i> Pilihan Ganda Kompleks (Bisa pilih lebih dari 1 jawaban)
								</span>
							@elseif($data->tipe_soal == 'tkp')
								<span class="label label-info" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
									<i class="fa fa-sliders"></i> Soal TKP (Skala Skor 1 - 5)
								</span>
							@else
								<span class="label label-default" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
									<i class="fa fa-dot-circle-o"></i> Pilihan Ganda (Pilih 1 jawaban terbaik)
								</span>
							@endif
							<span style="font-size: 12px; font-weight: 600; color: #64748b;">Bobot: {{ $data->score }} Poin</span>
						</div>

						<div class="soal" style="font-size: 16px; line-height: 1.7; color: #0f172a; margin-bottom: 20px;">
							{!! $data->soal !!}
						</div>

						<div class="opsi-container" data-tipe="{{ $data->tipe_soal ?? 'single' }}" style="display: flex; flex-direction: column; gap: 10px;">
							<?php
								$opsi = [
									'A' => $data->pila,
									'B' => $data->pilb,
									'C' => $data->pilc,
									'D' => $data->pild,
									'E' => $data->pile,
								];
							?>

							@foreach($opsi as $huruf => $teks)
								@if(!empty($teks))
									<?php
										$is_selected = false;
										if ($data->tipe_soal == 'multi') {
											$is_selected = in_array($huruf, $multi_jawabs);
										} else {
											$is_selected = ($jawab_siswa == $huruf);
										}
									?>
									<div class="jawab {{ $is_selected ? 'dijawab' : '' }}"
										soal-id="{{ $data->id_soal }}"
										data-id="{{ $data->id }}"
										data-opsi="{{ $huruf }}"
										data-jawab="{{ $huruf.'/'.$data->id.'/'.Auth::user()->id }}">
										<table width="100%">
											<tr>
												<td width="36px" valign="top">
													<span class="huruf-opsi">{{ $huruf }}.</span>
												</td>
												<td valign="top" class="pilihan" style="padding-top: 1px;">
													{!! $teks !!}
												</td>
											</tr>
										</table>
									</div>
								@endif
							@endforeach
						</div>
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
						<div class="col-md-12" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
							<div style="display: flex; gap: 8px; flex-wrap: wrap;">
								<button type="button" class="btn btn-primary" id="prev"><i class="fa fa-arrow-left" aria-hidden="true"></i> Sebelumnya</button>
								<button type="button" class="btn btn-warning" id="btn-ragu"><i class="fa fa-flag-o" aria-hidden="true"></i> Ragu-ragu</button>
								<button type="button" class="btn btn-primary" id="next"><i class="fa fa-arrow-right" aria-hidden="true"></i> Selanjutnya</button>
							</div>
							<div style="display: flex; gap: 8px; flex-wrap: wrap;">
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
							<div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
								<span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Navigasi Nomor Soal</span>
								<div class="flex items-center gap-2 text-xs">
									<span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span> Terjawab</span>
									<span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-amber-400 inline-block"></span> Ragu</span>
									<span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-slate-200 inline-block border"></span> Kosong</span>
								</div>
							</div>
							<nav aria-label="Page navigation">
								<div style="min-height: calc(100vh - 80px);max-height: calc(100vh - 80px);overflow-y:scroll;">
								@foreach($soals as $key_number=>$data_number)
									<?php
										$sudah_dijawab = ($data_number->checkJawab && !empty($data_number->checkJawab->pilihan));
									?>
									@if ($key_number % 6 == 0)
										<div class="row">
											<div class="col-sm-12 text-center">
									@endif
												<span class="no_soal" id="{{ 'nav'.$data_number->id }}" data-id="{{ $data_number->id }}" data-no="{{ $key_number+1 }}">
													<a class="btn {{ $sudah_dijawab ? 'btn-success' : 'btn-default' }} num-btn {{ $key_number == 0 ? 'active-num' : '' }}" href="#" style="margin:2px;min-width:46px !important;max-width:46px !important; font-weight:bold;">{{ $key_number+1 }}</a>
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
							</nav>
							@endif
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

	.no_soal a.btn-default {
		background: #f8fafc !important;
		border: 1.5px solid #cbd5e1 !important;
		color: #334155 !important;
	}
	.no_soal a.btn-default:hover {
		background: #e2e8f0 !important;
		border-color: #94a3b8 !important;
	}
	.no_soal a.btn-success {
		background: #10b981 !important;
		border: 1.5px solid #059669 !important;
		color: #ffffff !important;
	}
	.no_soal a.btn-warning {
		background: #f59e0b !important;
		border: 1.5px solid #d97706 !important;
		color: #ffffff !important;
	}
	.no_soal a.active-num {
		box-shadow: 0 0 0 3px #2563eb !important;
		border-color: #2563eb !important;
	}
</style>
@endpush
@push('scripts')
<script src="{{ url('js/jquery.fullscreen-min.js') }}"></script>
<script src="{{ url('assets/dist/js/sweetalert2.all.min.js') }}"></script>
<script>
	var mulaiUjian	= false;
	var submitJawaban = false;
	var violationStrikes = 0;

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
		});
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
		});
	}

	function handleViolation(reason) {
		if (submitJawaban || !mulaiUjian) return;
		violationStrikes++;
		if (violationStrikes === 1) {
			if (typeof Swal !== 'undefined') {
				Swal.fire({
					title: 'Peringatan Integritas!',
					text: 'Terdeteksi ' + reason + '. Harap tetap berada di tampilan ujian. Pelanggaran berikutnya akan otomatis mengirim lembar ujian.',
					icon: 'warning',
					confirmButtonColor: '#2563eb',
					confirmButtonText: 'Kembali Latihan'
				}).then(function() {
					$("#specialstuff").fullScreen(true);
				});
			} else {
				alert('Peringatan: Harap tetap berada di layar ujian!');
			}
		} else {
			kirimJawaban();
			$("#specialstuff").hide();
		}
	}

	$("#keluar").click(function(){
		if (typeof Swal !== 'undefined') {
			Swal.fire({
				title: 'Batalkan Latihan Soal?',
				text: 'Seluruh progres dan jawaban yang belum dikirim akan dibatalkan. Apakah Anda yakin?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#ef4444',
				cancelButtonColor: '#64748b',
				confirmButtonText: 'Ya, Batalkan Latihan',
				cancelButtonText: 'Lanjutkan Latihan'
			}).then(function(result) {
				if (result.isConfirmed) {
					batalUjian();
					$("#specialstuff").fullScreen(false);
				}
			});
		} else if (confirm('Apakah Anda yakin ingin membatalkan ujian? Semua jawaban sementara akan dihapus.')) {
			batalUjian();
			$("#specialstuff").fullScreen(false);
		}
	});

	$(document).bind("fullscreenchange", function(e) {
		if (!$(document).fullScreen() && mulaiUjian && !submitJawaban) {
			handleViolation('keluar dari mode fullscreen');
		}
	});

	$(document).on('visibilitychange', function(){
		if (document.hidden && mulaiUjian && !submitJawaban) {
			handleViolation('berpindah tab / aplikasi');
		}
	});

	function refreshRaguState() {
		$('.no_soal').each(function() {
			var id = $(this).attr('data-id');
			if (localStorage.getItem('ragu_{{$soal->id}}_' + id) === '1') {
				$(this).find('a').removeClass('btn-default btn-success').addClass('btn-warning');
			}
		});
	}

	function updateActiveNav(num) {
		$('.no_soal a').removeClass('active-num');
		var navSpan = $("*[data-no='" + num + "']");
		navSpan.find('a').addClass('active-num');
		var curId = navSpan.attr('data-id');
		if (curId && localStorage.getItem('ragu_{{$soal->id}}_' + curId) === '1') {
			$("#btn-ragu").html('<i class="fa fa-flag"></i> Hapus Ragu');
		} else {
			$("#btn-ragu").html('<i class="fa fa-flag-o"></i> Ragu-ragu');
		}
	}

	$(document).ready(function() {
		refreshRaguState();
		updateActiveNav(1);

		$("#btn-ragu").click(function() {
			var curNo = parseInt($("#no_soal_detail").text()) || 1;
			var navSpan = $("*[data-no='" + curNo + "']");
			var curId = navSpan.attr('data-id');
			if (!curId) return;

			var key = 'ragu_{{$soal->id}}_' + curId;
			var isRagu = localStorage.getItem(key) === '1';
			var navBtn = navSpan.find('a');
			var isAnswered = $('.jawab.dijawab').length > 0;

			if (isRagu) {
				localStorage.removeItem(key);
				navBtn.removeClass('btn-warning');
				if (isAnswered) {
					navBtn.addClass('btn-success');
				} else {
					navBtn.addClass('btn-default');
				}
				$(this).html('<i class="fa fa-flag-o"></i> Ragu-ragu');
			} else {
				localStorage.setItem(key, '1');
				navBtn.removeClass('btn-default btn-success').addClass('btn-warning');
				$(this).html('<i class="fa fa-flag"></i> Hapus Ragu');
			}
		});

		$('.no_soal').click(function() {
			var $this = $(this);
			var no = $this.attr('data-no');
			$('#wrap-soal').html('<center><i class="fa fa-spinner fa-spin" style="font-size: 30pt; color: #12b9cc; margin: 15px;" aria-hidden="true"></i></center>');
			$('#no_soal_detail').html(no);
			updateActiveNav(no);
			var id_soal = $this.attr('data-id');
			var id_soal2 = "<?php echo $soal->id; ?>";
			$.ajax({
				type: "POST",
				url: "{{ url('siswa/ujian/get-soal') }}",
				data: {
					id: id_soal,
					id_soal: id_soal2
				},
				success: function(data) {
					$('#wrap-soal').html(data);
					if (typeof renderMathInElement === 'function') {
						renderMathInElement(document.getElementById('wrap-soal'), {
							delimiters: [
								{left: '$$', right: '$$', display: true},
								{left: '$', right: '$', display: false}
							],
							throwOnError: false
						});
					}
				}
			});
		});

		$('#prev').click(function() {
			var prev = parseInt($("#no_soal_detail").text()) - 1;
			$("*[data-no='" + prev + "']").click();
		});

		$('#next').click(function() {
			var next = parseInt($("#no_soal_detail").text()) + 1;
			$("*[data-no='" + next + "']").click();
		});

		$('#kirim').click(function() {
			$('#confirm').html(`
				<p class="font-bold text-slate-800 mb-2">Setelah mengirimkan jawaban, latihan selesai dan nilai langsung keluar. Apakah Anda yakin?</p>
  			<button type="button" class="btn btn-default" id="batal"><i class="fa fa-arrow-left"></i> Cek Kembali</button>
  			<button type="button" class="btn btn-success" id="kirim-jawaban" data-id="{{ $soal->id }}"><i class="fa fa-check-circle"></i> Ya, Kumpulkan Jawaban</button>
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
			});
		});

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
				var isRagu = localStorage.getItem('ragu_{{$soal->id}}_' + id_soal) === '1';
				if (!isRagu) {
					if (anySelected) {
						$('#nav' + id_soal).find('a').removeClass("btn-default btn-danger").addClass("btn-success");
					} else {
						$('#nav' + id_soal).find('a').removeClass("btn-success btn-danger").addClass("btn-default");
					}
				}
			} else {
				$(".jawab").removeClass('dijawab');
				$this.addClass('dijawab');
				var isRagu = localStorage.getItem('ragu_{{$soal->id}}_' + id_soal) === '1';
				if (!isRagu) {
					$('#nav' + id_soal).find('a').removeClass("btn-default btn-danger").addClass("btn-success");
				}
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