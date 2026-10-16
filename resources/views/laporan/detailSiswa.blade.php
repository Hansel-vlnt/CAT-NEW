@extends('layouts.app')
@section('title', 'Detail Lembar Jawaban: ' . $siswa->nama . ' - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="px-4 py-2">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Laporan &bull; Lembar Jawaban Siswa</div>
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">{{ $siswa->nama }}</h1>
  </div>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="max-w-6xl mx-auto space-y-6">

    <!-- HERO PROFILE & SCORECARD -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-lg">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
            Lembar Hasil Siswa
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">{{ $siswa->nama }}</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            Paket: <b>{{ $soal->paket }}</b> &bull; Waktu Selesai: {{ timeStampIndo($hasil_ujian->created_at) }}
          </p>
        </div>

        <div class="flex items-center gap-6 bg-white/10 backdrop-blur p-4 rounded-2xl border border-white/10 shrink-0">
          <div>
            <div class="text-xs text-slate-300 font-medium">Total Skor</div>
            <div class="text-3xl sm:text-4xl font-black text-amber-400 mt-0.5">
              {{ ($hasil_ujian->jumlah_nilai + $nilai_essay) }}
            </div>
          </div>
          <div class="h-10 w-px bg-white/20"></div>
          <div>
            <div class="text-xs text-slate-300 font-medium">Status Pengerjaan</div>
            <div class="mt-0.5">
              @if($hasil_ujian->status == 1)
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                  Selesai
                </span>
              @else
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                  Sedang Berlangsung
                </span>
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="mt-6 flex items-center gap-3 flex-wrap pt-6 border-t border-white/10">
        <a href="{{ url('/elearning/laporan/paket/'.$soal->id) }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold border border-white/20 transition flex items-center gap-2">
          <i class="fa fa-arrow-left"></i> Kembali ke Daftar Siswa
        </a>
        <a href="/cetak/pdf/hasil-ujian-persiswa/{{ $siswa->id }}/{{ $soal->id }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-md transition flex items-center gap-2">
          <i class="fa fa-file-pdf-o"></i> Unduh / Cetak Laporan PDF
        </a>
      </div>
    </div>

    <!-- DETAIL TABLE CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
        <div>
          <h3 class="text-lg font-bold text-slate-900">Rincian Butir Jawaban Siswa</h3>
          <p class="text-xs text-slate-500 mt-0.5">Periksa soal, kunci resmi, pilihan siswa, dan skor per butir.</p>
        </div>
      </div>

      <div class="table-responsive">
        <table id="table_hasil_ujian" class="table table-hover table-striped" style="width: 100%;">
          <thead>
            <tr class="text-slate-600 text-xs font-bold uppercase tracking-wider bg-slate-50">
              <th style="padding: 14px 16px;">Soal</th>
              <th style="padding: 14px 16px; width: 120px; text-align: center;">Kunci</th>
              <th style="padding: 14px 16px; width: 120px; text-align: center;">Jawaban</th>
              <th style="padding: 14px 16px; width: 100px; text-align: center;">Skor</th>
            </tr>
          </thead>
        </table>
      </div>
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
$(document).ready(function() {
  $('#table_hasil_ujian').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    pageLength: 20,
    language: {
      search: "Cari butir:",
      lengthMenu: "Tampilkan _MENU_ per halaman",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ butir",
      paginate: {
        first: "Awal",
        last: "Akhir",
        next: "Lanjut",
        previous: "Sebelum"
      }
    },
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
        className: "text-center font-bold text-emerald-700"
      },
      {
        data: 'pilihan',
        name: 'pilihan',
        orderable: true,
        searchable: true,
        className: "text-center font-bold"
      },
      {
        data: 'score',
        name: 'score',
        orderable: true,
        searchable: true,
        className: "text-center font-bold"
      },
    ],
    drawCallback: function(setting) {}
  });
});
</script>
@endpush