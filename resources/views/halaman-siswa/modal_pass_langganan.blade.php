<!-- MODAL PILIHAN PAKET PASS & AKTIVASI VOUCHER -->
<div id="modal-voucher" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-5">
  <div class="bg-white rounded-3xl max-w-4xl w-full p-5 sm:p-7 shadow-2xl border border-slate-100 relative my-auto max-h-[94vh] flex flex-col">
    
    <!-- MODAL HEADER -->
    <div class="flex items-start justify-between pb-4 border-b border-slate-100 shrink-0">
      <div class="flex items-center gap-3">
        <div class="w-11 h-11 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-200/80 flex items-center justify-center text-xl shrink-0">
          <i class="fa fa-diamond"></i>
        </div>
        <div>
          <h3 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
            <span>Pilihan Paket Pass &amp; Akses CBT</span>
          </h3>
          <p class="text-xs text-slate-500 mt-0.5" id="modal-paket-price">
            Pilih paket durasi pass untuk membuka akses seluruh simulasi tryout dan modul materi.
          </p>
        </div>
      </div>
      <button type="button" onclick="tutupModalVoucher()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-700 flex items-center justify-center text-sm font-bold transition cursor-pointer">✕</button>
    </div>

    <!-- LOCKED ITEM NOTICE (Hanya tampil jika siswa klik soal/materi yang terkunci) -->
    <div id="modal-locked-notice" style="display: none;" class="my-3 p-3.5 rounded-2xl bg-amber-50 border border-amber-200/80 flex items-center gap-3 shrink-0">
      <i class="fa fa-lock text-amber-600 text-lg shrink-0"></i>
      <div class="text-xs text-amber-900">
        Konten <strong id="modal-paket-title" class="font-bold">Paket Latihan</strong> membutuhkan keanggotaan aktif. Silakan pilih paket pass di bawah atau masukkan voucher Anda.
      </div>
    </div>

    <!-- MODAL BODY (SCROLLABLE) -->
    <div class="py-4 overflow-y-auto flex-1 space-y-6">
      
      <!-- PILIHAN PAKET PASS -->
      @if(isset($pakets_langganan) && count($pakets_langganan) > 0)
        <div>
          <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-1.5">
            <i class="fa fa-cubes text-indigo-600"></i>
            <span>Pilihan Paket Langganan All-Access</span>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($pakets_langganan as $pkg)
              @php
                $isPopular = !empty($pkg->badge) && (stripos($pkg->badge, 'populer') !== false || stripos($pkg->badge, 'terlaris') !== false);
                $fiturList = $pkg->getFiturArray();
                $waText = "Halo Admin Abdi Praja Edukasi, saya ingin berlangganan *" . $pkg->nama_paket . "* (" . $pkg->durasi_bulan . " Bulan, " . $pkg->formatted_harga . ") untuk akun email: " . (Auth::user() ? Auth::user()->email : '') . ". Mohon instruksi pembayarannya. Terima kasih.";
                $waUrl = "https://wa.me/6285767629211?text=" . urlencode($waText);
              @endphp
              <div class="rounded-2xl border {{ $isPopular ? 'border-indigo-500 bg-indigo-50/20 shadow-md ring-2 ring-indigo-500/20' : 'border-slate-200 bg-white hover:border-slate-300 shadow-sm' }} p-5 flex flex-col justify-between relative transition">
                
                @if($pkg->badge)
                  <div class="absolute -top-3 left-4">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $isPopular ? 'bg-indigo-600 text-white shadow-sm' : 'bg-amber-500 text-white shadow-sm' }}">
                      {{ $pkg->badge }}
                    </span>
                  </div>
                @endif

                <div class="space-y-3 pt-1">
                  <div>
                    <h4 class="font-extrabold text-slate-900 text-base tracking-tight">{{ $pkg->nama_paket }}</h4>
                    <span class="inline-flex items-center gap-1 mt-1 text-xs font-semibold px-2.5 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                      <i class="fa fa-clock-o"></i> Akses {{ $pkg->durasi_bulan }} Bulan ({{ $pkg->durasi_hari }} Hari)
                    </span>
                  </div>

                  <div class="pt-1">
                    <div class="text-2xl font-black text-slate-900">{{ $pkg->formatted_harga }}</div>
                    @if($pkg->harga_coret && $pkg->harga_coret > $pkg->harga)
                      <div class="flex items-center gap-2 text-xs mt-0.5">
                        <span class="line-through text-slate-400">{{ $pkg->formatted_harga_coret }}</span>
                        <span class="text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
                          Hemat {{ $pkg->getHematPersen() }}%
                        </span>
                      </div>
                    @endif
                  </div>

                  @if($pkg->deskripsi)
                    <p class="text-xs text-slate-500 line-clamp-2">{{ $pkg->deskripsi }}</p>
                  @endif

                  <!-- DAFTAR FASILITAS -->
                  @if(count($fiturList) > 0)
                    <div class="pt-2 border-t border-slate-100">
                      <div class="text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-2">Benefit Termasuk:</div>
                      <ul class="text-xs text-slate-600 space-y-1.5">
                        @foreach($fiturList as $ft)
                          <li class="flex items-start gap-2">
                            <i class="fa fa-check-circle text-emerald-500 mt-0.5 shrink-0 text-xs"></i>
                            <span class="text-slate-700 font-medium leading-snug">{{ $ft }}</span>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                </div>

                <!-- CTA BUTTON -->
                <div class="pt-4 mt-4 border-t border-slate-100">
                  <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="w-full py-3 px-4 rounded-xl {{ $isPopular ? 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-md shadow-indigo-600/20' : 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm' }} font-bold text-xs uppercase tracking-wider transition flex items-center justify-center gap-2 text-center">
                    <i class="fa fa-whatsapp text-sm"></i>
                    <span>Beli via WhatsApp</span>
                  </a>
                </div>

              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- FORM AKTIVASI KODE VOUCHER (SELALU TERSEDIA) -->
      <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
        <div class="flex items-center gap-2 mb-2">
          <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xs">
            <i class="fa fa-key"></i>
          </div>
          <div>
            <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Sudah Memiliki Kode Voucher?</span>
            <p class="text-[11px] text-slate-500">Masukkan kode voucher Anda untuk langsung mengaktifkan masa berlaku paket.</p>
          </div>
        </div>
        <form action="{{ url('/crud/aktivasi') }}" method="POST" class="mt-3 flex flex-col sm:flex-row gap-2.5">
          {{ csrf_field() }}
          <input type="text" id="kode_voucher_input" name="kode_voucher" required class="flex-1 px-4 py-2.5 text-sm font-mono tracking-wider rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition bg-white" placeholder="Contoh: ABDI-3B-XXXXXX">
          <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm shrink-0 flex items-center justify-center gap-1.5 cursor-pointer">
            <i class="fa fa-check"></i> Aktifkan Lisensi
          </button>
        </form>
      </div>

      <!-- LINK INFO BIMBEL UTAMA -->
      <div class="text-center">
        <a href="https://abdipraja.id/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-indigo-600 transition">
          <i class="fa fa-globe text-indigo-500"></i>
          <span>Informasi Pendaftaran Program Bimbingan Offline/Tatap Muka di abdipraja.id ↗</span>
        </a>
      </div>

    </div>

    <!-- MODAL FOOTER -->
    <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 shrink-0">
      <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
        <i class="fa fa-shield text-indigo-500"></i>
        <span>Layanan Bantuan &amp; Konfirmasi: WhatsApp <strong>0857-6762-9211</strong> (09.00 - 21.00 WIB)</span>
      </div>
      <button type="button" onclick="tutupModalVoucher()" class="px-5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition cursor-pointer">
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

    if (harga > 0) {
      document.getElementById('modal-paket-price').textContent = 'Harga paket satuan: Rp ' + Number(harga).toLocaleString('id-ID');
    } else {
      document.getElementById('modal-paket-price').textContent = 'Pilih paket durasi pass untuk membuka akses seluruh simulasi tryout dan modul materi.';
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
</script>
