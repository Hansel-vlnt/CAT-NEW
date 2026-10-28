@extends('layouts.app')
@section('title', 'Manajemen Paket Langganan')
@section('breadcrumb')
  <div class="w-full">
    <h1 class="text-2xl font-black text-slate-900 mt-0.5">Manajemen Paket Langganan CBT</h1>
  </div>
@endsection

@section('content')
<div class="col-md-12">
  <div class="max-w-7xl mx-auto space-y-6">

    @if(Session::has('success'))
      <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
          <i class="fa fa-check-circle text-emerald-600 text-lg"></i>
          <span>{{ Session::get('success') }}</span>
        </div>
        <button type="button" class="text-emerald-500 hover:text-emerald-700" onclick="this.parentElement.remove()">✕</button>
      </div>
    @endif

    @if(Session::has('error'))
      <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
          <i class="fa fa-exclamation-circle text-rose-600 text-lg"></i>
          <span>{{ Session::get('error') }}</span>
        </div>
        <button type="button" class="text-rose-500 hover:text-rose-700" onclick="this.parentElement.remove()">✕</button>
      </div>
    @endif

    <!-- CARD UTAMA -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
        <div>
          <h2 class="text-xl font-bold text-slate-900 tracking-tight">Daftar Paket All-Access Pass</h2>
          <p class="text-sm text-slate-500 mt-1">
            Atur durasi bulan, harga, label promo, dan benefit fitur untuk paket langganan yang dapat dipilih siswa di katalog.
          </p>
        </div>
        <div>
          <button type="button" class="py-3 px-5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-indigo-600/20 transition flex items-center gap-2 cursor-pointer" data-toggle="modal" data-target="#modal-tambah-paket">
            <i class="fa fa-plus-circle"></i>
            <span>Tambah Paket Custom</span>
          </button>
        </div>
      </div>

      <!-- TABEL DAFTAR PAKET -->
      <div class="mt-6 overflow-x-auto">
        <table class="table table-hover table-striped" id="table_paket" style="width: 100%;">
          <thead>
            <tr class="text-slate-600 text-xs font-bold uppercase tracking-wider bg-slate-50">
              <th style="width: 50px; text-align: center; padding: 14px 10px;">Urut</th>
              <th style="min-width: 220px; padding: 14px 16px;">Paket &amp; Promo</th>
              <th style="min-width: 130px; padding: 14px 16px; text-align: center;">Durasi</th>
              <th style="min-width: 160px; padding: 14px 16px;">Harga</th>
              <th style="min-width: 240px; padding: 14px 16px;">Fitur &amp; Fasilitas</th>
              <th style="width: 100px; text-align: center; padding: 14px 10px;">Status</th>
              <th style="min-width: 180px; text-align: center; padding: 14px 16px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pakets as $p)
              <tr class="align-middle">
                <td class="text-center font-bold text-slate-400">{{ $p->urutan ?: $loop->iteration }}</td>
                <td style="padding: 14px 16px;">
                  <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-bold text-slate-900 text-sm">{{ $p->nama_paket }}</span>
                    @if($p->badge)
                      <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200">
                        {{ $p->badge }}
                      </span>
                    @endif
                  </div>
                  @if($p->deskripsi)
                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $p->deskripsi }}</p>
                  @endif
                </td>
                <td class="text-center" style="padding: 14px 16px;">
                  <div class="inline-flex flex-col items-center">
                    <span class="px-3 py-1 rounded-xl bg-indigo-50 text-indigo-700 font-extrabold text-xs border border-indigo-200/80">
                      {{ $p->durasi_bulan }} Bulan
                    </span>
                    <span class="text-[11px] text-slate-400 mt-0.5 font-medium">({{ $p->durasi_hari }} Hari)</span>
                  </div>
                </td>
                <td style="padding: 14px 16px;">
                  <div class="font-black text-slate-900 text-sm">{{ $p->formatted_harga }}</div>
                  @if($p->harga_coret && $p->harga_coret > $p->harga)
                    <div class="flex items-center gap-1.5 text-xs mt-0.5">
                      <span class="line-through text-slate-400">{{ $p->formatted_harga_coret }}</span>
                      <span class="text-emerald-600 font-bold">Hemat {{ $p->getHematPersen() }}%</span>
                    </div>
                  @endif
                </td>
                <td style="padding: 14px 16px;">
                  @php $fiturs = $p->getFiturArray(); @endphp
                  @if(count($fiturs) > 0)
                    <ul class="text-xs text-slate-600 space-y-1">
                      @foreach(array_slice($fiturs, 0, 3) as $f)
                        <li class="flex items-start gap-1.5">
                          <i class="fa fa-check text-emerald-500 mt-0.5 shrink-0 text-[10px]"></i>
                          <span class="line-clamp-1">{{ $f }}</span>
                        </li>
                      @endforeach
                      @if(count($fiturs) > 3)
                        <li class="text-[11px] text-slate-400 italic font-medium">+{{ count($fiturs) - 3 }} fasilitas lainnya...</li>
                      @endif
                    </ul>
                  @else
                    <span class="text-xs text-slate-400 italic">Belum ada rincian fasilitas</span>
                  @endif
                </td>
                <td class="text-center" style="padding: 14px 10px;">
                  <button type="button" onclick="toggleStatusPaket({{ $p->id }})" class="cursor-pointer" title="Klik untuk ubah status">
                    @if($p->is_aktif)
                      <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                        Aktif
                      </span>
                    @else
                      <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                        Nonaktif
                      </span>
                    @endif
                  </button>
                </td>
                <td class="text-center" style="padding: 14px 16px;">
                  <div class="flex items-center justify-center gap-1.5 flex-wrap">
                    <button type="button" class="btn btn-default btn-xs" title="Buat Voucher untuk Paket Ini" onclick='bukaModalVoucherPaket({{ json_encode($p) }})'>
                      <i class="fa fa-id-card text-amber-600"></i> +Voucher
                    </button>
                    <button type="button" class="btn btn-default btn-xs" title="Edit Paket" onclick='bukaModalEditPaket({{ json_encode($p) }})'>
                      <i class="fa fa-pencil text-blue-600"></i> Ubah
                    </button>
                    <button type="button" class="btn btn-danger btn-xs" title="Hapus Paket" onclick="konfirmasiHapusPaket({{ $p->id }}, '{{ addslashes($p->nama_paket) }}')">
                      <i class="fa fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-10 text-slate-500">
                  <div class="max-w-sm mx-auto space-y-2">
                    <i class="fa fa-cubes text-3xl text-slate-300"></i>
                    <p class="font-semibold text-slate-700">Belum ada paket langganan.</p>
                    <p class="text-xs text-slate-400">Klik tombol "Tambah Paket Custom" untuk membuat paket akses pass baru.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- ================= MODAL TAMBAH PAKET ================= -->
