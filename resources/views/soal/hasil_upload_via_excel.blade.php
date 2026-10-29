@extends('layouts.app')
@section('title', 'Hasil Import Soal - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="w-full py-1">
    <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight">Hasil Import Butir Soal</h1>
  </div>
@endsection
@section('content')
<div class="col-md-12">
  <div class="max-w-xl mx-auto space-y-6">

    <!-- RESULT CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm text-center">
      <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-2xl mx-auto mb-4 border border-emerald-200">
        <i class="fa fa-file-excel-o"></i>
      </div>

      <h2 class="text-xl font-extrabold text-slate-900 mb-1">Import Berkas Selesai</h2>
      <p class="text-xs text-slate-500 mb-6">Berikut ringkasan hasil pemrosesan berkas spreadsheet yang diunggah.</p>

      <div class="grid grid-cols-3 gap-3 mb-6">
        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200 text-center">
          <div class="text-[11px] font-bold text-slate-500 uppercase">Total Baris</div>
          <div class="text-xl font-black text-slate-900 mt-0.5">{{ number_format($jumlah, 0, '.', '.') }}</div>
        </div>
        <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-center">
          <div class="text-[11px] font-bold text-emerald-700 uppercase">Sukses</div>
          <div class="text-xl font-black text-emerald-600 mt-0.5">{{ number_format($sukses, 0, '.', '.') }}</div>
        </div>
        <div class="p-3 rounded-2xl bg-red-50 border border-red-200 text-center">
          <div class="text-[11px] font-bold text-red-700 uppercase">Gagal</div>
          <div class="text-xl font-black text-red-600 mt-0.5">{{ number_format($gagal, 0, '.', '.') }}</div>
        </div>
      </div>

      @if(!empty($kesalahan))
        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-900 text-left mb-6 leading-relaxed">
          {!! $kesalahan !!}
        </div>
      @endif

      <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-center gap-3">
        @if(!empty($target_id_soal))
          <a href="{{ url('/elearning/soal/detail/' . $target_id_soal) }}" class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm flex items-center gap-2" style="color: #ffffff !important;">
            <i class="fa fa-arrow-left"></i>
            <span>Lihat Paket Soal Ini</span>
          </a>
        @endif
        <a href="{{ url('/elearning/soal') }}" class="px-6 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition">
          Semua Paket Soal &rarr;
        </a>
      </div>
    </div>

  </div>
</div>
@endsection