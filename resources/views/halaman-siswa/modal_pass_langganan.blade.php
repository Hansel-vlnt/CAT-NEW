<!-- MODAL PILIHAN PAKET PASS & AKTIVASI VOUCHER -->
<div id="modal-voucher" style="display: none; z-index: 99999 !important;" class="fixed inset-0 z-[99999] overflow-y-auto bg-slate-950/80 backdrop-blur-sm p-3 sm:p-6 flex justify-center items-start">
  <div class="bg-white rounded-3xl max-w-4xl w-full shadow-2xl border border-slate-200 flex flex-col overflow-hidden my-4 sm:my-8 relative">
    
    <!-- MODAL HEADER (STICKY - TIDAK PERNAH TERPOTONG/KETUTUPAN DI MOBILE MAUPUN DESKTOP) -->
    <div class="px-5 sm:px-7 py-4 sm:py-5 border-b border-slate-100 bg-white flex items-center justify-between shrink-0 sticky top-0 z-20">
      <div class="flex items-center gap-3">
        <div class="w-10 sm:w-11 h-10 sm:h-11 rounded-2xl bg-indigo-50 border border-indigo-200/80 text-indigo-600 flex items-center justify-center text-lg sm:text-xl shrink-0">
          <i class="fa fa-diamond"></i>
        </div>
        <div>
          <h3 class="text-base sm:text-xl font-black text-slate-900 tracking-tight">Pilihan Paket Langganan CBT</h3>
          <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Buka akses ke seluruh paket simulasi tryout CAT dan modul pembelajaran.</p>
        </div>
      </div>
      <button type="button" onclick="tutupModalVoucher()" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center text-base font-bold transition cursor-pointer shrink-0">✕</button>
    </div>

    <!-- LOCKED ITEM NOTICE (Hanya tampil jika siswa klik soal/materi yang terkunci) -->
    <div id="modal-locked-notice" style="display: none;" class="mx-5 sm:mx-7 mt-4 p-3.5 sm:p-4 rounded-2xl bg-amber-50 border border-amber-200 flex items-center gap-3 shrink-0">
      <i class="fa fa-lock text-amber-600 text-lg sm:text-xl shrink-0"></i>
      <div class="text-xs sm:text-sm text-amber-900 leading-snug">
        Konten <strong id="modal-paket-title" class="font-bold">Paket Latihan</strong> membutuhkan keanggotaan aktif. Silakan pilih paket pass di bawah atau aktivasi kode voucher Anda.
      </div>
    </div>

    <!-- MODAL BODY (SCROLLABLE DENGAN TIPOGRAFI TEGAS & PROPORSIONAL) -->
    <div class="p-5 sm:p-7 overflow-y-auto max-h-[72vh] space-y-6 flex-1">
      
      <!-- DAFTAR KARTU PAKET PASS -->
      @if(isset($pakets_langganan) && count($pakets_langganan) > 0)
        <div>
          <div class="text-xs sm:text-sm font-bold text-slate-600 uppercase tracking-wider mb-3.5 flex items-center gap-2">
            <i class="fa fa-cubes text-indigo-600"></i>
            <span>Pilihan Paket Langganan All-Access</span>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($pakets_langganan as $pkg)
              @php
                $isPopular = !empty($pkg->badge) && (stripos($pkg->badge, 'populer') !== false || stripos($pkg->badge, 'terlaris') !== false);
                $fiturList = $pkg->getFiturArray();
                $waText = "Halo Admin Abdi Praja Edukasi, saya ingin berlangganan *" . $pkg->nama_paket . "* (" . $pkg->durasi_bulan . " Bulan, " . $pkg->formatted_harga . ") untuk akun email: " . (Auth::user() ? Auth::user()->email : '') . ". Mohon instruksi pembayarannya. Terima kasih.";
                $waUrl = "https://wa.me/6285767629211?text=" . urlencode($waText);
              @endphp
              <div class="rounded-2xl border {{ $isPopular ? 'border-indigo-500 bg-indigo-50/20 shadow-md ring-2 ring-indigo-500/20' : 'border-slate-200 bg-white hover:border-slate-300 shadow-sm' }} p-5 sm:p-6 flex flex-col justify-between transition">
                
                <div class="space-y-3">
                  @if($pkg->badge)
                    <div>
                      <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $isPopular ? 'bg-indigo-600 text-white shadow-sm' : 'bg-amber-500 text-white shadow-sm' }}">
                        {{ $pkg->badge }}
                      </span>
                    </div>
                  @endif

                  <div>
                    <h4 class="font-black text-slate-900 text-lg sm:text-xl tracking-tight leading-snug">{{ $pkg->nama_paket }}</h4>
                    <div class="inline-flex items-center gap-1.5 mt-2 px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 font-bold text-xs sm:text-sm border border-indigo-200/60">
                      <i class="fa fa-clock-o"></i> Akses {{ $pkg->durasi_bulan }} Bulan ({{ $pkg->durasi_hari }} Hari)
                    </div>
                  </div>

                  <div class="pt-2 border-t border-slate-100">
                    <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ $pkg->formatted_harga }}</div>
                    @if($pkg->harga_coret && $pkg->harga_coret > $pkg->harga)
                      <div class="flex items-center gap-2 text-xs sm:text-sm mt-1">
                        <span class="line-through text-slate-400 font-semibold">{{ $pkg->formatted_harga_coret }}</span>
                        <span class="text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                          Hemat {{ $pkg->getHematPersen() }}%
                        </span>
                      </div>
                    @endif
                  </div>

                  @if($pkg->deskripsi)
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $pkg->deskripsi }}</p>
                  @endif

                  <!-- DAFTAR FASILITAS DENGAN UKURAN TEKS JELAS -->
                  @if(count($fiturList) > 0)
                    <div class="pt-3 border-t border-slate-100">
                      <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2.5">Fasilitas Termasuk:</div>
                      <ul class="space-y-2">
                        @foreach($fiturList as $ft)
                          <li class="flex items-start gap-2.5 text-xs sm:text-sm text-slate-700 font-medium leading-snug">
                            <i class="fa fa-check-circle text-emerald-500 mt-0.5 text-sm sm:text-base shrink-0"></i>
                            <span>{{ $ft }}</span>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                </div>

                <!-- DUA PILIHAN CARA BAYAR (WA & QRIS/TRANSFER) -->
                <div class="pt-4 mt-5 border-t border-slate-100 space-y-2">
                  <!-- Pilihan 1: WhatsApp (Aktif & Direkomendasikan) -->
                  <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="w-full py-3 px-4 rounded-xl {{ $isPopular ? 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-md shadow-indigo-600/20' : 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm' }} font-bold text-xs sm:text-sm uppercase tracking-wider transition flex items-center justify-center gap-2 text-center">
                    <i class="fa fa-whatsapp text-base"></i>
                    <span>Beli via WhatsApp</span>
                  </a>

                  <!-- Pilihan 2: Info QRIS / Transfer Bank -->
                  <button type="button" onclick="bukaDetailBayar('{{ addslashes($pkg->nama_paket) }}', '{{ $pkg->formatted_harga }}')" class="w-full py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-1.5 cursor-pointer">
                    <i class="fa fa-qrcode text-sm"></i>
                    <span>Bayar via QRIS / Bank</span>
                  </button>
                </div>

              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- DETAIL PEMBAYARAN TRANSFER & QRIS BIMBEL (OPSI PILIHAN KEDUA) -->
      <div id="section-detail-pembayaran" style="display: none;" class="p-5 sm:p-6 rounded-2xl bg-indigo-50/70 border border-indigo-200 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-indigo-200/80">
          <div class="flex items-center gap-2.5">
            <i class="fa fa-qrcode text-indigo-600 text-xl"></i>
            <div>
              <span class="text-xs font-bold text-indigo-700 uppercase tracking-wider">Metode Pembayaran Mandiri</span>
              <h5 class="text-sm sm:text-base font-extrabold text-slate-900 mt-0.5" id="bayar_paket_label">Pass Langganan CBT</h5>
            </div>
          </div>
          <button type="button" onclick="$('#section-detail-pembayaran').slideUp();" class="text-xs text-indigo-600 hover:text-indigo-800 font-bold p-1">✕ Sembunyikan</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <!-- OPSI TRANSFER BANK -->
          <div class="bg-white p-4 sm:p-5 rounded-xl border border-slate-200 space-y-2">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">1. Transfer Rekening Bank</div>
            <div class="flex items-center justify-between pt-1">
              <div>
                <div class="text-sm font-extrabold text-slate-900">Bank BCA</div>
                <div class="text-base sm:text-lg font-black text-indigo-600 font-mono tracking-wider mt-0.5" id="nomor_rekening">8280912345</div>
                <div class="text-xs text-slate-500">a.n. Abdi Praja Edukasi</div>
              </div>
              <button type="button" onclick="salinRekening()" class="px-3 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold transition flex items-center gap-1 cursor-pointer">
                <i class="fa fa-copy"></i> <span id="btn-salin-text">Salin</span>
              </button>
            </div>
          </div>

          <!-- OPSI SCAN QRIS -->
          <div class="bg-white p-4 sm:p-5 rounded-xl border border-slate-200 space-y-2">
            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">2. Scan QRIS (Semua E-Wallet / Bank)</div>
            <div class="flex items-center gap-3 pt-1">
              <div class="w-16 h-16 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center p-1 shrink-0">
                <i class="fa fa-qrcode text-4xl text-slate-700"></i>
              </div>
              <div class="text-xs text-slate-600">
                <div>Dukung <b>GoPay, OVO, DANA, BCA, Mandiri, ShopeePay</b>.</div>
                <a href="https://wa.me/6285767629211?text=Halo%20Admin,%20saya%20ingin%20meminta%20gambar%20QRIS%20resmi%20pembayaran%20CBT%20Abdi%20Praja" target="_blank" class="text-indigo-600 hover:underline font-bold inline-block mt-1">Minta Gambar QRIS via WA ↗</a>
              </div>
            </div>
          </div>
        </div>

        <div class="text-xs text-slate-600 bg-white p-3.5 rounded-xl border border-slate-200 flex items-center gap-2.5">
          <i class="fa fa-info-circle text-indigo-500 text-base shrink-0"></i>
          <span>Setelah melakukan transfer / scan QRIS, kirimkan bukti transfer ke <b>WhatsApp Admin (0857-6762-9211)</b> untuk langsung mendapatkan kode aktivasi akun Anda.</span>
        </div>
      </div>

      <!-- FORM AKTIVASI KODE VOUCHER (INSTANT 1-CLICK ACTIVATION) -->
      <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 sm:p-6">
        <div class="flex items-center gap-3 mb-2">
          <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm shrink-0">
            <i class="fa fa-key"></i>
          </div>
          <div>
            <span class="text-xs sm:text-sm font-bold text-slate-800 uppercase tracking-wider">Sudah Memiliki Kode Voucher?</span>
            <p class="text-xs text-slate-500 mt-0.5">Masukkan kode voucher Anda untuk langsung mengaktifkan langganan Anda secara instan.</p>
          </div>
        </div>
        <form action="{{ url('/crud/aktivasi') }}" method="POST" class="mt-4 flex flex-col sm:flex-row gap-3">
          {{ csrf_field() }}
          <input type="text" id="kode_voucher_input" name="kode_voucher" required class="flex-1 px-4 py-3 text-sm font-mono tracking-wider rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition bg-white" placeholder="Contoh: ABDI-3B-XXXXXX">
          <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs sm:text-sm uppercase tracking-wider transition shadow-sm shrink-0 flex items-center justify-center gap-2 cursor-pointer">
            <i class="fa fa-check"></i> Aktifkan Lisensi
          </button>
        </form>
      </div>

      <!-- LINK INFO BIMBEL UTAMA -->
      <div class="text-center pt-1">
        <a href="https://abdipraja.id/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-slate-600 hover:text-indigo-600 transition">
          <i class="fa fa-globe text-indigo-500"></i>
          <span>Informasi Pendaftaran Program Bimbingan Offline/Tatap Muka di abdipraja.id ↗</span>
        </a>
      </div>

    </div>

    <!-- MODAL FOOTER (TIDAK KETUTUPAN) -->
    <div class="px-5 sm:px-7 py-3.5 sm:py-4 border-t border-slate-100 bg-slate-50 flex flex-col sm:flex-row items-center justify-between gap-3 shrink-0">
      <div class="text-xs text-slate-500 flex items-center gap-1.5">
        <i class="fa fa-shield text-indigo-500"></i>
        <span>Layanan Bantuan &amp; Konfirmasi: WhatsApp <strong>0857-6762-9211</strong> (09.00 - 21.00 WIB)</span>
      </div>
      <button type="button" id="btn-tutup-modal-voucher" onclick="tutupModalVoucher()" class="px-5 py-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-bold text-xs uppercase tracking-wider transition cursor-pointer shadow-sm">
        Tutup
      </button>
    </div>

  </div>