<div class="modal fade" id="modal-tambah-paket" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
      <div class="modal-header" style="padding: 20px 24px; background: #0f172a; color: white;">
        <button type="button" class="close text-white opacity-80 hover:opacity-100" data-dismiss="modal">&times;</button>
        <h4 class="modal-title font-bold text-white text-base flex items-center gap-2">
          <i class="fa fa-plus-circle text-indigo-400"></i> Tambah Paket Langganan Custom
        </h4>
      </div>
      <form action="{{ route('paket-langganan.store') }}" method="POST" class="p-6 space-y-5">
        {{ csrf_field() }}

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="sm:col-span-2">
            <label for="nama_paket" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Paket *</label>
            <input type="text" name="nama_paket" id="nama_paket" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" placeholder="Contoh: Pass 3 Bulan - Intensif Kedinasan">
          </div>
          <div>
            <label for="badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Badge Promo (Opsional)</label>
            <input type="text" name="badge" id="badge" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" placeholder="Contoh: Paling Populer, Hemat 50%">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="durasi_bulan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Durasi Bulan *</label>
            <div class="flex items-center gap-2">
              <input type="number" min="1" max="60" name="durasi_bulan" id="durasi_bulan" value="3" required oninput="hitungHariOtomatis('tambah')" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-semibold">
              <span class="text-sm font-bold text-slate-500">Bulan</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Admin bebas menentukan jumlah bulan berapa pun.</p>
          </div>
          <div>
            <label for="durasi_hari" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Durasi Hari (Aktual)</label>
            <div class="flex items-center gap-2">
              <input type="number" min="1" name="durasi_hari" id="durasi_hari" value="90" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-semibold">
              <span class="text-sm font-bold text-slate-500">Hari</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Dihitung otomatis (Bulan × 30), namun tetap bisa diubah manual.</p>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="harga" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Harga Bayar (Rp) *</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 font-bold text-sm">Rp</span>
              <input type="number" min="0" step="1000" name="harga" id="harga" required class="w-full pl-11 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-bold text-slate-900" placeholder="99000">
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Harga yang dibayarkan siswa.</p>
          </div>
          <div>
            <label for="harga_coret" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Harga Coret / Normal (Rp)</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 font-bold text-sm">Rp</span>
              <input type="number" min="0" step="1000" name="harga_coret" id="harga_coret" class="w-full pl-11 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition text-slate-500" placeholder="199000">
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Opsional: Ditampilkan dicoret untuk efek promo/diskon.</p>
          </div>
        </div>

        <div>
          <label for="deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
          <input type="text" name="deskripsi" id="deskripsi" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" placeholder="Contoh: Paket paling diminati untuk persiapan matang dari nol sampai siap tes.">
        </div>

        <div>
          <label for="fitur" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Daftar Fitur &amp; Fasilitas (Satu baris per poin)</label>
          <textarea name="fitur" id="fitur" rows="4" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-sans" placeholder="Akses Semua 30+ Tryout SKD CAT Kedinasan&#10;Kunci Jawaban &amp; Pembahasan Lengkap&#10;Seluruh Modul Materi &amp; Rangkuman E-Book&#10;Simulasi Ranking Nasional"></textarea>
          <p class="text-[11px] text-slate-400 mt-1">Setiap baris baru akan otomatis ditampilkan sebagai checklist centang hijau di kartu siswa.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
          <div>
            <label for="urutan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Urutan Tampil</label>
            <input type="number" min="0" name="urutan" id="urutan" value="1" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-semibold">
          </div>
          <div class="flex items-center pt-6">
            <label class="inline-flex items-center gap-2 cursor-pointer">
              <input type="checkbox" name="is_aktif" value="1" checked class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
              <span class="text-sm font-bold text-slate-700">Aktifkan di Katalog Siswa</span>
            </label>
          </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
          <button type="button" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition" data-dismiss="modal">Batal</button>
          <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-md">Simpan Paket</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ================= MODAL EDIT PAKET ================= -->
