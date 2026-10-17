@extends('layouts.app')
@section('title', "Materi Belajar - Latihan Soal Abdi Praja")
@section('breadcrumb')
  <div class="w-full">
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">Modul &amp; Materi Pembelajaran</h1>
  </div>
@endsection
@section('content')
<div class="col-md-12">
  <div class="max-w-6xl mx-auto space-y-6">

    <!-- HERO WELCOME BANNER -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-lg">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
            Halo, {{ Auth::user()->nama }}!
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">Pusat Belajar &amp; Materi Referensi</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            Pelajari modul rangkuman materi SKD Kedinasan dan UTBK-SNBT sebelum mencoba simulasi latihan soal.
          </p>
        </div>
        <div class="flex items-center gap-2">
          <a href="{{ url('siswa/ujian') }}" class="px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-md flex items-center gap-2">
            <i class="fa fa-play-circle"></i> Buka Katalog Soal &rarr;
          </a>
        </div>
      </div>
    </div>

    <!-- MATERI TABLE CARD (FULL WIDTH) -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
        <div>
          <h3 class="text-xl font-bold text-slate-900 tracking-tight">Materi &amp; Panduan Belajar</h3>
          <p class="text-sm text-slate-500 mt-1">Pilih salah satu judul materi untuk membaca modul lengkap.</p>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover table-striped" id="table_soal" style="width: 100%;">
          <thead>
            <tr class="text-slate-600 text-xs font-bold uppercase tracking-wider bg-slate-50">
              <th style="padding: 14px 16px;">Judul Materi</th>
              <th style="padding: 14px 16px; text-align: center; width: 130px;">Aksi</th>
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
  $('#table_soal').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    pageLength: 10,
    language: {
      search: "Cari materi:",
      lengthMenu: "Tampilkan _MENU_ per halaman",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ materi",
      paginate: {
        first: "Awal",
        last: "Akhir",
        next: "Lanjut",
        previous: "Sebelum"
      }
    },
    ajax: {
      url: '{!! route('siswa.materi') !!}',
    },
    columns: [
      {data: 'judul', name: 'judul', orderable: true, searchable: true },
      {data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" },
    ],
    drawCallback: function (setting) {}
  });
});
</script>
@endpush