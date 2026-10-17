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

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

      <!-- LEFT: MATERI TABLE CARD (2 SPAN) -->
      <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
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

      <!-- RIGHT: SHORTCUTS (1 SPAN) -->
      <div>
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm space-y-5">
          <h4 class="flex items-center gap-2.5 pb-4 border-b border-slate-100" style="font-size: 20px !important; font-weight: 800 !important; color: #0f172a !important; margin: 0;">
            <i class="fa fa-compass text-indigo-600" style="font-size: 22px;"></i>
            <span>Menu Cepat Siswa</span>
          </h4>
          <div class="space-y-4">
            <a href="{{ url('siswa/ujian') }}" class="rounded-2xl border border-slate-200 hover:border-indigo-400 hover:bg-indigo-50/50 hover:shadow-sm transition flex items-center justify-between group" style="padding: 16px 18px !important; text-decoration: none !important;">
              <div class="flex items-center gap-4">
                <div class="rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center font-bold shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition" style="width: 52px; height: 52px; font-size: 22px;">
                  <i class="fa fa-pencil"></i>
                </div>
                <div>
                  <div class="group-hover:text-indigo-600 transition tracking-tight" style="font-size: 17px !important; font-weight: 800 !important; color: #0f172a; line-height: 1.3;">Katalog Latihan Soal</div>
                  <div style="font-size: 14px !important; font-weight: 500 !important; color: #64748b; margin-top: 3px;">Kerjakan paket tryout</div>
                </div>
              </div>
              <i class="fa fa-chevron-right text-slate-300 group-hover:text-indigo-600 group-hover:translate-x-1 transition" style="font-size: 16px;"></i>
            </a>

            <a href="{{ url('/pengaturan') }}" class="rounded-2xl border border-slate-200 hover:border-emerald-400 hover:bg-emerald-50/50 hover:shadow-sm transition flex items-center justify-between group" style="padding: 16px 18px !important; text-decoration: none !important;">
              <div class="flex items-center gap-4">
                <div class="rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center font-bold shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition" style="width: 52px; height: 52px; font-size: 22px;">
                  <i class="fa fa-user"></i>
                </div>
                <div>
                  <div class="group-hover:text-emerald-600 transition tracking-tight" style="font-size: 17px !important; font-weight: 800 !important; color: #0f172a; line-height: 1.3;">Profil &amp; Akun</div>
                  <div style="font-size: 14px !important; font-weight: 500 !important; color: #64748b; margin-top: 3px;">Pengaturan data kamu</div>
                </div>
              </div>
              <i class="fa fa-chevron-right text-slate-300 group-hover:text-emerald-600 group-hover:translate-x-1 transition" style="font-size: 16px;"></i>
            </a>
          </div>
        </div>
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