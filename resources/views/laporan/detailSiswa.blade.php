@extends('layouts.app')
@section('title', $siswa->nama)
@section('breadcrumb')
<h1>Laporan</h1>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-12">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Detail Jawaban Siswa</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<table style="background: #e6ebf2" class="table table-condensed table-bordered table-striped">
						<tr>
							<td>Nama siswa</td>
							<td>{{ $siswa->nama }}</td>
						</tr>
						<tr>
							<td>Paket soal</td>
							<td>{{ $soal->paket }}</td>
						</tr>
						<tr>
							<td>Waktu ujian</td>
							<td>{{ timeStampIndo($hasil_ujian->created_at) }}</td>
						</tr>
						<tr>
							<td>Status ujian</td>
							<td>
								@if($hasil_ujian->status == 1)
								<label class="label label-info">Selesai</label>
								@else
								<label class="label label-warning">Sedang berlangsung</label>
								@endif
							</td>
						</tr>
						<tr>
							<td>Nilai</td>
							<td><b>{{ ($hasil_ujian->jumlah_nilai + $nilai_essay) }}</b></td>
						</tr>
						<tr>
							<td>Download Laporan</td>
							<td><a href="/cetak/pdf/hasil-ujian-persiswa/{{ $siswa->id }}/{{ $soal->id }}" target="_blank">PDF</a></td>
						</tr>
					</table>

					@if($hasil_ujian->status == 1)
					{{-- <a target="_blank" href="{{ url('/cetak/pdf/hasil-ujian-persiswa/'.$siswa->id.'/'.$soal->id) }}" class="btn btn-warning btn-md" data-toggle='tooltip' title="Cetak laporan hasil ujian paket soal {{ $soal->paket }} untuk siswa an. {{ $siswa->nama }}"><i class="fa fa-file-pdf-o"></i> Cetak Laporan</a> --}}
					@endif
				</div>
			</div>
			<hr>
			<h4>Soal Pilihan Ganda</h4>
			<hr style="margin: 4px 0 5px">
			<table id="table_hasil_ujian" class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>Soal</th>
						<th>Kunci</th>
						<th>Jawaban</th>
						<th>Nilai</th>
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
	function delay(callback, ms) {
		var timer = 0;
		return function() {
			var context = this,
				args = arguments;
			clearTimeout(timer);
			timer = setTimeout(function() {
				callback.apply(context, args);
			}, ms || 0);
		};
	}


	$(document).ready(function() {
		table_hasil_ujian = $('#table_hasil_ujian').DataTable({
			processing: true,
			serverSide: true,
			responsive: true,
			lengthChange: true,

			ajax: {
				url: "{!! route('elearning.hasilSiswa') !!}",
				data: {
					"id_user": '{{ $siswa->id }}',
					"id_soal": '{{ $soal->id }}'
				},
			},
			columns: [
				{
					data: 'dataSoal',
					name: 'dataSoal',
					orderable: true,
					searchable: true
				},
				{
					data: 'kunci',
					name: 'kunci',
					orderable: true,
					searchable: true,
				},
				{
					data: 'pilihan',
					name: 'pilihan',
					orderable: true,
					searchable: true,
				},
				{
					data: 'score',
					name: 'score',
					orderable: true,
					searchable: true,
				},
			],
			"drawCallback": function(setting) {}
		});

		/*$(document).on('keyup', '.nilai-essay', delay(function() {
			const essay_id = $(this).data('id');
			const id_user = $(this).data('user');
			const score = $(this).val();
			$.ajax({
				type: "GET",
				url: "{{ url('elearning/soal/essay/simpan-score') }}",
				data: {
					essay_id: essay_id,
					id_user: id_user,
					score: score
				},
				success: function(data) {
					console.log(data);

				}
			})
		}, 500));*/
	});
</script>
@endpush