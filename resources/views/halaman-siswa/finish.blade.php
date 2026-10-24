@extends('layouts.app')
@section('title', 'Hasil & Pembahasan: ' . $soal->paket)
@section('breadcrumb')
  <div class="w-full">
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">{{ $soal->paket }}</h1>
  </div>
@endsection
@section('content')
<div class="col-md-12">
  <div class="max-w-6xl mx-auto space-y-6">
    
    <!-- 1. HERO EVALUATION SCORECARD -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
            Rapor Hasil Latihan
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">{{ $soal->paket }}</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            Peserta: <b>{{ Auth::user()->nama }}</b> &bull; Total Soal: {{ $total_soal }} Butir
          </p>
        </div>

        <div class="flex items-center gap-6 bg-white/10 backdrop-blur p-4 rounded-2xl border border-white/10 shrink-0">
          <div>
            <div class="text-xs text-slate-300 font-medium">Nilai Total Kamu</div>
            <div class="text-3xl sm:text-4xl font-black text-amber-400 code-font mt-0.5">
              {{ number_format($nilai) }}
            </div>
          </div>
          <div class="h-10 w-px bg-white/20"></div>
          <div>
            <div class="text-xs text-slate-300 font-medium">Status KKM</div>
            <div class="text-sm sm:text-base font-bold text-emerald-400 mt-0.5">
              @if($nilai >= ($soal->kkm ?? 70))
                Memenuhi KKM ({{ $soal->kkm ?? 70 }})
              @else
                Perlu Latihan Lagi (KKM {{ $soal->kkm ?? 70 }})
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- METRIK BENAR, SALAH, KOSONG & TOMBOL AKSI (CENTERED & PERFEKSIONIS) -->
      <div class="mt-7 pt-6 border-t border-white/10 flex flex-col items-center">
        <div class="grid grid-cols-3 gap-3 sm:gap-4 w-full max-w-xl mx-auto">
          <div class="bg-white/5 rounded-2xl p-3.5 sm:p-4 border border-white/10 text-center">
            <div class="text-xs sm:text-sm text-emerald-400 font-bold">Benar</div>
            <div class="text-2xl sm:text-3xl font-black text-white mt-1">{{ $benar }}</div>
            <div class="text-[11px] sm:text-xs text-slate-300 font-medium mt-0.5">
              {{ $total_soal > 0 ? round(($benar / $total_soal) * 100) : 0 }}% Akurasi
            </div>
          </div>
          <div class="bg-white/5 rounded-2xl p-3.5 sm:p-4 border border-white/10 text-center">
            <div class="text-xs sm:text-sm text-red-400 font-bold">Salah</div>
            <div class="text-2xl sm:text-3xl font-black text-white mt-1">{{ $salah }}</div>
            <div class="text-[11px] sm:text-xs text-slate-300 font-medium mt-0.5">Perlu Evaluasi</div>
          </div>
          <div class="bg-white/5 rounded-2xl p-3.5 sm:p-4 border border-white/10 text-center">
            <div class="text-xs sm:text-sm text-slate-300 font-bold">Kosong</div>
            <div class="text-2xl sm:text-3xl font-black text-white mt-1">{{ $kosong }}</div>
            <div class="text-[11px] sm:text-xs text-slate-400 font-medium mt-0.5">Dilewati</div>
          </div>
        </div>

        <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3 w-full">
          <a href="{{ url('siswa/ujian') }}" class="w-full sm:w-auto px-5 py-3 rounded-xl bg-white/10 hover:bg-white/20 active:bg-white/25 text-white text-xs sm:text-sm font-semibold border border-white/20 transition shadow-sm inline-flex items-center justify-center gap-2 min-h-[42px] box-border">
            <i class="fa fa-arrow-left"></i> <span>Kembali ke Katalog Paket</span>
          </a>
          <a href="{{ url('siswa/ujian/detail/'.$soal->id) }}" class="w-full sm:w-auto px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition inline-flex items-center justify-center gap-2 min-h-[42px] box-border">
            <i class="fa fa-refresh"></i> <span>Ulangi Latihan Dari Awal</span>
          </a>
          <button onclick="window.print()" class="w-full sm:w-auto px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition inline-flex items-center justify-center gap-2 cursor-pointer min-h-[42px] box-border">
            <i class="fa fa-print"></i> <span>Cetak Bukti Nilai</span>
          </button>
        </div>
      </div>
    </div>


    <!-- 2. PEMBAHASAN DETAIL BUTIR SOAL -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-6 border-b border-slate-100 mb-6">
        <div>
          <h3 class="text-lg font-bold text-slate-900">Pembahasan &amp; Solusi Langkah Demi Langkah</h3>
          <p class="text-xs text-slate-500 mt-0.5">Pelajari cara pengerjaan cepat dan konsep akademis setiap butir soal di bawah ini.</p>
        </div>
        <div class="flex items-center gap-3 text-xs text-slate-500">
          <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500"></span> Benar</span>
          <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-500"></span> Salah</span>
          <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-slate-300"></span> Kosong</span>
        </div>
      </div>

      <!-- DAFTAR KARTU SOAL & PEMBAHASAN -->
      <div class="space-y-6">
        @if($detail_soals->count())
          @foreach($detail_soals as $index => $item)
            <?php
              $user_jawaban = isset($jawabs[$item->id]) ? $jawabs[$item->id]->pilihan : null;
              if ($item->tipe_soal == 'multi') {
                $user_arr = !empty($user_jawaban) ? explode(',', $user_jawaban) : [];
                $kunci_decoded = json_decode($item->kunci, true);
                $kunci_arr = is_array($kunci_decoded) ? $kunci_decoded : explode(',', $item->kunci);
                sort($user_arr);
                sort($kunci_arr);
                $is_correct = (!empty($user_arr) && $user_arr == $kunci_arr);
                $is_empty = empty($user_arr);
              } else {
                $kunci_arr = [$item->kunci];
                $user_arr = $user_jawaban ? [$user_jawaban] : [];
                $is_correct = ($user_jawaban && trim(strtoupper($user_jawaban)) == trim(strtoupper($item->kunci)));
                $is_empty = empty($user_jawaban);
              }
            ?>

            <div class="rounded-2xl border {{ $is_correct ? 'border-emerald-200 bg-emerald-50/10' : ($is_empty ? 'border-slate-200 bg-slate-50/30' : 'border-red-200 bg-red-50/10') }} p-4 sm:p-6 transition hover:shadow-sm">
              
              <!-- HEADER BUTIR -->
              <div class="flex flex-wrap items-center justify-between gap-2.5 pb-3 mb-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5 flex-wrap">
                  <span class="w-9 h-9 sm:w-8 sm:h-8 rounded-xl {{ $is_correct ? 'bg-emerald-600 text-white' : ($is_empty ? 'bg-slate-200 text-slate-700' : 'bg-red-600 text-white') }} font-extrabold text-sm sm:text-xs flex items-center justify-center shrink-0">
                    #{{ $index + 1 }}
                  </span>
                  
                  @if($item->tipe_soal == 'multi')
                    <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300">
                      Multi-Jawaban
                    </span>
                  @elseif($item->tipe_soal == 'tkp')
                    <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-300">
                      Soal TKP
                    </span>
                  @endif

                  @if($item->tipe_soal == 'tkp')
                    <?php
                      $tkp_score = isset($jawabs[$item->id]) ? $jawabs[$item->id]->score : 0;
                    ?>
                    <span class="px-3 py-1 rounded-lg text-xs sm:text-sm font-bold bg-indigo-100 text-indigo-800 border border-indigo-300">
                      Skor TKP: +{{ number_format($tkp_score) }} Poin
                    </span>
                  @elseif($is_correct)
                    <span class="px-3 py-1 rounded-lg text-xs sm:text-sm font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                      ✓ Jawaban Kamu Benar (+{{ $item->score ?? 1 }})
                    </span>
                  @elseif($is_empty)
                    <span class="px-3 py-1 rounded-lg text-xs sm:text-sm font-medium bg-slate-100 text-slate-700 border border-slate-200">
                      ○ Tidak Kamu Jawab (0 Poin)
                    </span>
                  @else
                    <span class="px-3 py-1 rounded-lg text-xs sm:text-sm font-bold bg-red-100 text-red-800 border border-red-300">
                      ✕ Jawaban Kamu Salah (0 Poin)
                    </span>
                  @endif
                </div>

                <div class="text-xs sm:text-sm text-slate-600">
                  @if($item->tipe_soal != 'tkp')
                    Kunci Resmi: <b class="text-emerald-700 text-sm sm:text-base font-black">{{ is_array($kunci_arr) ? implode(', ', $kunci_arr) : $item->kunci }}</b>
                  @endif
                  @if(!$is_empty)
                    &bull; Kamu Pilih: <b class="{{ ($item->tipe_soal == 'tkp' || $is_correct) ? 'text-emerald-700' : 'text-red-700' }}">{{ is_array($user_arr) ? implode(', ', $user_arr) : $user_jawaban }}</b>
                  @endif
                </div>
              </div>

              <!-- TEKS SOAL -->
              <div class="text-base sm:text-lg text-slate-900 leading-relaxed font-medium mb-5 soal-content">
                {!! $item->soal !!}
              </div>

              <!-- PILIHAN OPSI -->
              <div class="grid grid-cols-1 gap-2.5 mb-5">
                <?php
                  $bobot_arr = !empty($item->bobot_opsi) ? (is_array(json_decode($item->bobot_opsi, true)) ? json_decode($item->bobot_opsi, true) : []) : [];
                ?>
                @foreach(['A' => $item->pila, 'B' => $item->pilb, 'C' => $item->pilc, 'D' => $item->pild, 'E' => $item->pile] as $label => $text)
                  @if(!empty($text))
                    <?php
                      $is_this_key = in_array(trim(strtoupper($label)), array_map('strtoupper', array_map('trim', $kunci_arr)));
                      $is_this_user = in_array(trim(strtoupper($label)), array_map('strtoupper', array_map('trim', $user_arr)));
                      $opsi_bobot = isset($bobot_arr[$label]) ? $bobot_arr[$label] : null;
                    ?>
                    <div class="p-3.5 sm:p-4 rounded-xl border flex items-start gap-3 transition {{ $is_this_key ? 'bg-emerald-50/80 border-emerald-300 font-semibold text-emerald-950' : ($is_this_user ? 'bg-blue-50/80 border-blue-300 text-blue-950' : 'bg-white border-slate-200 text-slate-800') }}">
                      <span class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 font-bold text-xs sm:text-sm shadow-xs {{ $is_this_key ? 'bg-emerald-600 text-white' : ($is_this_user ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 border border-slate-200') }}">
                        {{ $label }}
                      </span>
                      <div class="flex-1 pt-0.5 text-[15px] sm:text-base leading-relaxed opsi-text">{!! $text !!}</div>
                      @if($item->tipe_soal == 'tkp' && $opsi_bobot !== null)
                        <span class="text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-200 px-2.5 py-1 rounded-md shrink-0">{{ $opsi_bobot }} Poin</span>
                      @endif
                      @if($is_this_key && $item->tipe_soal != 'tkp')
                        <span class="text-xs font-bold text-emerald-700 shrink-0 flex items-center gap-1">✓ Kunci Benar</span>
                      @endif
                      @if($is_this_user)
                        <span class="text-xs font-bold text-blue-700 shrink-0">Pilihanmu</span>
                      @endif
                    </div>
                  @endif
                @endforeach
              </div>

              <!-- DUA KOTAK PEMBAHASAN: TRIK CEPAT VS PEMBAHASAN KONSEPTUAL -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                
                <!-- KOTAK 1: TRIK CEPAT / SOLUSI PRAKTIS -->
                <div class="bg-amber-50/70 border border-amber-300 rounded-2xl p-4 sm:p-5">
                  <div class="flex items-center gap-2 mb-2.5">
                    <span class="px-2.5 py-1 rounded-md text-[11px] sm:text-xs font-black uppercase tracking-wider bg-amber-500 text-white">
                      Trik Cepat / Solusi Praktis
                    </span>
                  </div>
                  <div class="text-[14.5px] sm:text-base text-slate-800 leading-relaxed pembahasan-text">
                    @if(!empty($item->pembahasan_cepat))
                      {!! $item->pembahasan_cepat !!}
                    @else
                      <p>Perhatikan pola pertanyaan secara cermat. @if($item->tipe_soal != 'tkp') Kunci jawaban adalah <b>{{ $item->kunci }}</b>. @endif Gunakan teknik eliminasi opsi yang tidak logis terlebih dahulu untuk menghemat waktu pengerjaan.</p>
                    @endif
                  </div>
                </div>

                <!-- KOTAK 2: PEMBAHASAN KONSEPTUAL -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5">
                  <div class="flex items-center gap-2 mb-2.5">
                    <span class="px-2.5 py-1 rounded-md text-[11px] sm:text-xs font-black uppercase tracking-wider bg-slate-800 text-white">
                      Pembahasan Konseptual
                    </span>
                  </div>
                  <div class="text-[14.5px] sm:text-base text-slate-700 leading-relaxed pembahasan-text">
                    @if(!empty($item->pembahasan_konsep))
                      {!! $item->pembahasan_konsep !!}
                    @else
                      <p>Penyelesaian akademis sesuai dengan teori dasar dan kurikulum. @if($item->tipe_soal != 'tkp') Jawaban yang tepat dan sahih pada butir ini adalah pilihan <b>{{ $item->kunci }}</b>. @endif</p>
                    @endif
                  </div>
                </div>

              </div>

            </div>
          @endforeach
        @endif
      </div>
    </div>

  </div>
</div>
@endsection
@push('css')
<style>
  .soal-content, .soal-content p, .soal-content span, .soal-content div {
    font-size: 16px !important;
    line-height: 1.7 !important;
  }
  @media (min-width: 640px) {
    .soal-content, .soal-content p, .soal-content span, .soal-content div {
      font-size: 18px !important;
      line-height: 1.75 !important;
    }
  }

  .opsi-text, .opsi-text p, .opsi-text span, .opsi-text div {
    font-size: 15px !important;
    line-height: 1.6 !important;
  }
  @media (min-width: 640px) {
    .opsi-text, .opsi-text p, .opsi-text span, .opsi-text div {
      font-size: 16px !important;
      line-height: 1.65 !important;
    }
  }

  .pembahasan-text, .pembahasan-text p, .pembahasan-text span, .pembahasan-text div {
    font-size: 14.5px !important;
    line-height: 1.65 !important;
  }
  @media (min-width: 640px) {
    .pembahasan-text, .pembahasan-text p, .pembahasan-text span, .pembahasan-text div {
      font-size: 15.5px !important;
      line-height: 1.7 !important;
    }
  }
</style>
@endpush
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    try {
      var sid = '{{ $soal->id }}';
      localStorage.removeItem('cbt_exam_active_' + sid);
      localStorage.removeItem('cbt_exam_end_' + sid);
      localStorage.removeItem('cbt_exam_current_no_' + sid);
      localStorage.removeItem('cbt_exam_q_end_' + sid);
      localStorage.removeItem('cbt_exam_v2_active_' + sid);
      localStorage.removeItem('cbt_exam_v2_end_' + sid);
      localStorage.removeItem('cbt_exam_v2_current_no_' + sid);
      localStorage.removeItem('cbt_exam_v2_q_end_' + sid);
      for (var i = localStorage.length - 1; i >= 0; i--) {
        var k = localStorage.key(i);
        if (k && k.indexOf('ragu_' + sid + '_') === 0) {
          localStorage.removeItem(k);
        }
      }
    } catch (e) {}

    if (typeof renderMathInElement === 'function') {
      renderMathInElement(document.body, {
        delimiters: [
          {left: '$$', right: '$$', display: true},
          {left: '$', right: '$', display: false}
        ],
        throwOnError: false
      });
    }
  });
</script>
@endpush