<div class="modal fade" id="modal-edit-paket" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
      <div class="modal-header" style="padding: 20px 24px; background: #0f172a; color: white;">
        <button type="button" class="close text-white opacity-80 hover:opacity-100" data-dismiss="modal">&times;</button>
        <h4 class="modal-title font-bold text-white text-base flex items-center gap-2">
          <i class="fa fa-pencil text-indigo-400"></i> Ubah Paket Langganan Custom
        </h4>
      </div>
      <form id="form-edit-paket" method="POST" class="p-6 space-y-5">
        {{ csrf_field() }}

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div class="sm:col-span-2">
            <label for="edit_nama_paket" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Paket *</label>
            <input type="text" name="nama_paket" id="edit_nama_paket" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition">
          </div>
          <div>
            <label for="edit_badge" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Badge Promo</label>
            <input type="text" name="badge" id="edit_badge" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="edit_durasi_bulan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Durasi Bulan *</label>
            <div class="flex items-center gap-2">
              <input type="number" min="1" max="60" name="durasi_bulan" id="edit_durasi_bulan" required oninput="hitungHariOtomatis('edit')" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-semibold">
              <span class="text-sm font-bold text-slate-500">Bulan</span>
            </div>
          </div>
          <div>
            <label for="edit_durasi_hari" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Durasi Hari (Aktual)</label>
            <div class="flex items-center gap-2">
              <input type="number" min="1" name="durasi_hari" id="edit_durasi_hari" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-semibold">
              <span class="text-sm font-bold text-slate-500">Hari</span>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="edit_harga" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Harga Bayar (Rp) *</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 font-bold text-sm">Rp</span>
              <input type="number" min="0" step="1000" name="harga" id="edit_harga" required class="w-full pl-11 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-bold text-slate-900">
            </div>
          </div>
          <div>
            <label for="edit_harga_coret" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Harga Coret / Normal (Rp)</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 font-bold text-sm">Rp</span>
              <input type="number" min="0" step="1000" name="harga_coret" id="edit_harga_coret" class="w-full pl-11 pr-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition text-slate-500">
            </div>
          </div>
        </div>

        <div>
          <label for="edit_deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
          <input type="text" name="deskripsi" id="edit_deskripsi" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition">
        </div>

        <div>
          <label for="edit_fitur" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Daftar Fitur &amp; Fasilitas (Satu baris per poin)</label>
          <textarea name="fitur" id="edit_fitur" rows="4" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-sans"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
          <div>
            <label for="edit_urutan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Urutan Tampil</label>
            <input type="number" min="0" name="urutan" id="edit_urutan" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-semibold">
          </div>
          <div class="flex items-center pt-6">
            <label class="inline-flex items-center gap-2 cursor-pointer">
              <input type="checkbox" name="is_aktif" id="edit_is_aktif" value="1" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
              <span class="text-sm font-bold text-slate-700">Aktifkan di Katalog Siswa</span>
            </label>
          </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
          <button type="button" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition" data-dismiss="modal">Batal</button>
          <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-md">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ================= MODAL GENERATE VOUCHER PAKET ================= -->
