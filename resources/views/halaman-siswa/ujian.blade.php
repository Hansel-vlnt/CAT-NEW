@extends('layouts.app')
@section('title', 'Katalog Latihan Soal & Bank Soal')
@section('breadcrumb')
  <div class="w-full max-w-7xl">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Katalog Belajar &bull; Bank Soal</div>
    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5 tracking-tight">Daftar Paket Latihan Soal</h1>
  </div>
@endsection

@section('content')
<div class="col-md-12">
  <div class="w-full max-w-7xl space-y-6">

    <!-- HEADER FILTER & SEARCH BANNER -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100">
        <div>
          <h2 class="text-2xl font-black text-slate-900 tracking-tight">Pilih Paket Latihan yang Ingin Dikerjakan</h2>
          <p class="text-base text-slate-500 mt-1">Tersedia paket latihan untuk persiapan SMA (UTBK-SNBT) dan Seleksi Kedinasan/Polri.</p>
        </div>

        <!-- COUNTER BADGE -->
        <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-2xl bg-indigo-50/70 border border-indigo-100 text-indigo-900 text-sm font-bold self-start md:self-auto shadow-sm">
          <i class="fa fa-folder-open text-indigo-600 text-base"></i>
          <span id="paket-counter">Menampilkan {{ $pakets->count() }} Paket Soal</span>
        </div>
      </div>

      <!-- SEARCH BAR & FILTER TABS -->
      <div class="mt-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <!-- SEARCH INPUT -->
        <div class="relative flex-1 max-w-xl">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 text-lg">
            <i class="fa fa-search"></i>
          </div>
          <input 
            type="text" 
            id="search-input" 
            class="w-full pl-12 pr-24 py-3.5 bg-slate-50 hover:bg-slate-100/70 focus:bg-white border border-slate-200 rounded-2xl text-base font-semibold text-slate-800 placeholder-slate-400 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100/60 transition outline-none shadow-inner" 
            placeholder="Cari nama paket soal (misal: Kecerdasan, TWK, UTBK)..." 
            autocomplete="off"
          >
          <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center gap-1.5">
            <button 
              type="button" 
              id="btn-clear-search" 
              onclick="clearSearch()" 
              class="hidden text-slate-400 hover:text-slate-700 p-1 rounded-full hover:bg-slate-200/60 transition text-base cursor-pointer"
              title="Hapus pencarian"
            >
              <i class="fa fa-times-circle"></i>
            </button>
            <span class="hidden sm:inline-flex items-center px-2 py-0.5 text-xs font-bold text-slate-400 bg-slate-200/70 rounded-md select-none border border-slate-300/60">
              /
            </span>
          </div>
        </div>

        <!-- CATEGORY PILLS -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 text-sm font-bold shrink-0">
          <button onclick="setKategori('all')" id="btn-filter-all" class="px-4 py-3 rounded-xl bg-slate-900 text-white shadow-sm transition whitespace-nowrap cursor-pointer">
            Semua ({{ $pakets->count() }})
          </button>
          <button onclick="setKategori('kedinasan')" id="btn-filter-kedinasan" class="px-4 py-3 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition whitespace-nowrap cursor-pointer">
            Kedinasan &amp; Polri
          </button>
          <button onclick="setKategori('sma')" id="btn-filter-sma" class="px-4 py-3 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition whitespace-nowrap cursor-pointer">
            SMA &amp; UTBK-SNBT
          </button>
        </div>
      </div>
    </div>

    <!-- EMPTY STATE JIKA HASIL PENCARIAN KOSONG -->
    <div id="no-results-box" class="hidden bg-white rounded-3xl border border-slate-200 p-12 text-center max-w-xl mx-auto shadow-sm my-6">
      <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center text-2xl mx-auto mb-4">
        <i class="fa fa-search"></i>
      </div>
      <h3 class="text-xl font-black text-slate-900 tracking-tight">Paket Soal Tidak Ditemukan</h3>
      <p class="text-base text-slate-500 mt-2">
        Tidak ditemukan paket latihan yang cocok dengan pencarian <span id="search-keyword-display" class="font-bold text-slate-800"></span>.
      </p>
      <div class="mt-6">
        <button type="button" onclick="resetAllFilters()" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base transition shadow-sm cursor-pointer inline-flex items-center gap-2">
          <i class="fa fa-refresh"></i>
          <span>Reset Pencarian &amp; Filter</span>
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
            $rawCat = strtolower(($paket_soal->kategori_utama ?? '') . ' ' . ($paket_soal->paket ?? '') . ' ' . ($paket_soal->deskripsi ?? ''));
            $kategori = (strpos($rawCat, 'sma') !== false || strpos($rawCat, 'utbk') !== false || strpos($rawCat, 'snbt') !== false) ? 'sma' : 'kedinasan';
          ?>

          <div class="paket-card bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm hover:shadow-md transition flex flex-col justify-between" 
               data-category="{{ $kategori }}"
               data-name="{{ strtolower($paket_soal->paket) }}"
               data-status="{{ $is_done ? 'selesai' : 'belum' }}">
            <div>
              <!-- BADGES -->
              <div class="flex items-center justify-between gap-2 mb-3">
                <span class="px-3 py-1 rounded-lg text-xs font-extrabold uppercase tracking-wider {{ $kategori == 'sma' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                  {{ $kategori == 'sma' ? 'SMA & UTBK-SNBT' : 'Kedinasan & Polri' }}
                </span>

                @if($is_done)
                  <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Selesai
                  </span>
                @else
                  <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600">
                    Belum Dikerjakan
                  </span>
                @endif
              </div>

              <!-- NAMA PAKET -->
              <h3 class="paket-title text-xl font-bold text-slate-900 leading-snug mb-3">
                {{ $paket_soal->paket }}
              </h3>

              <!-- INFO WAKTU & KKM -->
              <div class="space-y-2 text-sm text-slate-600 mb-6">
                <div class="flex items-center gap-2">
                  <i class="fa fa-clock-o text-slate-400 text-base w-5"></i>
                  <span>Durasi: <b>{{ round($paket_soal->waktu / 60) }} Menit</b> ({{ $paket_soal->waktu }} Detik)</span>
                </div>
                <div class="flex items-center gap-2">
                  <i class="fa fa-check-square-o text-slate-400 text-base w-5"></i>
                  <span>Passing Grade / KKM: <b>{{ $paket_soal->kkm ?? 70 }}</b></span>
                </div>
              </div>
            </div>

            <!-- BUTTONS -->
            <div class="pt-2">
              @if($is_done)
                <a href="{{ url('siswa/ujian/finish/'.$paket_soal->id) }}" class="w-full py-3.5 px-5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base transition shadow-sm text-center block">
                  <span>Buka Pembahasan &amp; Nilai</span> &rarr;
                </a>
              @else
                <a href="{{ url('siswa/ujian/detail/'.$paket_soal->id) }}" class="w-full py-3.5 px-5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base transition shadow-md shadow-indigo-500/20 text-center block">
                  <span>Mulai Latihan</span> &rarr;
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
  let activeCategory = 'all';
  const searchInput = document.getElementById('search-input');
  const btnClear = document.getElementById('btn-clear-search');
  const counterEl = document.getElementById('paket-counter');
  const noResultsBox = document.getElementById('no-results-box');
  const cards = Array.from(document.querySelectorAll('.paket-card'));
  const totalCount = cards.length;

  function filterCards() {
    const query = (searchInput.value || '').trim().toLowerCase();
    
    // Toggle clear button
    if (query.length > 0) {
      btnClear.classList.remove('hidden');
    } else {
      btnClear.classList.add('hidden');
    }

    let visibleCount = 0;

    cards.forEach(card => {
      const cardCategory = card.getAttribute('data-category') || '';
      const cardName = card.getAttribute('data-name') || '';
      
      const matchesCategory = (activeCategory === 'all' || cardCategory === activeCategory);
      const matchesQuery = (!query || cardName.includes(query));

      if (matchesCategory && matchesQuery) {
        card.style.display = 'flex';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    // Update counter text
    if (query.length > 0 || activeCategory !== 'all') {
      counterEl.textContent = `Ditemukan ${visibleCount} dari ${totalCount} Paket`;
    } else {
      counterEl.textContent = `Menampilkan ${totalCount} Paket Soal`;
    }

    // Toggle Empty State Box
    if (visibleCount === 0) {
      noResultsBox.classList.remove('hidden');
      const keywordSpan = document.getElementById('search-keyword-display');
      if (keywordSpan) {
        keywordSpan.textContent = query ? `"${query}"` : '(kategori terpilih)';
      }
    } else {
      noResultsBox.classList.add('hidden');
    }
  }

  function setKategori(kat) {
    activeCategory = kat;
    const btnAll = document.getElementById('btn-filter-all');
    const btnKed = document.getElementById('btn-filter-kedinasan');
    const btnSma = document.getElementById('btn-filter-sma');

    [btnAll, btnKed, btnSma].forEach(b => {
      if (b) {
        b.className = "px-4 py-3 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition whitespace-nowrap cursor-pointer";
      }
    });

    if (kat === 'all' && btnAll) {
      btnAll.className = "px-4 py-3 rounded-xl bg-slate-900 text-white shadow-sm transition whitespace-nowrap cursor-pointer";
    } else if (kat === 'kedinasan' && btnKed) {
      btnKed.className = "px-4 py-3 rounded-xl bg-slate-900 text-white shadow-sm transition whitespace-nowrap cursor-pointer";
    } else if (kat === 'sma' && btnSma) {
      btnSma.className = "px-4 py-3 rounded-xl bg-slate-900 text-white shadow-sm transition whitespace-nowrap cursor-pointer";
    }

    filterCards();
  }

  function clearSearch() {
    if (searchInput) {
      searchInput.value = '';
      searchInput.focus();
      filterCards();
    }
  }

  function resetAllFilters() {
    if (searchInput) {
      searchInput.value = '';
    }
    setKategori('all');
  }

  if (searchInput) {
    searchInput.addEventListener('input', filterCards);
  }

  // Keyboard shortcut: '/' focuses search input, 'Escape' clears it
  document.addEventListener('keydown', function(e) {
    if (e.key === '/' && document.activeElement !== searchInput) {
      e.preventDefault();
      if (searchInput) {
        searchInput.focus();
      }
    } else if (e.key === 'Escape' && document.activeElement === searchInput) {
      clearSearch();
    }
  });
</script>
@endpush