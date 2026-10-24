@extends('layouts.app')
@section('title', 'Katalog Latihan Soal & Bank Soal')
@section('breadcrumb')
  <div class="w-full">
    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-0.5 tracking-tight">Daftar Paket Latihan Soal</h1>
  </div>
@endsection

@section('content')
<div class="col-md-12">
  <div class="max-w-6xl mx-auto space-y-6">

    <!-- NOTIFIKASI FLASH PESAN -->
    @if(Session::has('error'))
      <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-sm font-semibold flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2">
          <i class="fa fa-exclamation-triangle text-amber-600 text-lg"></i>
          <span>{{ Session::get('error') }}</span>
        </div>
        <button type="button" onclick="$(this).parent().fadeOut();" class="text-amber-400 hover:text-amber-600 text-sm font-bold">✕</button>
      </div>
    @endif
    @if(Session::has('success'))
      <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2">
          <i class="fa fa-check-circle text-emerald-600 text-lg"></i>
          <span>{{ Session::get('success') }}</span>
        </div>
        <button type="button" onclick="$(this).parent().fadeOut();" class="text-emerald-400 hover:text-emerald-600 text-sm font-bold">✕</button>
      </div>
    @endif

    <!-- STATUS MEMBERSHIP BANNER UNTUK SISWA REGULER -->
    @if(!Auth::user()->isLanggananLes())
      <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white rounded-3xl p-6 sm:p-7 shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <div class="flex items-center gap-2 mb-1.5">
            <span class="px-2.5 py-0.5 rounded-md bg-amber-500/20 text-amber-300 border border-amber-400/30 text-xs font-bold uppercase tracking-wider">
              Akun Reguler / Gratis
            </span>
          </div>
          <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">Coba Paket Latihan Gratis Tanpa Biaya</h3>
          <p class="text-slate-300 text-xs sm:text-sm mt-1 max-w-2xl">
            Anda dapat langsung mengerjakan paket bertanda <b class="text-emerald-400">🟢 Gratis</b>. Untuk membuka akses ke seluruh paket simulasi akbar dan modul intensif, silakan daftar bimbingan belajar di website utama <b class="text-indigo-300">abdipraja.id</b> atau aktifkan voucher lisensi Anda.
          </p>
        </div>
        <div class="shrink-0 flex items-center gap-2 flex-wrap">
          <button type="button" onclick="bukaModalVoucher('Aktivasi Keanggotaan Bimbingan Belajar', 0)" class="px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-wider transition shadow-md flex items-center gap-2 cursor-pointer">
            <i class="fa fa-key"></i> Aktivasi Voucher
          </button>
        </div>
      </div>
    @endif

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

        <!-- CATEGORY & ACCESS PILLS -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 text-sm font-bold shrink-0">
          <button onclick="setFilter('all')" id="btn-filter-all" class="px-4 py-3 rounded-xl bg-slate-900 text-white shadow-sm transition whitespace-nowrap cursor-pointer">
            Semua ({{ $pakets->count() }})
          </button>
          <button onclick="setFilter('gratis')" id="btn-filter-gratis" class="px-4 py-3 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition whitespace-nowrap cursor-pointer">
            🟢 Gratis (Trial)
          </button>
          <button onclick="setFilter('berbayar')" id="btn-filter-berbayar" class="px-4 py-3 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition whitespace-nowrap cursor-pointer">
            👑 Khusus Les
          </button>
          <button onclick="setFilter('kedinasan')" id="btn-filter-kedinasan" class="px-4 py-3 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition whitespace-nowrap cursor-pointer">
            Kedinasan &amp; Polri
          </button>
          <button onclick="setFilter('sma')" id="btn-filter-sma" class="px-4 py-3 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition whitespace-nowrap cursor-pointer">
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
        Tidak ditemukan paket latihan yang cocok dengan kriteria filter <span id="search-keyword-display" class="font-bold text-slate-800"></span>.
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
        <?php
          $isLes = Auth::user()->isLanggananLes();
          $userJawabs = App\Models\Jawab::where('id_user', Auth::user()->id)->where('status', 1)->get()->keyBy('id_soal');
          $userTryCounts = DB::table("jawabs_count")->where('id_user', Auth::user()->id)->get()->keyBy('id_soal');
        ?>
        @foreach($pakets as $paket_soal)
          <?php
            $check = isset($userJawabs[$paket_soal->id]) ? $userJawabs[$paket_soal->id] : null;
            $tryCount = isset($userTryCounts[$paket_soal->id]) ? $userTryCounts[$paket_soal->id] : null;
            $is_done = ($check && (!empty($tryCount) && $tryCount->try_count >= 3));
            $rawCat = strtolower(($paket_soal->kategori_utama ?? '') . ' ' . ($paket_soal->paket ?? '') . ' ' . ($paket_soal->deskripsi ?? ''));
            $kategori = (strpos($rawCat, 'sma') !== false || strpos($rawCat, 'utbk') !== false || strpos($rawCat, 'snbt') !== false) ? 'sma' : 'kedinasan';
            $isGratis = $paket_soal->isGratis();
            $canAccess = ($isGratis || $isLes);
          ?>

          <div class="paket-card bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm hover:shadow-md transition flex flex-col justify-between" 
               data-category="{{ $kategori }}"
               data-access="{{ $isGratis ? 'gratis' : 'berbayar' }}"
               data-name="{{ strtolower($paket_soal->paket) }}"
               data-status="{{ $is_done ? 'selesai' : 'belum' }}">
            <div>
              <!-- BADGES HEADER -->
              <div class="flex items-center justify-between gap-2 mb-3">
                <span class="px-3 py-1 rounded-lg text-xs font-extrabold uppercase tracking-wider {{ $kategori == 'sma' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                  {{ $kategori == 'sma' ? 'SMA & UTBK-SNBT' : 'Kedinasan & Polri' }}
                </span>

                <!-- ACCESS TYPE BADGE -->
                @if($isGratis)
                  <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Gratis
                  </span>
                @elseif($isLes)
                  <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span> 👑 Khusus Les
                  </span>
                @else
                  <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200 flex items-center gap-1.5">
                    <i class="fa fa-lock text-slate-400"></i> Khusus Les @if($paket_soal->harga) &bull; Rp {{ number_format($paket_soal->harga, 0, ',', '.') }} @endif
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
                  <span>KKM: <b>{{ $paket_soal->kkm ?? 70 }}</b></span>
                </div>
                @if(!$isGratis && !$isLes && $paket_soal->harga)
                  <div class="flex items-center gap-2 text-slate-700 font-medium text-xs">
                    <i class="fa fa-tag text-slate-400 text-base w-5"></i>
                    <span>Harga: <b>Rp {{ number_format($paket_soal->harga, 0, ',', '.') }}</b></span>
                  </div>
                @endif
              </div>
            </div>

            <!-- BUTTONS -->
            <div class="pt-2">
              @if($is_done)
                <a href="{{ url('siswa/ujian/finish/'.$paket_soal->id) }}" class="w-full py-3.5 px-5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base transition shadow-sm text-center block">
                  <span>Buka Pembahasan &amp; Nilai</span> &rarr;
                </a>
              @elseif($canAccess)
                @if($isGratis)
                  <a href="{{ url('siswa/ujian/detail/'.$paket_soal->id) }}" class="w-full py-3.5 px-5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base transition shadow-md shadow-emerald-500/20 text-center block">
                    <span>Mulai Latihan (Gratis)</span> &rarr;
                  </a>
                @else
                  <a href="{{ url('siswa/ujian/detail/'.$paket_soal->id) }}" class="w-full py-3.5 px-5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base transition shadow-md shadow-indigo-500/20 text-center block">
                    <span>Mulai Latihan</span> &rarr;
                  </a>
                @endif
              @else
                <button type="button" onclick="bukaModalVoucher('{{ addslashes($paket_soal->paket) }}', {{ $paket_soal->harga ?? 0 }})" class="w-full py-3.5 px-5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-base transition shadow-sm text-center block cursor-pointer">
                  <span class="flex items-center justify-center gap-2">
                    <i class="fa fa-lock"></i>
                    <span>Buka Akses / Aktivasi</span> &rarr;
                  </span>
                </button>
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