<div class="modal fade" id="modal-voucher-paket" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
      <div class="modal-header" style="padding: 20px 24px; background: #0f172a; color: white;">
        <button type="button" class="close text-white opacity-80 hover:opacity-100" data-dismiss="modal">&times;</button>
        <h4 class="modal-title font-bold text-white text-base flex items-center gap-2">
          <i class="fa fa-id-card text-amber-400"></i> Generate Voucher untuk Paket
        </h4>
      </div>
      <form id="form-voucher-paket" method="POST" class="p-6 space-y-4">
        {{ csrf_field() }}

        <div class="p-4 rounded-2xl bg-indigo-50 border border-indigo-200">
          <div class="text-xs text-indigo-600 font-bold uppercase tracking-wider">Paket Terpilih</div>
          <div class="text-base font-black text-slate-900 mt-0.5" id="voucher_paket_nama">-</div>
          <div class="text-xs text-slate-600 mt-1 flex items-center gap-3">
            <span><i class="fa fa-calendar text-indigo-500"></i> Durasi: <strong id="voucher_paket_durasi">-</strong></span>
            <span><i class="fa fa-tag text-indigo-500"></i> Harga: <strong id="voucher_paket_harga">-</strong></span>
          </div>
        </div>

        <div>
          <label for="jumlah_voucher" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jumlah Voucher yang Ingin Dibuat</label>
          <input type="number" min="1" max="50" name="jumlah" id="jumlah_voucher" value="1" required class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-semibold">
          <p class="text-[11px] text-slate-400 mt-1">Voucher yang dibuat akan otomatis memiliki masa berlaku sesuai durasi hari paket tersebut.</p>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
          <button type="button" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition" data-dismiss="modal">Batal</button>
          <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-wider transition shadow-md flex items-center gap-2">
            <i class="fa fa-magic"></i> Generate Voucher
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- FORM DELETE HIDDEN -->
<form id="form-delete-paket" method="POST" style="display: none;">
  {{ csrf_field() }}
  <input type="hidden" name="_method" value="DELETE">
</form>
@endsection

@push('scripts')
<script>
  function hitungHariOtomatis(mode) {
    if (mode === 'tambah') {
      const bulan = parseInt(document.getElementById('durasi_bulan').value) || 1;
      document.getElementById('durasi_hari').value = bulan * 30;
    } else {
      const bulan = parseInt(document.getElementById('edit_durasi_bulan').value) || 1;
      document.getElementById('edit_durasi_hari').value = bulan * 30;
    }
  }

  function bukaModalEditPaket(paket) {
    document.getElementById('form-edit-paket').action = "{{ url('paket-langganan/update') }}/" + paket.id;
    document.getElementById('edit_nama_paket').value = paket.nama_paket || '';
    document.getElementById('edit_badge').value = paket.badge || '';
    document.getElementById('edit_durasi_bulan').value = paket.durasi_bulan || 1;
    document.getElementById('edit_durasi_hari').value = paket.durasi_hari || 30;
    document.getElementById('edit_harga').value = paket.harga || 0;
    document.getElementById('edit_harga_coret').value = paket.harga_coret || '';
    document.getElementById('edit_deskripsi').value = paket.deskripsi || '';
    document.getElementById('edit_fitur').value = paket.fitur || '';
    document.getElementById('edit_urutan').value = paket.urutan || 0;
    document.getElementById('edit_is_aktif').checked = paket.is_aktif ? true : false;
    $('#modal-edit-paket').modal('show');
  }

  function bukaModalVoucherPaket(paket) {
    document.getElementById('form-voucher-paket').action = "{{ url('paket-langganan/generate-vouchers') }}/" + paket.id;
    document.getElementById('voucher_paket_nama').textContent = paket.nama_paket;
    document.getElementById('voucher_paket_durasi').textContent = paket.durasi_bulan + ' Bulan (' + paket.durasi_hari + ' Hari)';
    document.getElementById('voucher_paket_harga').textContent = 'Rp ' + Number(paket.harga).toLocaleString('id-ID');
    document.getElementById('jumlah_voucher').value = 1;
    $('#modal-voucher-paket').modal('show');
  }

  function toggleStatusPaket(id) {
    $.ajax({
      url: "{{ url('paket-langganan/toggle-status') }}/" + id,
      type: "POST",
      data: {
        _token: "{{ csrf_token() }}"
      },
      success: function(res) {
        if (res.success) {
          window.location.reload();
        }
      },
      error: function() {
        swal({
          title: "Gagal!",
          text: "Terjadi kesalahan saat mengubah status paket.",
          type: "error"
        });
      }
    });
  }

  function konfirmasiHapusPaket(id, nama) {
    swal({
      title: "Hapus Paket Langganan?",
      text: "Apakah Anda yakin ingin menghapus paket \"" + nama + "\"? Paket ini tidak akan muncul lagi di katalog siswa.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#dc2626",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
    }).then(function(result) {
      if (result && (result.value || result.isConfirmed)) {
        const form = document.getElementById('form-delete-paket');
        form.action = "{{ url('paket-langganan') }}/" + id;
        form.submit();
      }
    });
  }
</script>
@endpush
