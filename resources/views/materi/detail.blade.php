@extends('layouts.app')
@section('title', 'Detail Materi: ' . $materi->judul . ' - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="w-full max-w-5xl">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">E-Learning &bull; Materi</div>
    <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight">{{ $materi->judul }}</h1>
  </div>
@endsection

@section('content')
<div class="col-md-12">
  <div class="w-full max-w-5xl space-y-6">

    <!-- COMPACT ACTION HEADER -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <div class="flex items-center gap-2 mb-1.5">
          <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $materi->status == 'Y' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
            {{ $materi->status == 'Y' ? 'Diterbitkan' : 'Draft' }}
          </span>
          <span class="text-xs text-slate-400">&bull; Dibaca {{ $materi->hits }} kali</span>
        </div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">{{ $materi->judul }}</h2>
      </div>
      <div class="flex items-center gap-2 flex-wrap">
        <a href="{{ url('/elearning/materi/ubah/' . $materi->id) }}" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm flex items-center gap-1.5">
          <i class="fa fa-edit"></i> Ubah Materi
        </a>
        <a href="{{ url('/elearning/materi') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition flex items-center gap-1.5">
          <i class="fa fa-arrow-left"></i> Kembali
        </a>
      </div>
    </div>

    <!-- MATERI CONTENT CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm">
      @if(!empty($materi->gambar))
        <div class="mb-8 rounded-2xl overflow-hidden border border-slate-200 shadow-sm max-h-96">
          <img src="{{ url('/assets/img/materi/' . $materi->gambar) }}" class="w-full h-auto object-cover" alt="Header Materi">
        </div>
      @endif

      <div class="prose max-w-none text-slate-800 text-base leading-relaxed font-normal">
        {!! $materi->isi !!}
      </div>

      <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
        <span>Dibuat pada: {{ $materi->created_at }}</span>
        <span>Terakhir diperbarui: {{ $materi->updated_at }}</span>
      </div>
    </div>

  </div>
</div>
@endsection
