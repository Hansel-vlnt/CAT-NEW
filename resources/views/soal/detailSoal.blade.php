@extends('layouts.app')
@section('title', 'Detail Soal #' . $soal->id)
@section('breadcrumb')
  <div class="w-full flex flex-col sm:flex-row sm:items-center justify-between gap-3 py-1">
    <div>
      <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight"><i class="fa fa-file-text-o text-indigo-600 mr-1.5"></i> Detail Soal #{{ $soal->id }}</h1>
    </div>
    <a href="{{ url('elearning/soal/detail/'.$soal->id_soal) }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition flex items-center gap-2 shadow-sm">
      <i class="fa fa-arrow-left"></i> Kembali ke Paket
    </a>
  </div>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="max-w-5xl mx-auto space-y-6">
    <div class="box box-primary" style="border-top-width: 3px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
      <div class="box-header with-border" style="padding: 16px 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
          <div style="display: flex; align-items: center; gap: 8px;">
            <span class="label label-primary" style="font-size: 13px; padding: 4px 10px; border-radius: 4px;">ID Soal: #{{ $soal->id }}</span>
            @if($soal->tipe_soal == 'multi')
              <span class="label label-warning" style="font-size: 13px; padding: 4px 10px; border-radius: 4px;"><i class="fa fa-check-square-o"></i> Pilihan Ganda Kompleks / Multi</span>
            @elseif($soal->tipe_soal == 'tkp')
              <span class="label label-info" style="font-size: 13px; padding: 4px 10px; border-radius: 4px;"><i class="fa fa-sliders"></i> TKP Berbobot</span>
            @else
              <span class="label label-default" style="font-size: 13px; padding: 4px 10px; border-radius: 4px;"><i class="fa fa-dot-circle-o"></i> Pilihan Ganda Standar</span>
            @endif

            @if ($soal->status == 'Y')
              <span class="label label-success" style="font-size: 13px; padding: 4px 10px; border-radius: 4px;"><i class="fa fa-check"></i> Aktif</span>
            @else
              <span class="label label-danger" style="font-size: 13px; padding: 4px 10px; border-radius: 4px;"><i class="fa fa-ban"></i> Non-Aktif</span>
            @endif
          </div>
          <div>
            <span style="font-weight: 600; color: #475569;">Bobot Skor: <span style="color: #0f172a; font-size: 16px;">{{ $soal->score }} Poin</span></span>
          </div>
        </div>
      </div>

      <div class="box-body" style="padding: 24px;">
        <!-- Teks Soal -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
          <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b; margin-bottom: 8px; letter-spacing: 0.5px;">
            Pertanyaan / Butir Soal
          </div>
          <div style="font-size: 15px; line-height: 1.7; color: #1e293b;">
            {!! $soal->soal !!}
          </div>
        </div>

        <!-- Pilihan Opsi A - E -->
        <div style="margin-bottom: 24px;">
          <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #64748b; margin-bottom: 12px; letter-spacing: 0.5px;">
            Pilihan Jawaban & Kunci
          </div>
          <?php
            $opsi = [
              'A' => $soal->pila,
              'B' => $soal->pilb,
              'C' => $soal->pilc,
              'D' => $soal->pild,
              'E' => $soal->pile,
            ];
            $kunci_arr = [];
            if ($soal->tipe_soal == 'multi') {
              $decoded = json_decode($soal->kunci, true);
              $kunci_arr = is_array($decoded) ? $decoded : explode(',', $soal->kunci);
            } else {
              $kunci_arr = [$soal->kunci];
            }
          ?>
          <div style="display: flex; flex-direction: column; gap: 10px;">
            @foreach($opsi as $huruf => $teks)
              @if(!empty($teks))
                <?php $is_kunci = in_array($huruf, $kunci_arr); ?>
                <div style="display: flex; align-items: flex-start; gap: 14px; padding: 14px 18px; border-radius: 8px; border: 1px solid {{ $is_kunci ? '#10b981' : '#e2e8f0' }}; background: {{ $is_kunci ? '#ecfdf5' : '#ffffff' }}; transition: all 0.2s;">
                  <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; font-weight: 700; font-size: 13px; flex-shrink: 0; background: {{ $is_kunci ? '#10b981' : '#e2e8f0' }}; color: {{ $is_kunci ? '#ffffff' : '#334155' }};">
                    {{ $huruf }}
                  </span>
                  <div style="flex-grow: 1; font-size: 14px; line-height: 1.6; color: #1e293b; padding-top: 3px;">
                    {!! $teks !!}
                  </div>
                  @if($is_kunci)
                    <span class="label label-success" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; flex-shrink: 0; margin-top: 3px;">
                      <i class="fa fa-check"></i> KUNCI
                    </span>
                  @endif
                </div>
              @endif
            @endforeach
          </div>
        </div>

        <!-- Dual Pembahasan: Trik Cepat vs Pembahasan Konseptual -->
        <div class="row" style="margin-top: 24px;">
          <div class="col-md-6" style="margin-bottom: 16px;">
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 18px; height: 100%;">
              <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px; color: #166534; font-weight: 700; font-size: 14px;">
                <i class="fa fa-bolt" style="font-size: 16px; color: #15803d;"></i>
                <span>Trik Cepat / Solusi Praktis</span>
              </div>
              <div style="font-size: 13px; line-height: 1.6; color: #14532d;">
                @if(!empty($soal->pembahasan_cepat))
                  {!! $soal->pembahasan_cepat !!}
                @else
                  <p style="color: #64748b; font-style: italic; margin: 0;">Belum ada catatan trik cepat untuk soal ini.</p>
                @endif
              </div>
            </div>
          </div>

          <div class="col-md-6" style="margin-bottom: 16px;">
            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 18px; height: 100%;">
              <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px; color: #1e40af; font-weight: 700; font-size: 14px;">
                <i class="fa fa-book" style="font-size: 16px; color: #2563eb;"></i>
                <span>Pembahasan Konseptual / Langkah Runtut</span>
              </div>
              <div style="font-size: 13px; line-height: 1.6; color: #1e3a8a;">
                @if(!empty($soal->pembahasan_konsep))
                  {!! $soal->pembahasan_konsep !!}
                @else
                  <p style="color: #64748b; font-style: italic; margin: 0;">Belum ada uraian konsep mendalam untuk soal ini.</p>
                @endif
              </div>
            </div>
          </div>
        </div>

        <hr style="margin: 20px 0; border-color: #e2e8f0;">

        <!-- Navigasi Aksi -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
          <a href="{{ url('elearning/soal/detail/'.$soal->id_soal) }}" class="btn btn-default" style="font-weight: 500;">
            <i class="fa fa-arrow-left"></i> Kembali ke Paket
          </a>
          <a href="{{ url('/elearning/soal/detail/ubah/'.$soal->id) }}" class="btn btn-primary" style="font-weight: 500; background: #2563eb; border-color: #1d4ed8;">
            <i class="fa fa-pencil"></i> Ubah Soal & Pembahasan
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection