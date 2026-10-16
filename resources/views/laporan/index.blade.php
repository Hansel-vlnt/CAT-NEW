@extends('layouts.app')
@section('title', 'Laporan Hasil Latihan - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="px-4 py-2">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Evaluasi &bull; Bank Soal</div>
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">Laporan &amp; Rekap Nilai</h1>
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
          <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
            Rekapitulasi Hasil Latihan
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">Laporan Nilai Per Paket Soal</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            Pilih paket soal untuk melihat daftar nilai siswa, analisis butir, dan cetak laporan PDF.
          </p>
        </div>
        <div class="bg-white/10 backdrop-blur px-5 py-4 rounded-2xl border border-white/10 shrink-0 text-center sm:text-right">
          <div class="text-xs text-slate-300 font-medium">Total Paket Soal</div>
          <div class="text-3xl font-black text-amber-400 mt-0.5">{{ $soal->count() }}</div>
        </div>
      </div>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
        <div>
          <h3 class="text-lg font-bold text-slate-900">Daftar Paket Latihan</h3>
          <p class="text-xs text-slate-500 mt-0.5">Klik tombol detail pada paket untuk melihat peserta dan skor pengerjaan.</p>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover table-striped" id="table_detail" style="width: 100%;">
          <thead>
            <tr class="text-slate-600 text-xs font-bold uppercase tracking-wider bg-slate-50">
              <th style="padding: 14px 16px;">Nama Paket Soal</th>
              <th style="padding: 14px 16px; text-align: center; width: 140px;">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-sm font-medium text-slate-800">
            @foreach($soal as $s)
              <tr class="hover:bg-slate-50/70 transition">
                <td style="padding: 14px 16px; vertical-align: middle;">
                  <div class="font-bold text-slate-900 text-base">{{ $s->paket }}</div>
                  <div class="text-xs text-slate-500 mt-0.5">{{ $s->deskripsi ?: 'Tanpa deskripsi khusus' }}</div>
                </td>
                <td style="padding: 14px 16px; text-align: center; vertical-align: middle;">
                  <a href="/elearning/laporan/paket/{{ $s->id }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm">
                    <i class="fa fa-folder-open-o"></i> Lihat Nilai
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
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
    responsive: true,
    lengthChange: true,
    pageLength: 10,
    language: {
      search: "Cari paket:",
      lengthMenu: "Tampilkan _MENU_ per halaman",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ paket",
      paginate: {
        first: "Awal",
        last: "Akhir",
        next: "Lanjut",
        previous: "Sebelum"
      }
    }
  });
});
</script>
@endpush