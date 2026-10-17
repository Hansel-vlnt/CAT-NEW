@extends('layouts.app')
@section('title', '404 - Halaman Tidak Ditemukan - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="w-full max-w-xl py-1">
    <div class="text-xs text-slate-500 font-bold uppercase tracking-wider">Navigasi Platform</div>
    <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight">Halaman Tidak Ditemukan</h1>
  </div>
@endsection
@section('content')
<div class="col-md-12">
  <div class="w-full max-w-xl space-y-6">

    <!-- 404 CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-sm text-center">
      <div class="w-20 h-20 rounded-3xl bg-amber-50 text-amber-500 flex items-center justify-center font-black text-3xl mx-auto mb-6 border border-amber-200 shadow-sm">
        404
      </div>

      <h2 class="text-2xl font-extrabold text-slate-900 mb-2">Halaman Tidak Ditemukan</h2>
      <p class="text-sm text-slate-500 leading-relaxed max-w-md mx-auto mb-8">
        Halaman atau modul latihan yang Anda tuju mungkin telah dipindahkan, sedang dalam persiapan, atau alamat URL yang Anda masukkan kurang tepat.
      </p>

      <div class="flex items-center justify-center gap-3 flex-wrap">
        <a href="{{ url('/') }}" class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm flex items-center gap-2">
          <i class="fa fa-home"></i> Kembali ke Beranda
        </a>
        <button onclick="self.history.back()" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition flex items-center gap-2">
          <i class="fa fa-arrow-left"></i> Halaman Sebelumnya
        </button>
      </div>
    </div>

  </div>
</div>
@endsection