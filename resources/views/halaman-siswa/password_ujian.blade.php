@extends('layouts.app')
@section('title', 'Verifikasi Password Ujian')
@section('breadcrumb')
  <div class="w-full py-1">
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
      <a href="{{ url('/siswa/ujian') }}" class="hover:text-indigo-600 transition">Paket Ujian</a>
      <span>/</span>
      <span class="text-slate-800">Verifikasi Akses</span>
    </div>
    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Verifikasi Akses Paket Soal</h1>
  </div>
@endsection

@section('content')
<div class="col-xs-12">
  <div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-xl">
      <!-- Icon & Header -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 text-3xl mb-4 shadow-sm">
          <i class="fa fa-lock"></i>
        </div>
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">Paket Soal Terkunci</h2>
        <p class="text-base text-slate-600 mt-2 leading-relaxed max-w-md mx-auto">
          Paket latihan ini memerlukan kode akses dari instruktur pengawas. Masukkan password soal untuk membuka dan memulai simulasi ujian CBT.
        </p>
      </div>

      <!-- Verification Form -->
      <form method="post" id="password_soal" class="space-y-6">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ Request::segment(4) }}">

        <div>
          <label for="password" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2.5 text-center">
            Password / Token Paket Soal
          </label>
          <div class="relative">
            <input type="password" class="form-control text-center font-mono font-bold tracking-widest text-2xl" name="password" id="password" placeholder="••••••••" autocomplete="off" required style="height: 58px !important; font-size: 24px !important; border-radius: 14px !important;">
          </div>
          <p class="text-sm text-slate-500 mt-2.5 text-center flex items-center justify-center gap-2">
            <i class="fa fa-info-circle text-indigo-500 text-base"></i>
            <span>Tanyakan password paket soal kepada pengawas bimbingan belajar Anda.</span>
          </p>
        </div>

        <div class="pt-2">
          <button type="submit" class="w-full h-[58px] rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-bold text-lg shadow-lg shadow-indigo-500/25 transition duration-150 flex items-center justify-center gap-2 cursor-pointer" id="aktivasi">
            <span>Buka Paket &amp; Mulai Ujian</span>
            <i class="fa fa-arrow-right text-base"></i>
          </button>
        </div>

        <div class="text-center pt-4 border-t border-slate-100">
          <a href="{{ url('/siswa/ujian') }}" class="inline-flex items-center gap-2 text-base font-semibold text-slate-600 hover:text-indigo-600 transition">
            <i class="fa fa-arrow-left text-sm"></i>
            <span>Kembali ke Katalog Paket Soal</span>
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@if(Session::has('success'))
  <script>
    swal("", '{!! Session::get("success") !!}', "success");
  </script>
@endif
@if(Session::has('error'))
  <script>
    swal("", '{!! Session::get("error") !!}', "error");
  </script>
@endif
@endpush