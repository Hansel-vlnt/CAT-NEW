@extends('layouts.app')
@section('title', 'Hasil Import Siswa - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="w-full py-1">
    <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight">Hasil Import Siswa</h1>
  </div>
@endsection
@section('content')
<div class="col-md-12">
  <div class="max-w-xl mx-auto space-y-6">

    <!-- RESULT CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm text-center">
      <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-2xl mx-auto mb-4 border border-emerald-200">
        <i class="fa fa-check-circle"></i>
      </div>

      <h2 class="text-xl font-extrabold text-slate-900 mb-1">Data Siswa Berhasil Diimport!</h2>
      <p class="text-xs text-slate-500 mb-6">Seluruh baris akun siswa dari berkas spreadsheet telah berhasil dimasukkan ke sistem database.</p>

      <div class="pt-4 border-t border-slate-100 flex items-center justify-center gap-3">
        <a href="{{ url('/master/siswa') }}" class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm">
          Buka Daftar Siswa &rarr;
        </a>
      </div>
    </div>

  </div>
</div>
@endsection