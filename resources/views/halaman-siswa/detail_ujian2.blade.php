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
  <div class="w-full">
    <h1 class="text-2xl font-black text-slate-900 mt-0.5">Detail Soal Ujian</h1>
  </div>
@endsection
@section('content')
<div class="col-md-12" id="pre-exam-box">
  <div class="max-w-4xl mx-auto space-y-6">

    <!-- HERO BRIEFING CARD -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-3xl p-6 sm:p-9 shadow-xl">
      <div class="flex items-center gap-2 mb-3">
        <span class="px-3.5 py-1.5 rounded-full bg-blue-600 text-white text-xs sm:text-sm font-bold uppercase tracking-wider">
          Persiapan Latihan (Per Soal)
        </span>
        <span class="px-3.5 py-1.5 rounded-full bg-white/10 text-slate-200 text-xs sm:text-sm font-medium">
          {{ $soal->kategori_utama ?? 'Kedinasan / UTBK' }}
        </span>
      </div>
      <h2 class="text-2xl sm:text-4xl font-extrabold text-white mt-2 leading-tight">{{ $soal->paket }}</h2>
      <p class="text-slate-200 text-sm sm:text-base mt-2.5 leading-relaxed">
        {{ $soal->deskripsi ?: 'Simulasi latihan dengan batas waktu per nomor.' }}
      </p>

      <!-- SPECS GRID -->
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-7 pt-7 border-t border-white/15">
        <div class="bg-white/10 rounded-2xl p-4 sm:p-5 border border-white/15">
          <div class="text-xs sm:text-sm text-slate-300 font-medium">Jumlah Butir</div>
          <div class="text-2xl sm:text-3xl font-black text-amber-400 mt-1">
            {{ $soal->detailSoal ? number_format($soal->detailSoal->count()) : '0' }} Soal
          </div>
        </div>
        <div class="bg-white/10 rounded-2xl p-4 sm:p-5 border border-white/15">
          <div class="text-xs sm:text-sm text-slate-300 font-medium">Waktu Per Butir</div>
          <div class="text-2xl sm:text-3xl font-black text-amber-400 mt-1">
            {{ $soal->waktu }} Detik / Soal
          </div>
        </div>
        <div class="bg-white/10 rounded-2xl p-4 sm:p-5 border border-white/15 col-span-2 sm:col-span-1">
          <div class="text-xs sm:text-sm text-slate-300 font-medium">Target KKM</div>
          <div class="text-2xl sm:text-3xl font-black text-emerald-400 mt-1">
            {{ $soal->kkm ?? 70 }}
          </div>
        </div>
      </div>
    </div>

    <!-- PETUNJUK PENGERJAAN -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-9 shadow-sm space-y-6">
      <h3 class="text-xl sm:text-2xl font-black text-slate-900 pb-4 border-b border-slate-200 flex items-center gap-3">
        <i class="fa fa-shield text-blue-600 text-2xl"></i> Petunjuk &amp; Peraturan Pengerjaan
      </h3>

      <div class="p-6 rounded-2xl bg-amber-50/90 border-2 border-amber-300 text-slate-900 leading-relaxed space-y-3.5 shadow-sm">
        <div class="font-bold text-base sm:text-lg flex items-center gap-2.5 text-amber-950">
          <i class="fa fa-exclamation-triangle text-amber-600 text-xl"></i> Harap Dipatuhi Selama Latihan Berlangsung:
        </div>
        <ul class="list-disc pl-6 space-y-3 text-sm sm:text-base font-medium text-slate-800 leading-relaxed">
          <li>Setiap nomor memiliki alokasi waktu tersendiri yang akan berpindah otomatis saat timer habis.</li>
          <li>Sesi latihan dan jawaban Anda tersimpan otomatis. Jika halaman termuat ulang (refresh), ujian akan melanjutkan nomor terakhir.</li>
          <li>Gunakan tombol pilihan untuk menyimpan jawaban Anda sebelum melanjutkan ke nomor berikutnya.</li>
        </ul>
      </div>

      <div class="pt-2">
        <button class="w-full py-4.5 sm:py-5 px-6 rounded-2xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-black text-lg sm:text-xl shadow-lg hover:shadow-xl transition tracking-wide flex items-center justify-center gap-3" id="start-exam">
          <i class="fa fa-play-circle text-2xl"></i> Mulai Latihan Sekarang &rarr;
        </button>
      </div>
    </div>

  </div>
</div>

