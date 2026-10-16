@extends('layouts.app')
@section('title', 'Hasil Siswa: ' . $soal->paket . ' - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="px-4 py-2">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Laporan &bull; Paket Soal</div>
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">{{ $soal->paket }}</h1>
  </div>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="max-w-6xl mx-auto space-y-6">

    <!-- HERO HEADER -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-lg">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
              Rekap Hasil Siswa
            </span>
            <span class="px-3 py-1 rounded-full bg-white/10 text-slate-200 text-xs font-medium">
              ID #{{ $soal->id }}
            </span>
          </div>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">{{ $soal->paket }}</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            {{ $soal->deskripsi ?: 'Daftar seluruh siswa yang telah menyelesaikan paket latihan ini.' }}
          </p>
        </div>
        <div class="flex items-center gap-2">
          <a href="{{ url('/elearning/laporan') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold border border-white/20 transition flex items-center gap-2">
            <i class="fa fa-arrow-left"></i> Kembali ke Rekap
          </a>
        </div>
      </div>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
        <div>
          <h3 class="text-lg font-bold text-slate-900">Peserta yang Mengerjakan</h3>
          <p class="text-xs text-slate-500 mt-0.5">Pilih tombol aksi untuk melihat lembar jawaban detail atau evaluasi siswa.</p>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover table-striped" id="table_detail" style="width: 100%;">
          <thead>
            <tr class="text-slate-600 text-xs font-bold uppercase tracking-wider bg-slate-50">
              <th style="padding: 14px 16px;">Nama Siswa</th>
              <th style="padding: 14px 16px; width: 150px; text-align: center;">Total Nilai</th>
              <th style="padding: 14px 16px; text-align: center; width: 140px;">Aksi</th>
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
$(document).ready(function (){
  $('#table_detail').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    pageLength: 10,
    language: {
      search: "Cari siswa:",
      lengthMenu: "Tampilkan _MENU_ per halaman",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ siswa",
      paginate: {
        first: "Awal",
        last: "Akhir",
        next: "Lanjut",
        previous: "Sebelum"
      }
    },
    ajax: {
      url: '{!! route('elearning.laporan.data_kelas_paket_soal') !!}',
      data: {"id_soal": '{{ $soal->id }}'},
    },
    columns: [
      {data: 'nama', name: 'nama', orderable: true, searchable: true },
      {data: 'jumlah_nilai', name: 'jumlah_nilai', orderable: true, searchable: true, className: "text-center font-bold" },
      {data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" },
    ],
    drawCallback: function (setting) {}
  });
});
</script>
@endpush