</div>

<script>
  function bukaModalVoucher(title, harga, forceTab) {
    const lockedNotice = document.getElementById('modal-locked-notice');
    if (title && title !== 'Aktivasi Keanggotaan Bimbingan Belajar' && title !== 'Aktivasi Voucher Bimbingan Belajar' && title !== 'All-Access Pass CBT') {
      document.getElementById('modal-paket-title').textContent = title;
      if (lockedNotice) lockedNotice.style.display = 'flex';
    } else {
      if (lockedNotice) lockedNotice.style.display = 'none';
    }

    document.getElementById('modal-voucher').style.display = 'flex';

    if (forceTab === 'voucher') {
      setTimeout(function() {
        const inp = document.getElementById('kode_voucher_input');
        if (inp) {
          inp.focus();
          inp.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      }, 150);
    }
  }

  function tutupModalVoucher() {
    document.getElementById('modal-voucher').style.display = 'none';
  }

  function bukaDetailBayar(namaPaket, harga) {
    document.getElementById('bayar_paket_label').textContent = namaPaket + ' (' + harga + ')';
    $('#section-detail-pembayaran').slideDown();
    setTimeout(function() {
      document.getElementById('section-detail-pembayaran').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 150);
  }

  function salinRekening() {
    const rek = document.getElementById('nomor_rekening').textContent.trim();
    navigator.clipboard.writeText(rek).then(function() {
      const btn = document.getElementById('btn-salin-text');
      btn.textContent = 'Tersalin!';
      setTimeout(function() {
        btn.textContent = 'Salin';
      }, 2000);
    });
  }
</script>