<!-- tampilkan soal disini -->
<div id="specialstuff" class="row" style="display: none; overflow-y: scroll !important;">
	<!--<div class="row">-->
		<div class="col-sm-12">
			<div class="box box-primary color-palette-box">
				<div class="box-header with-border">
					<h3 class="box-title" style="font-weight:bold;">
						Soal No.
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
					<div id="wrap-soal" style="min-height: calc(100vh - 140px);max-height: calc(100vh - 140px);overflow-y:scroll;">
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

						<div style="margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
							@if($data->tipe_soal == 'multi')
								<span class="label label-warning" style="font-size: 13px; padding: 5px 10px; border-radius: 6px; font-weight: 600;">
									<i class="fa fa-check-square-o"></i> Pilihan Ganda Kompleks (Bisa pilih lebih dari 1 jawaban)
								</span>
							@elseif($data->tipe_soal == 'tkp')
								<span class="label label-info" style="font-size: 13px; padding: 5px 10px; border-radius: 6px; font-weight: 600;">
									<i class="fa fa-sliders"></i> Soal TKP (Skala Skor 1 - 5)
								</span>
							@else
								<span class="label label-default" style="font-size: 13px; padding: 5px 10px; border-radius: 6px; font-weight: 600;">
									<i class="fa fa-dot-circle-o"></i> Pilihan Ganda (Pilih 1 jawaban terbaik)
								</span>
							@endif
							<span style="font-size: 13px; font-weight: 700; color: #475569;">Bobot: {{ $data->score }} Poin</span>
						</div>

						<div class="soal" style="font-size: 17px; line-height: 1.7; color: #0f172a; margin-bottom: 22px; font-weight: 500;">
							{!! $data->soal !!}
						</div>

						<div class="opsi-container" data-tipe="{{ $data->tipe_soal ?? 'single' }}" style="display: flex; flex-direction: column; gap: 12px;">
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
													<span class="huruf-opsi" style="font-size: 16px; font-weight: 700; color: #1e293b;">{{ $huruf }}.</span>
												</td>
												<td valign="top" class="pilihan" style="padding-top: 1px; font-size: 16px; line-height: 1.6; color: #1e293b;">
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
						<div class="col-md-12 text-right">
							<div class="col-md-8">
							</div>
							<div class="col-md-4 text-right">
								<button type="button" class="btn btn-success" id="kirim"><i class="fa fa-paper-plane" aria-hidden="true"></i> Selesai</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!--</div>-->
	<!--<div class="row">-->
		<div class="hidden">
			<div class="row">
				<div class="col-sm-12">
					<div class="box box-success color-palette-box">
						<div class="box-header with-border">
							<h3 class="box-title">Navigasi Soal</h3>
						</div>
						<div class="box-body">
							@if($soals->count())
							<!--<span><u><b>Pilihan Ganda</b></u></span>-->
							<nav aria-label="Page navigation">
								<div style="min-height: calc(100vh - 80px);max-height: calc(100vh - 80px);overflow-y:scroll;">
								@foreach($soals as $key_number=>$data_number)
									@if ($key_number % 6 == 0)
										<div class="row text-center">
									@endif
											<div class="col-sm-2">
												<span class="no_soal" id="{{ 'nav'.$data_number->id }}" data-id="{{ $data_number->id }}" data-no="{{ $key_number+1 }}">
													<a class="btn btn-danger" href="#">{{ $key_number+1 }}</a>
												</span>
											</div>
									@if (($key_number+1) % 6 == 0)
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
	#specialstuff {
		background-color: #f8fafc;
		min-height: 100vh;
	}

	.soal, .soal p, .soal span, .soal div {
		font-size: 16px !important;
		line-height: 1.7 !important;
		color: #0f172a;
	}
	@media (min-width: 640px) {
		.soal, .soal p, .soal span, .soal div {
			font-size: 18px !important;
			line-height: 1.75 !important;
		}
	}

	.jawab {
		cursor: pointer;
		margin-bottom: 12px;
		padding: 14px 16px;
		border-radius: 14px;
		border: 1.5px solid #cbd5e1;
		background: #ffffff;
		transition: all 0.15s ease-in-out;
		user-select: none;
	}
	@media (min-width: 640px) {
		.jawab {
			padding: 16px 20px;
		}
	}

	.huruf-opsi {
		font-size: 15px;
		font-weight: 700;
		color: #1e293b;
	}
	@media (min-width: 640px) {
		.huruf-opsi {
			font-size: 16px;
		}
	}

	.pilihan, .pilihan p, .pilihan span, .pilihan div {
		font-size: 15px !important;
		line-height: 1.6 !important;
		color: #1e293b;
	}
	@media (min-width: 640px) {
		.pilihan, .pilihan p, .pilihan span, .pilihan div {
			font-size: 16px !important;
			line-height: 1.65 !important;
		}
	}

	.timer {
		border: 1px solid #334155 !important;
		padding: 8px 18px !important;
		font-size: 16pt !important;
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

	.no_soal {
		display: inline-block !important;
		margin: 2px !important;
	}

	.no_soal a {
		display: inline-flex !important;
		align-items: center !important;
		justify-content: center !important;
		text-align: center !important;
		border-radius: 10px !important;
		font-weight: 700 !important;
		width: 44px !important;
		min-width: 44px !important;
		max-width: 44px !important;
		height: 44px !important;
		padding: 0 !important;
		line-height: 1 !important;
		font-size: 15px !important;
		transition: all 0.15s ease-in-out;
		text-decoration: none !important;
		box-sizing: border-box !important;
	}
</style>
@endpush
@push('scripts')
<script src="{{ url('js/jquery.fullscreen-min.js') }}"></script>
<script>
	var mulaiUjian = false;
	var submitJawaban = false;
	var isUnloading = false;
	var hasEnteredFullscreen = false;
	var violationStrikes = 0;
	var timerInterval = null;

	var activeKey = 'cbt_exam_v2_active_{{ $soal->id }}';
	var currentNoKey = 'cbt_exam_v2_current_no_{{ $soal->id }}';
	var qEndKey = 'cbt_exam_v2_q_end_{{ $soal->id }}';

	localStorage.removeItem('cbt_exam_active_{{ $soal->id }}');
	localStorage.removeItem('cbt_exam_current_no_{{ $soal->id }}');
	localStorage.removeItem('cbt_exam_q_end_{{ $soal->id }}');

	function clearExamStorage() {
		if (timerInterval) {
			clearInterval(timerInterval);
			timerInterval = null;
		}
		localStorage.removeItem(activeKey);
		localStorage.removeItem(currentNoKey);
		localStorage.removeItem(qEndKey);
		localStorage.removeItem('cbt_exam_active_{{ $soal->id }}');
		localStorage.removeItem('cbt_exam_current_no_{{ $soal->id }}');
		localStorage.removeItem('cbt_exam_q_end_{{ $soal->id }}');
	}

	function resetQuestionTimer(customSec) {
		var waktuPerSoal = parseInt("<?php echo $soal->waktu; ?>", 10) || 60;
		var duration = (customSec !== undefined && customSec !== null) ? customSec : waktuPerSoal;
		var endTime = Date.now() + (duration * 1000);
		localStorage.setItem(qEndKey, endTime.toString());
		return endTime;
	}

	function mulaiTimer(customSec){
		mulaiUjian = true;
		if (timerInterval) {
			clearInterval(timerInterval);
		}

		var storedEndTime = parseInt(localStorage.getItem(qEndKey), 10);
		if (!storedEndTime || isNaN(storedEndTime) || customSec !== undefined) {
			storedEndTime = resetQuestionTimer(customSec);
		}

		function updateTick() {
			var now = Date.now();
			var remaining = Math.max(0, Math.floor((storedEndTime - now) / 1000));

			var current = parseInt($("#no_soal_detail").text()) || 1;
			var next = current + 1;
			var jumlah_soal = parseInt($("#jumlah_soal").text()) || 1;

			if (remaining <= 0) {
				if (current >= jumlah_soal) {
					clearInterval(timerInterval);
					timerInterval = null;
					kirimJawaban();
					return;
				} else {
					var nextBtn = $("*[data-no='" + next + "']");
					if (nextBtn.length) {
						nextBtn.click();
					}
					storedEndTime = resetQuestionTimer();
					return;
				}
			}

			var seconds = remaining;
			var minutes = Math.floor(seconds / 60);
			var hours = Math.floor(minutes / 60);
			seconds %= 60;
			minutes %= 60;
			hours %= 60;

			var formattedTime = hours.toString().padStart(2, '0') + " Jam " + 
								minutes.toString().padStart(2, '0') + " Menit " +
								seconds.toString().padStart(2, '0') + " Detik";

			$("#timer").html(formattedTime);
		}

		updateTick();
		timerInterval = setInterval(updateTick, 1000);
	}

	function kirimJawaban(){
		var id_soal = "<?php echo $soal->id; ?>";
		submitJawaban = true;
		clearExamStorage();
		$.ajax({
			type: "POST",
			url: "{{ url('siswa/ujian/kirim-jawaban') }}",
			data: {
				id_soal: id_soal,
				autoclose: 1
			},
			success: function(data) {
				window.location.replace("{{ url('siswa/ujian/finish/'.$soal->id) }}");
			},
			error: function() {
				window.location.replace("{{ url('siswa/ujian/finish/'.$soal->id) }}");
			}
		});
	}

	function batalUjian(){
		var id_soal = "<?php echo $soal->id; ?>";
		submitJawaban = true;
		clearExamStorage();
		$.ajax({
			type: "POST",
			url: "{{ url('siswa/ujian/hapus-jawaban') }}",
			data: {
				id_soal: id_soal
			},
			success: function(data) {
				window.location.reload();
			},
			error: function() {
				window.location.reload();
			}
		});
	}

	function handleViolation(reason) {
		if (isUnloading || submitJawaban || !mulaiUjian) return;
		violationStrikes++;
		if (violationStrikes === 1) {
			if (typeof Swal !== 'undefined') {
				Swal.fire({
					target: '#specialstuff',
					title: 'Peringatan Integritas!',
					text: 'Terdeteksi ' + reason + '. Harap tetap berada di tampilan ujian. Pelanggaran berikutnya akan otomatis mengirim lembar ujian.',
					type: 'warning',
					confirmButtonColor: '#2563eb',
					confirmButtonText: 'Kembali Latihan'
				}).then(function() {
					try {
						$("#specialstuff").fullScreen(true);
					} catch (err) {}
				});
			} else {
				alert('Peringatan: Harap tetap berada di layar ujian!');
			}
		} else {
			kirimJawaban();
			$("#specialstuff").hide();
		}
	}

	window.addEventListener('beforeunload', function(e) {
		if (mulaiUjian && !submitJawaban) {
			isUnloading = true;
			var msg = 'Ujian sedang berlangsung! Waktu pengerjaan akan tetap berjalan. Apakah Anda yakin ingin memuat ulang halaman?';
			e.preventDefault();
			e.returnValue = msg;
			return msg;
		}
	});


	$(document).bind("fullscreenchange", function(e) {
		if ($(document).fullScreen()) {
			hasEnteredFullscreen = true;
		} else if (hasEnteredFullscreen && mulaiUjian && !submitJawaban && !isUnloading) {
			handleViolation('keluar dari mode fullscreen');
		}
	});

	$(document).on('visibilitychange', function(){
		if (document.hidden && mulaiUjian && !submitJawaban && !isUnloading) {
			handleViolation('berpindah tab / aplikasi');
		}
	});

	window.addEventListener('pageshow', function(event) {
		if (event.persisted) {
			window.location.reload();
		}
	});

	$(document).ready(function() {
		// Periksa apakah sesi ujian per nomor sedang aktif (setelah reload)
		var isExamActive = localStorage.getItem(activeKey) === '1';
		var storedQEndTime = parseInt(localStorage.getItem(qEndKey), 10);

		if (isExamActive) {
			var remaining = 0;
			if (storedQEndTime) {
				remaining = Math.floor((storedQEndTime - Date.now()) / 1000);
			}
			var waktuPerSoal = parseInt("<?php echo $soal->waktu; ?>", 10) || 60;
			var resumeSec = remaining > 0 ? remaining : waktuPerSoal;

			$("#pre-exam-box").hide();
			$("#specialstuff").show();
			mulaiTimer(resumeSec);

			var savedNo = parseInt(localStorage.getItem(currentNoKey), 10);
			if (savedNo && savedNo > 1) {
				var targetNav = $("*[data-no='" + savedNo + "']");
				if (targetNav.length) {
					targetNav.click();
				}
			}
		} else {
			clearExamStorage();
		}

		$('.no_soal').click(function() {
			var $this = $(this);
			var no = $this.attr('data-no');
			localStorage.setItem(currentNoKey, no);
			resetQuestionTimer();
			mulaiTimer();

			$('#wrap-soal').html('<center><i class="fa fa-spinner fa-spin" style="font-size: 30pt; color: #12b9cc; margin: 15px;" aria-hidden="true"></i></center>');
			$('#no_soal_detail').html(no);
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
				}
			});
		});

		$('#kirim').click(function() {
			kirimJawaban();
		});

		$("#start-exam").click(function() {
			clearExamStorage();
			localStorage.setItem(activeKey, '1');
			localStorage.setItem(currentNoKey, '1');
			resetQuestionTimer();

			$('.jawab').removeClass('dijawab');
			$('#no_soal_detail').html('1');

			$.ajax({
				type: "POST",
				url: "{{ url('siswa/ujian/hapus-jawaban') }}",
				data: { id_soal: "<?php echo $soal->id; ?>" }
			});

			$("#pre-exam-box").hide();
			$("#specialstuff").show();
			try {
				$("#specialstuff").fullScreen(true);
				hasEnteredFullscreen = true;
			} catch (e) {}
			mulaiTimer();
		});

		$(document).on('click', ".jawab", function() {
			var $this = $(this);
			var get_jawab = $this.attr('data-jawab');
			var id_soal = $this.attr('data-id');

			$(".jawab").removeClass('dijawab');
			$this.addClass('dijawab');

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