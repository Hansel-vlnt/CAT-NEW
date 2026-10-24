@extends('layouts.app')
@section('title', 'Profil: ' . $siswa->nama . ' - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="w-full py-1">
    <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight" style="line-height: 1.3;">{{ $siswa->nama }}</h1>
  </div>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <style>
    .detail-layout-grid {
      display: grid;
      grid-template-columns: minmax(0, 340px) minmax(0, 1fr);
      gap: 24px;
      align-items: start;
    }
    .detail-layout-grid > * {
      min-width: 0;
    }
    @media (max-width: 991px) {
      .detail-layout-grid {
        grid-template-columns: minmax(0, 1fr);
      }
    }
  </style>

  <div style="width: 100%; max-width: 1200px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">

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
    <div class="detail-layout-grid">

      <!-- LEFT: PROFILE CARD -->
      <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm" style="display: flex; flex-direction: column; gap: 20px;">
        <div class="text-center">
          @if($siswa->gambar != '')
            <img class="w-20 h-20 rounded-2xl object-cover mx-auto border-2 border-slate-200 shadow-md" src="{{ url('/assets/img/user/'.$siswa->gambar) }}" alt="Foto Siswa">
          @else
            <div class="w-20 h-20 rounded-2xl bg-slate-900 text-white font-extrabold text-3xl flex items-center justify-center mx-auto shadow-md">
              {{ substr($siswa->nama, 0, 1) }}
            </div>
          @endif

          <h3 style="font-size: 17px; font-weight: 800; line-height: 1.4; color: #0f172a; margin: 12px 0 6px 0; word-break: break-word;">
            {{ $siswa->nama }}
          </h3>

          <div style="display: flex; align-items: center; justify-content: center; gap: 6px; flex-wrap: wrap;">
            <span style="display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;">
              {{ $siswa->status == 'G' ? 'Guru' : ($siswa->status == 'A' ? 'Admin' : 'Siswa') }}
            </span>
            @if($siswa->isLanggananLes())
              <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;">
                👑 Siswa Les
              </span>
            @else
              <span style="display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                Siswa Reguler
              </span>
            @endif
          </div>
        </div>

        <div style="padding-top: 16px; border-top: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 12px;">
          <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px;">
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; flex-shrink: 0;">Email</span>
            <span style="font-size: 12.5px; font-weight: 600; color: #1e293b; text-align: right; word-break: break-all;">{{ $siswa->email }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px;">
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; flex-shrink: 0;">Jenis Kelamin</span>
            <span style="font-size: 12.5px; font-weight: 600; color: #1e293b; text-align: right;">{{ $siswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px;">
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; flex-shrink: 0;">ID Siswa</span>
            <span style="font-size: 12.5px; font-weight: 700; color: #1e293b; text-align: right; font-family: monospace;">#{{ $siswa->id }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; padding-top: 10px; border-top: 1px dashed #e2e8f0;">
            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; flex-shrink: 0; white-space: nowrap;">Status Member</span>
            <div style="text-align: right; flex-shrink: 0;">
              @if($siswa->isLanggananLes())
                <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; white-space: nowrap;">
                  👑 Siswa Les
                </span>
                @if($siswa->tgl_berakhir_les)
                  <span style="display: block; font-size: 11px; color: #64748b; font-weight: 600; margin-top: 2px; white-space: nowrap;">
                    s/d {{ date('d/m/Y', strtotime($siswa->tgl_berakhir_les)) }}
                  </span>
                @endif
              @else
                <span style="display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 700; background-color: #f8fafc; color: #334155; border: 1px solid #cbd5e1; white-space: nowrap;">
                  Siswa Reguler (Gratis)
                </span>
              @endif
            </div>
          </div>
        </div>

        <div style="padding-top: 8px;">
          <a href="{{ url('/master/siswa/edit/'.$siswa->id) }}" class="w-full py-3 px-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm text-center block">
            <i class="fa fa-pencil"></i> Ubah Data Siswa
          </a>
        </div>
      </div>

      <!-- RIGHT: EXAM HISTORY -->
      <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
          <div>
            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">Riwayat Latihan &amp; Skor</h3>
            <p style="font-size: 13px; color: #64748b; margin: 4px 0 0 0;">Daftar paket tryout yang telah dikerjakan oleh siswa ini.</p>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover table-striped" style="width: 100%;">
            <thead>
              <tr class="text-slate-600 text-xs font-bold uppercase tracking-wider bg-slate-50">
                <th style="padding: 12px 14px; width: 50px;">#</th>
                <th style="padding: 12px 14px;">Paket Soal</th>
                <th style="padding: 12px 14px; text-align: center; width: 90px;">Nilai</th>
                <th style="padding: 12px 14px; text-align: center; width: 120px;">Tanggal</th>
                <th style="padding: 12px 14px; text-align: center; width: 150px;">Aksi</th>
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
                      {{ date('d/m/Y', strtotime($hasil_ujian->created_at)) }}
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

        @if($hasil_ujians->hasPages())
          <div style="margin-top: 20px; display: flex; justify-content: center;">
            {!! $hasil_ujians->render() !!}
          </div>
        @endif
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