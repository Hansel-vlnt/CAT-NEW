@extends('layouts.app')
@section('title', $materi->judul . ' - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="px-4 py-2">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Materi Belajar &bull; Detail Modul</div>
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">{{ $materi->judul }}</h1>
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
            Modul Pembelajaran
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">{{ $materi->judul }}</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            Penulis: <b>{{ $materi->getUser->nama ?? 'Instruktur Abdi Praja' }}</b> &bull; Terbit: {{ timeStampIndo($materi->created_at) }}
          </p>
        </div>
        <div>
          <button onclick="self.history.back()" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold border border-white/20 transition flex items-center gap-2">
            <i class="fa fa-arrow-left"></i> Kembali ke Daftar
          </button>
        </div>
      </div>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
      
      <!-- LEFT: ARTICLE CONTENT (2 SPAN) -->
      <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        @if(!empty($materi->gambar))
          <div class="mb-6 rounded-2xl overflow-hidden border border-slate-200 shadow-sm max-h-96">
            <img src="{{ url('/assets/img/materi/'.$materi->gambar) }}" class="w-full h-auto object-cover" alt="Header Materi">
          </div>
        @endif

        <div class="prose max-w-none text-slate-800 text-base leading-relaxed font-normal">
          {!! $materi->isi !!}
        </div>

        <div class="mt-8 pt-6 border-t border-slate-100 flex items-center gap-3">
          <button class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider transition" onclick="self.history.back()">
            <i class="fa fa-reply"></i> Kembali
          </button>
          <a href="{{ url('siswa/ujian') }}" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition">
            Uji Pemahaman dengan Latihan Soal &rarr;
          </a>
        </div>
      </div>

      <!-- RIGHT: METADATA PANEL (1 SPAN) -->
      <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
        <h4 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
          <i class="fa fa-info-circle text-blue-600"></i> Informasi Dokumen
        </h4>

        <div class="space-y-3 text-xs text-slate-600">
          <div>
            <div class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">Penulis</div>
            <div class="text-slate-900 font-semibold text-sm mt-0.5">{{ $materi->getUser->nama ?? 'Admin' }}</div>
          </div>
          <div>
            <div class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">Tanggal Terbit</div>
            <div class="text-slate-800 font-medium mt-0.5">{{ timeStampIndo($materi->created_at) }}</div>
          </div>
          <div>
            <div class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">Terakhir Diperbarui</div>
            <div class="text-slate-800 font-medium mt-0.5">{{ timeStampIndo($materi->updated_at) }}</div>
          </div>
          <div>
            <div class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">Total Dibaca</div>
            <div class="text-slate-800 font-medium mt-0.5">{{ number_format($materi->hits, 0, '.', '.') }} kali</div>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>
@endsection