<!-- MODAL AKTIVASI VOUCHER LISENSI -->
<div id="modal-voucher" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
  <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 relative">
    <div class="flex items-start justify-between pb-4 border-b border-slate-100">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center text-lg shrink-0">
          <i class="fa fa-lock"></i>
        </div>
        <div>
          <h3 class="text-base font-bold text-slate-900 tracking-tight" id="modal-paket-title">Konten Khusus Siswa Les</h3>
          <p class="text-xs text-slate-500 mt-0.5" id="modal-paket-price">Memerlukan akses keanggotaan aktif</p>
        </div>
      </div>
      <button type="button" onclick="tutupModalVoucher()" class="text-slate-400 hover:text-slate-600 text-lg font-bold p-1 cursor-pointer">✕</button>
    </div>

    <div class="py-5 space-y-4">
      <form action="{{ url('/crud/aktivasi') }}" method="POST" class="space-y-3">
        {{ csrf_field() }}
        <div>
          <label for="kode_voucher_input" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kode Voucher</label>
          <input type="text" id="kode_voucher_input" name="kode_voucher" required class="w-full px-4 py-3 text-sm font-mono tracking-wider rounded-xl border border-slate-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition" placeholder="Masukkan kode voucher">
        </div>
        <button type="submit" class="w-full py-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm cursor-pointer flex items-center justify-center gap-2">
          <i class="fa fa-key"></i> Aktifkan Lisensi
        </button>
      </form>

      <div class="relative flex items-center justify-center py-1">
        <div class="border-t border-slate-200 w-full"></div>
        <span class="bg-white px-3 text-xs text-slate-400 uppercase tracking-wider font-semibold">atau</span>
      </div>

      <a href="https://abdipraja.id/" target="_blank" rel="noopener noreferrer" class="w-full py-3 px-4 rounded-xl bg-slate-50 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-300 text-slate-700 hover:text-indigo-700 font-bold text-xs uppercase tracking-wider transition shadow-sm flex items-center justify-center gap-2 text-center">
        <i class="fa fa-globe text-indigo-600"></i>
        <span>Dapatkan Akses di abdipraja.id ↗</span>
      </a>
    </div>

    <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
      <button type="button" onclick="tutupModalVoucher()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition cursor-pointer">
        Tutup
      </button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  let activeFilter = 'all';
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
      const cardAccess = card.getAttribute('data-access') || '';
      const cardName = card.getAttribute('data-name') || '';
      
      let matchesFilter = false;
      if (activeFilter === 'all') {
        matchesFilter = true;
      } else if (activeFilter === 'gratis' || activeFilter === 'berbayar') {
        matchesFilter = (cardAccess === activeFilter);
      } else {
        matchesFilter = (cardCategory === activeFilter);
      }

      const matchesQuery = (!query || cardName.includes(query));

      if (matchesFilter && matchesQuery) {
        card.style.display = 'flex';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    // Update counter text
    if (query.length > 0 || activeFilter !== 'all') {
      counterEl.textContent = `Ditemukan ${visibleCount} dari ${totalCount} Paket`;
    } else {
      counterEl.textContent = `Menampilkan ${totalCount} Paket Soal`;
    }

    // Toggle Empty State Box
    if (visibleCount === 0) {
      noResultsBox.classList.remove('hidden');
      const keywordSpan = document.getElementById('search-keyword-display');
      if (keywordSpan) {
        keywordSpan.textContent = query ? `"${query}"` : '(filter terpilih)';
      }
    } else {
      noResultsBox.classList.add('hidden');
    }
  }

  function setFilter(filterKey) {
    activeFilter = filterKey;
    const filterButtons = ['all', 'gratis', 'berbayar', 'kedinasan', 'sma'];

    filterButtons.forEach(f => {
      const btn = document.getElementById('btn-filter-' + f);
      if (btn) {
        if (f === filterKey) {
          btn.className = "px-4 py-3 rounded-xl bg-slate-900 text-white shadow-sm transition whitespace-nowrap cursor-pointer";
        } else {
          btn.className = "px-4 py-3 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition whitespace-nowrap cursor-pointer";
        }
      }
    });

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
    setFilter('all');
  }

  function bukaModalVoucher(title, harga) {
    if (title) {
      document.getElementById('modal-paket-title').textContent = title;
    }
    if (harga > 0) {
      document.getElementById('modal-paket-price').textContent = 'Harga paket: Rp ' + Number(harga).toLocaleString('id-ID');
    } else {
      document.getElementById('modal-paket-price').textContent = 'Memerlukan keanggotaan aktif Siswa Les';
    }
    document.getElementById('modal-voucher').style.display = 'flex';
    setTimeout(function() {
      document.getElementById('kode_voucher_input').focus();
    }, 150);
  }

  function tutupModalVoucher() {
    document.getElementById('modal-voucher').style.display = 'none';
  }

  if (searchInput) {
    searchInput.addEventListener('input', filterCards);
  }

  // Keyboard shortcut: '/' focuses search input, 'Escape' clears it / closes modal
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      tutupModalVoucher();
      clearSearch();
    } else if (e.key === '/' && document.activeElement !== searchInput && document.getElementById('modal-voucher').style.display === 'none') {
      e.preventDefault();
      if (searchInput) {
        searchInput.focus();
      }
    }
  });
</script>
@endpush