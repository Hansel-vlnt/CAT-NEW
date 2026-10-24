@extends('layouts.app')
@section('title', 'Data Bank Soal - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="w-full">
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">Kelola Paket Latihan Soal</h1>
  </div>
@endsection
@section('content')
<div class="col-md-12">
  <div class="max-w-6xl mx-auto space-y-6">

    <!-- COMPACT ACTION HEADER -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Katalog Paket Latihan &amp; Tryout</h2>
        <p class="text-sm text-slate-500 mt-1">
          Kelola paket soal (Kedinasan / UTBK SMA), atur durasi pengerjaan, KKM, dan butir pertanyaan.
        </p>
      </div>
      <div class="flex items-center gap-2 flex-wrap">
        <button type="button" id="btn-soal" class="px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm transition shadow-sm flex items-center gap-2 cursor-pointer">
          <i class="fa fa-plus-circle"></i> <span>Buat Paket Soal Baru</span>
        </button>
      </div>
    </div>

    <!-- FORM BUAT PAKET BARU (COLLAPSIBLE) -->
    <div style="display: none;" id="wrap-soal" class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="pb-4 border-b border-slate-100 mb-6 flex items-center justify-between">
        <div>
          <h3 class="text-lg font-bold text-slate-900">Formulir Paket Latihan Baru</h3>
          <p class="text-xs text-slate-500 mt-0.5">Lengkapi identitas paket latihan soal sebelum menambahkan butir soal.</p>
        </div>
        <button type="button" id="btnbatal" class="text-slate-400 hover:text-slate-600 text-sm font-bold cursor-pointer">✕ Tutup</button>
      </div>

      <form id="formSoal" class="space-y-5 w-full">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="N">

        <div>
          <label for="paket" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Paket Soal</label>
          <input id="paket" type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" name="paket" placeholder="Contoh: Tryout SKD Kedinasan Paket 01">
        </div>

        <div>
          <label for="deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
          <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" placeholder="Tuliskan materi yang diujikan dalam paket ini"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div>
            <label for="kategori_utama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Utama</label>
            <select id="kategori_utama" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" name="kategori_utama">
              <option value="Kedinasan & Polri (SKD BKN/Akademik)" selected>Kedinasan &amp; Polri (SKD BKN/Akademik)</option>
              <option value="SMA & UTBK (SNBT)">SMA &amp; UTBK (SNBT)</option>
            </select>
          </div>

          <div>
            <label for="sub_kategori" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sub Kategori</label>
            <input id="sub_kategori" type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" name="sub_kategori" placeholder="Contoh: TIU, TWK, TKP, Kuantitatif">
          </div>

          <div>
            <label for="tipe_akses" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tipe Akses</label>
            <select id="tipe_akses" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition bg-white" name="tipe_akses">
              <option value="gratis" selected>🟢 Gratis / Public Trial</option>
              <option value="berbayar">🔒 Berbayar / Khusus Les</option>
            </select>
          </div>

          <div id="wrap_harga">
            <label for="harga" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Harga Paket (Rp)</label>
            <input id="harga" type="number" min="0" step="5000" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" name="harga" placeholder="0" value="0">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 items-start">
          <div>
            <label for="waktu_menit" class="block text-sm font-bold text-slate-700 mb-1.5 whitespace-nowrap">Durasi Waktu</label>
            <div class="relative">
              <input id="waktu_menit" type="number" min="1" class="w-full px-4 py-2.5 sm:py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition h-[46px]" placeholder="Contoh: 90" value="90">
              <input type="hidden" name="waktu" id="waktu" value="5400">
            </div>
            <p class="text-xs text-slate-500 mt-1" id="waktu-detik-info">Menit (= 5.400 detik)</p>
          </div>

          <div>
            <label for="kkm" class="block text-sm font-bold text-slate-700 mb-1.5 whitespace-nowrap">KKM</label>
            <input id="kkm" type="number" min="0" max="100" class="w-full px-4 py-2.5 sm:py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition h-[46px]" name="kkm" value="70" placeholder="Contoh: 70">
            <p class="text-xs text-slate-500 mt-1">Batas nilai (0 - 100)</p>
          </div>

          <div>
            <label for="jenis" class="block text-sm font-bold text-slate-700 mb-1.5 whitespace-nowrap">Waktu Ujian</label>
            <select id="jenis" class="w-full px-4 py-2.5 sm:py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition h-[46px] bg-white" name="jenis">
              <option value="0" selected>Total Waktu Paket</option>
              <option value="1">Waktu Per Nomor</option>
            </select>
            <p class="text-xs text-slate-500 mt-1">Hitungan timer</p>
          </div>

          <div>
            <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5 whitespace-nowrap">Password Token</label>
            <input id="password" type="text" class="w-full px-4 py-2.5 sm:py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition h-[46px]" name="password" placeholder="Kosongkan jika tanpa token">
            <p class="text-xs text-slate-500 mt-1">Opsional proteksi</p>
          </div>
        </div>

        <div id="notif" style="display: none;" class="p-3.5 rounded-xl text-xs font-semibold"></div>

        <div class="pt-4 border-t border-slate-100 flex items-center gap-3" id="wrap-btn">
          <button type="button" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm cursor-pointer" id="btnSimpan">
            Simpan &amp; Buat Paket
          </button>
          <button type="button" class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition cursor-pointer" onclick="$('#wrap-soal').slideUp();">
            Batal
          </button>
        </div>
      </form>
    </div>

    <!-- MAIN TABLE CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
        <div>
          <h3 class="text-lg font-bold text-slate-900">Daftar Paket Latihan</h3>
          <p class="text-xs text-slate-500 mt-0.5">Kelola butir soal, atur kunci jawaban dan pembahasan pada setiap paket.</p>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover table-striped" id="table_soal" style="width: 100%;">
          <thead>
            <tr class="text-slate-600 text-xs font-bold uppercase tracking-wider bg-slate-50">
              <th style="padding: 14px 16px; width: 60px;">ID</th>
              <th style="padding: 14px 16px;">Nama Paket</th>
              <th style="padding: 14px 16px;">Deskripsi</th>
              <th style="padding: 14px 16px; text-align: center; width: 90px;">Waktu</th>
              <th style="padding: 14px 16px; text-align: center; width: 110px;">Model</th>
              <th style="padding: 14px 16px; text-align: center; width: 110px;">Akses</th>
              <th style="padding: 14px 16px; text-align: center; width: 90px;">Token</th>
              <th style="padding: 14px 16px; text-align: center; width: 150px;">Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- MODAL HAPUS SOAL -->
<div class="modal fade" id="del-soal">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
      <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; padding: 18px 24px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-weight: 700; color: #0f172a;">Konfirmasi Hapus Paket Soal</h4>
      </div>
      <div class="modal-body" style="padding: 24px;">
        <form role="form" id="delete" action="{{ route('soal.paket.hapus') }}" method="post">
          @csrf
          @method('delete')
          <input type="hidden" id="id_soal" name="id_soal">
        </form>
        <p class="text-sm text-slate-600">
          Apakah Anda yakin ingin menghapus paket soal <b id="paket_soal" class="text-slate-900"></b> beserta seluruh butir soal di dalamnya?
        </p>
      </div>
      <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button id="button-delete" type="button" class="btn btn-danger" onclick="$('#delete').submit();">Ya, Hapus Paket</button>
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
$(document).ready(function (){
  table_soal = $('#table_soal').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    pageLength: 10,
    language: {
      search: "Cari paket:",
      lengthMenu: "Tampilkan _MENU_ per halaman",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ paket",
      paginate: {
        first: "Awal",
        last: "Akhir",
        next: "Lanjut",
        previous: "Sebelum"
      }
    },
    ajax: {
      url: '{!! route('elearning.get-soal') !!}',
    },
    columns: [
      {data: 'id', name: 'id', orderable: true, searchable: true, className: "font-mono font-bold text-slate-500" },
      {data: 'paket', name: 'paket', orderable: true, searchable: true, className: "font-bold text-slate-900 text-sm" },
      {data: 'deskripsi', name: 'deskripsi', orderable: true, searchable: true, className: "text-xs text-slate-500" },
      {data: 'waktu', name: 'waktu', orderable: true, searchable: true, className: "text-center font-bold text-xs" },
      {data: 'jenis', name: 'jenis', orderable: true, searchable: true, className: "text-center text-xs" },
      {data: 'tipe_akses', name: 'tipe_akses', orderable: true, searchable: true, className: "text-center" },
      {data: 'password', name: 'password', orderable: true, searchable: true, className: "text-center text-xs font-mono font-bold" },
      {data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" },
    ],
    drawCallback: function (setting) {}
  });

  $("#btn-soal").click(function() {
    $("#wrap-soal").slideToggle();
  });

  function toggleHarga() {
    if ($("#tipe_akses").val() === 'gratis') {
      $("#wrap_harga").hide();
      $("#harga").prop('disabled', true).val(0);
    } else {
      $("#wrap_harga").show();
      $("#harga").prop('disabled', false);
    }
  }
  $("#tipe_akses").on("change", toggleHarga);
  toggleHarga();

  $("#waktu_menit").on("input", function() {
    var menit = parseInt($(this).val()) || 0;
    var detik = menit * 60;
    $("#waktu").val(detik);
    $("#waktu-detik-info").text("= " + detik.toLocaleString('id-ID') + " detik");
  });

  $("#btnSimpan").click(function(){
    var dataString = $("#formSoal").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/simpan-soal') }}",
      data: dataString,
      success: function(data){
        if (data == 'ok') {
          $("#notif").removeClass('bg-red-50 text-red-700').addClass('bg-emerald-50 text-emerald-800 border border-emerald-200').html("✓ Paket soal berhasil dibuat.").show();
          setTimeout(function() {
            window.location.reload();
          }, 600);
        } else {
          $("#notif").removeClass('bg-emerald-50 text-emerald-800').addClass('bg-red-50 text-red-700 border border-red-200').html(data).show();
        }
      }
    });
  });
});

function deleteSoal(id_soal, paketSoal) {
  $("#id_soal").val(id_soal);
  $("#paket_soal").text(paketSoal);
}
</script>
@endpush