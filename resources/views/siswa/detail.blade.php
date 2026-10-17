@extends('layouts.app')
@section('title', 'Profil: ' . $siswa->nama . ' - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="w-full py-1">
    <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight">{{ $siswa->nama }}</h1>
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
            Detail Siswa
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">{{ $siswa->nama }}</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            Email: <b>{{ $siswa->email }}</b> &bull; Kelas: {{ $siswa->getKelas ? $siswa->getKelas->nama : 'Umum' }}
          </p>
        </div>
        <div class="flex items-center gap-2">
          <a href="{{ url('/master/siswa') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold border border-white/20 transition flex items-center gap-2">
            <i class="fa fa-arrow-left"></i> Kembali ke Daftar
          </a>
        </div>
      </div>
    </div>

    <!-- MAIN TWO COLUMN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

      <!-- LEFT: PROFILE CARD (1 SPAN) -->
      <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-6">
        <div class="text-center">
          @if($siswa->gambar != '')
            <img class="w-24 h-24 rounded-3xl object-cover mx-auto border-2 border-slate-200 shadow-md" src="{{ url('/assets/img/user/'.$siswa->gambar) }}" alt="Foto Siswa">
          @else
            <div class="w-24 h-24 rounded-3xl bg-slate-900 text-white font-extrabold text-3xl flex items-center justify-center mx-auto shadow-md">
              {{ substr($siswa->nama, 0, 1) }}
            </div>
          @endif
          <h3 class="text-base font-bold text-slate-900 mt-3">{{ $siswa->nama }}</h3>
          <span class="inline-block px-2.5 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200 mt-1">
            {{ $siswa->status == 'G' ? 'Guru' : ($siswa->status == 'A' ? 'Admin' : 'Siswa') }}
          </span>
        </div>

        <div class="space-y-3 pt-4 border-t border-slate-100 text-xs">
          <div class="flex items-center justify-between">
            <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Email</span>
            <span class="text-slate-800 font-semibold truncate max-w-[180px]">{{ $siswa->email }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Jenis Kelamin</span>
            <span class="text-slate-800 font-semibold">{{ $siswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">ID Siswa</span>
            <span class="text-slate-800 font-semibold">#{{ $siswa->id }}</span>
          </div>
        </div>

        <div class="pt-2">
          <a href="{{ url('/master/siswa/edit/'.$siswa->id) }}" class="w-full py-3 px-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm text-center block">
            <i class="fa fa-pencil"></i> Ubah Data Siswa
          </a>
        </div>
      </div>

      <!-- RIGHT: EXAM HISTORY (2 SPAN) -->
      <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
          <div>
            <h3 class="text-lg font-bold text-slate-900">Riwayat Latihan &amp; Skor</h3>
            <p class="text-xs text-slate-500 mt-0.5">Daftar paket tryout yang telah dikerjakan oleh siswa ini.</p>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-striped" style="width: 100%;">
            <thead>
              <tr class="text-slate-600 text-xs font-bold uppercase tracking-wider bg-slate-50">
                <th style="padding: 12px 14px; width: 40px;">#</th>
                <th style="padding: 12px 14px;">Paket Soal</th>
                <th style="padding: 12px 14px; text-align: center; width: 80px;">Nilai</th>
                <th style="padding: 12px 14px; text-align: center; width: 110px;">Tanggal</th>
                <th style="padding: 12px 14px; text-align: center; width: 140px;">Aksi</th>
              </tr>
            </thead>
            <tbody class="text-sm font-medium text-slate-800">
              @if($hasil_ujians->count())
                <?php $no = $hasil_ujians->firstItem(); ?>
                @foreach($hasil_ujians as $hasil_ujian)
                  <tr class="hover:bg-slate-50/70 transition">
                    <td style="padding: 12px 14px; vertical-align: middle;">{{ $no++ }}</td>
                    <td style="padding: 12px 14px; vertical-align: middle;" class="font-bold text-slate-900">{{ $hasil_ujian->paket }}</td>
                    <td style="padding: 12px 14px; text-align: center; vertical-align: middle;" class="font-black text-amber-600 text-base">{{ $hasil_ujian->jumlah_nilai }}</td>
                    <td style="padding: 12px 14px; text-align: center; vertical-align: middle;" class="text-xs text-slate-500">
                      <?php
                        $exp_date = explode(" ", $hasil_ujian->created_at);
                        $exp_date = explode("-", $exp_date[0]);
                        echo $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];
                      ?>
                    </td>
                    <td style="padding: 12px 14px; text-align: center; vertical-align: middle;">
                      <a href="{{ url('/elearning/laporan/'.$hasil_ujian->id_soal.'/'.$hasil_ujian->id_user) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition">
                        Detail
                      </a>
                      <button type="button" class="btn-reset inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-wider transition" data-id="{{ $hasil_ujian->id }}">
                        Reset
                      </button>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="5" class="text-center py-8 text-slate-400">
                    Belum ada riwayat pengerjaan soal oleh siswa ini.
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>

    </div>

  </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
  $('.btn-reset').on('click', function() {
    var id_ujian = $(this).attr('data-id');
    if (confirm('Yakin akan mereset ujian ini? Siswa dapat melakukan latihan ulang dengan soal yang sama.')) {
      $.ajax({
        type: 'POST',
        url: "{{ url('crud/reset-ujian') }}",
        data: {id_ujian:id_ujian},
        success: function(data) {
          alert('Data ujian berhasil direset.');
          window.location.reload();
        }
      });
    }
  });
});
</script>
@endpush