@extends('layouts.app')
@section('title', 'Aktivitas Pengguna - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="px-4 py-2">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Log Sistem &bull; Monitoring</div>
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">Aktivitas Terkini</h1>
  </div>
@endsection
@section('content')
<div class="col-md-12">
  <div class="max-w-6xl mx-auto space-y-6">

    <!-- HERO BANNER -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-lg">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
            Feed Audit &bull; Latihan Soal Abdi Praja
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">Catatan Aktivitas Platform</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            Riwayat pengerjaan latihan, login, dan aktivitas pengguna terkini secara real-time.
          </p>
        </div>
        <div class="bg-white/10 backdrop-blur px-5 py-3 rounded-2xl border border-white/10 shrink-0 text-center sm:text-right">
          <div class="text-xs text-slate-300 font-medium">Total Log Entri</div>
          <div class="text-2xl font-black text-amber-400 mt-0.5">{{ $aktifitas->count() }} Aktivitas</div>
        </div>
      </div>
    </div>

    <!-- MAIN TWO COLUMN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
      
      <!-- KOLOM KIRI (2 SPAN): TIMELINE FEED -->
      <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <h3 class="text-lg font-bold text-slate-900 mb-6 pb-4 border-b border-slate-100 flex items-center gap-2">
          <i class="fa fa-history text-blue-600"></i> Riwayat Kegiatan Terakhir
        </h3>

        <div class="space-y-4">
          @if($aktifitas->count())
            @foreach($aktifitas as $data_aktifitas)
              <div class="p-4 rounded-2xl border border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 transition flex items-start gap-4">
                <div class="shrink-0">
                  @if(!empty($data_aktifitas->dataAktifitasUser->gambar))
                    <img class="w-12 h-12 rounded-full object-cover border border-slate-200 shadow-sm" src="{{ url('/assets/img/user/'.$data_aktifitas->dataAktifitasUser->gambar) }}" alt="Avatar">
                  @else
                    <div class="w-12 h-12 rounded-full bg-slate-900 text-white font-bold flex items-center justify-center text-sm shadow-sm">
                      {{ substr($data_aktifitas->dataAktifitasUser->nama ?? 'U', 0, 1) }}
                    </div>
                  @endif
                </div>

                <div class="flex-1 min-w-0">
                  <div class="flex flex-wrap items-center justify-between gap-1 mb-1">
                    <span class="font-bold text-slate-900 text-sm">
                      {{ $data_aktifitas->dataAktifitasUser->nama ?? 'Pengguna' }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium">
                      {{ $data_aktifitas->created_at->diffForHumans() }}
                    </span>
                  </div>
                  <p class="text-sm text-slate-700 leading-relaxed m-0 font-medium">
                    {{ $data_aktifitas->nama }}
                  </p>
                </div>
              </div>
            @endforeach
          @else
            <div class="text-center py-12 text-slate-400">
              <i class="fa fa-clock-o text-3xl mb-2"></i>
              <p>Belum ada rekaman aktivitas terkini.</p>
            </div>
          @endif
        </div>
      </div>

      <!-- KOLOM KANAN (1 SPAN): INFORMASI PANEL -->
      <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
        <h4 class="text-base font-bold text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
          <i class="fa fa-info-circle text-blue-600"></i> Informasi Sistem
        </h4>
        <p class="text-xs text-slate-600 leading-relaxed">
          Log ini mencatat seluruh peristiwa interaksi siswa maupun administrator terhadap paket latihan soal, input nilai, dan perubahan akun.
        </p>
        <div class="p-4 rounded-2xl bg-blue-50 border border-blue-100 text-xs text-blue-900 font-medium leading-relaxed">
          Semua catatan waktu mengikuti zona waktu server dan diperbarui otomatis setiap kali ada tindakan baru yang dilakukan.
        </div>
      </div>

    </div>

  </div>
</div>
@endsection