@extends('layouts.app')
@section('title', "Materi Belajar - Latihan Soal Abdi Praja")
@section('breadcrumb')
  <div class="w-full">
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">Modul &amp; Materi Pembelajaran</h1>
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

    <!-- HERO WELCOME BANNER -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-lg">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div class="flex items-center gap-2 mb-2">
            @if(Auth::user()->isLanggananLes())
              <span class="px-3 py-1 rounded-full bg-amber-500 text-slate-900 text-xs font-black uppercase tracking-wider shadow-sm flex items-center gap-1.5">
                👑 Siswa Les Aktif @if(Auth::user()->tgl_berakhir_les) (s/d {{ date('d-m-Y', strtotime(Auth::user()->tgl_berakhir_les)) }}) @endif
              </span>
            @else
              <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
                Siswa Reguler (Akses Gratis)
              </span>
            @endif
          </div>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Pusat Belajar &amp; Modul Referensi</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            Pelajari modul rangkuman materi SKD Kedinasan dan UTBK-SNBT sebelum mencoba simulasi latihan soal.
          </p>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
          <a href="{{ url('siswa/ujian') }}" class="px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-md flex items-center gap-2">
            <i class="fa fa-play-circle"></i> Buka Katalog Soal &rarr;
          </a>
          @if(!Auth::user()->isLanggananLes())
            <button type="button" onclick="bukaModalVoucher('Aktivasi Voucher Bimbingan Belajar', 0)" class="px-4 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-wider transition shadow-md flex items-center gap-1.5 cursor-pointer">
              <i class="fa fa-key"></i> Aktivasi Lisensi
            </button>
          @endif
        </div>
      </div>
    </div>

    <!-- MATERI TABLE CARD (FULL WIDTH) -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
        <div>
          <h3 class="text-xl font-bold text-slate-900 tracking-tight">Materi &amp; Panduan Belajar</h3>
          <p class="text-sm text-slate-500 mt-1">Pilih salah satu judul materi untuk membaca modul lengkap.</p>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover table-striped" id="table_soal" style="width: 100%;">
          <thead>
            <tr class="text-slate-600 text-xs font-bold uppercase tracking-wider bg-slate-50">
              <th style="padding: 14px 16px;">Judul Materi</th>
              <th style="padding: 14px 16px; text-align: center; width: 180px;">Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
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
          <h3 class="text-base font-bold text-slate-900 tracking-tight" id="modal-paket-title">Modul Khusus Siswa Les</h3>
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
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
@endpush
@push('scripts')
<script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script>
function bukaModalVoucher(title, harga) {
  if (title) {
    document.getElementById('modal-paket-title').textContent = title;
  }
  document.getElementById('modal-voucher').style.display = 'flex';
  setTimeout(function() {
    document.getElementById('kode_voucher_input').focus();
  }, 150);
}

function tutupModalVoucher() {
  document.getElementById('modal-voucher').style.display = 'none';
}

$(document).ready(function (){
  $('#table_soal').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    pageLength: 10,
    language: {
      search: "Cari materi:",
      lengthMenu: "Tampilkan _MENU_ per halaman",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ materi",
      paginate: {
        first: "Awal",
        last: "Akhir",
        next: "Lanjut",
        previous: "Sebelum"
      }
    },
    ajax: {
      url: '{!! route('siswa.materi') !!}',
    },
    columns: [
      {data: 'judul', name: 'judul', orderable: true, searchable: true },
      {data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" },
    ],
    drawCallback: function (setting) {}
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      tutupModalVoucher();
    }
  });
});
</script>
@endpush