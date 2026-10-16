@extends('layouts.app')
@section('title', 'Katalog Latihan Soal & Bank Soal')
@section('breadcrumb')
  <div class="px-4 py-2">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Katalog Belajar &bull; Bank Soal</div>
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">Daftar Paket Latihan Soal</h1>
  </div>
@endsection
@section('content')
<div class="col-md-12">
  <div class="max-w-7xl mx-auto space-y-6">

    <!-- HEADER FILTER BANNER -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h2 class="text-xl font-bold text-slate-900">Pilih Paket Latihan yang Ingin Dikerjakan</h2>
        <p class="text-sm text-slate-500 mt-1">Tersedia paket latihan untuk persiapan SMA (UTBK-SNBT) dan Seleksi Kedinasan/Polri.</p>
      </div>

      <!-- FILTER KATEGORI -->
      <div class="flex items-center gap-2 overflow-x-auto text-sm font-semibold">
        <button onclick="filterKategori('all')" id="btn-filter-all" class="px-4 py-2 rounded-xl bg-slate-900 text-white shadow-sm transition">
          Semua ({{ $pakets->count() }})
        </button>
        <button onclick="filterKategori('kedinasan')" id="btn-filter-kedinasan" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
          Kedinasan &amp; Polri
        </button>
        <button onclick="filterKategori('sma')" id="btn-filter-sma" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
          SMA &amp; UTBK-SNBT
        </button>
      </div>
    </div>

    <!-- GRID KARTU PAKET LATIHAN -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="pakets-grid">
      @if($pakets->count())
        @foreach($pakets as $paket_soal)
          <?php
            $check = App\Models\Jawab::where([['id_soal', $paket_soal->id], ['id_user', Auth::user()->id], ['status', 1]])->first();
            $tryCount = DB::table("jawabs_count")->where([['id_soal', $paket_soal->id], ['id_user', Auth::user()->id]])->first();
            $is_done = ($check && (!empty($tryCount) && $tryCount->try_count >= 3));
            $kategori = $paket_soal->kategori_utama ?? 'kedinasan';
          ?>

          <div class="paket-card bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between" data-category="{{ $kategori }}">
            <div>
              <!-- BADGES -->
              <div class="flex items-center justify-between gap-2 mb-3">
                <span class="px-3 py-1 rounded text-xs font-extrabold uppercase tracking-wider {{ $kategori == 'sma' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                  {{ $kategori == 'sma' ? 'SMA & UTBK' : 'Kedinasan & Polri' }}
                </span>

                @if($is_done)
                  <span class="px-2.5 py-1 rounded text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Selesai
                  </span>
                @else
                  <span class="px-2.5 py-1 rounded text-xs font-semibold bg-slate-100 text-slate-600">
                    Belum Dikerjakan
                  </span>
                @endif
              </div>

              <!-- NAMA PAKET -->
              <h3 class="text-lg font-bold text-slate-900 leading-snug mb-3">
                {{ $paket_soal->paket }}
              </h3>

              <!-- INFO WAKTU & KKM -->
              <div class="space-y-1.5 text-sm text-slate-600 mb-6">
                <div class="flex items-center gap-2">
                  <i class="fa fa-clock-o text-slate-400"></i>
                  <span>Durasi: {{ round($paket_soal->waktu / 60) }} Menit ({{ $paket_soal->waktu }} Detik)</span>
                </div>
                <div class="flex items-center gap-2">
                  <i class="fa fa-check-square-o text-slate-400"></i>
                  <span>Passing Grade / KKM: {{ $paket_soal->kkm ?? 70 }}</span>
                </div>
              </div>
            </div>

            <!-- BUTTONS -->
            <div>
              @if($is_done)
                <a href="{{ url('siswa/ujian/finish/'.$paket_soal->id) }}" class="w-full py-3 px-5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm uppercase tracking-wider transition shadow-sm text-center block">
                  Buka Pembahasan &amp; Nilai &rarr;
                </a>
              @else
                <a href="{{ url('siswa/ujian/detail/'.$paket_soal->id) }}" class="w-full py-3 px-5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm uppercase tracking-wider transition shadow-sm text-center block">
                  Mulai Latihan &rarr;
                </a>
              @endif
            </div>

          </div>
        @endforeach
      @else
        <div class="col-span-3 bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-500">
          Belum ada paket latihan yang tersedia saat ini.
        </div>
      @endif
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
  function filterKategori(kat) {
    const cards = document.querySelectorAll('.paket-card');
    const btnAll = document.getElementById('btn-filter-all');
    const btnKed = document.getElementById('btn-filter-kedinasan');
    const btnSma = document.getElementById('btn-filter-sma');

    [btnAll, btnKed, btnSma].forEach(b => {
      b.className = "px-3.5 py-1.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition";
    });

    if (kat === 'all') {
      btnAll.className = "px-3.5 py-1.5 rounded-xl bg-slate-900 text-white shadow-sm transition";
      cards.forEach(c => c.style.display = 'flex');
    } else if (kat === 'kedinasan') {
      btnKed.className = "px-3.5 py-1.5 rounded-xl bg-slate-900 text-white shadow-sm transition";
      cards.forEach(c => {
        c.style.display = (c.getAttribute('data-category') === 'kedinasan') ? 'flex' : 'none';
      });
    } else if (kat === 'sma') {
      btnSma.className = "px-3.5 py-1.5 rounded-xl bg-slate-900 text-white shadow-sm transition";
      cards.forEach(c => {
        c.style.display = (c.getAttribute('data-category') === 'sma') ? 'flex' : 'none';
      });
    }
  }
</script>
@endpush