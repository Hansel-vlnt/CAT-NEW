@extends('layouts.app')
@section('title', 'Ubah Paket: ' . $soal->paket . ' - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="px-4 py-2">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Bank Soal &bull; Paket</div>
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">Ubah Informasi Paket Soal</h1>
  </div>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="max-w-4xl mx-auto space-y-6">

    <!-- HERO HEADER -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-lg">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
            Edit Paket Latihan
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">{{ $soal->paket }}</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            Sesuaikan nama paket, deskripsi, durasi pengerjaan, dan password token.
          </p>
        </div>
        <div>
          <button onclick="self.history.back()" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold border border-white/20 transition flex items-center gap-2">
            <i class="fa fa-arrow-left"></i> Kembali
          </button>
        </div>
      </div>
    </div>

    <!-- FORM CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <form id="formSoal" class="space-y-5 max-w-2xl">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$soal->id}}">

        <div>
          <label for="paket" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Paket Soal</label>
          <input id="paket" type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" name="paket" placeholder="Contoh: Try Out Akbar SKD CPNS 2026" value="{{ $soal->paket }}">
        </div>

        <div>
          <label for="deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
          <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" placeholder="Deskripsi materi cakupan soal">{{ $soal->deskripsi }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="kategori_utama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kategori Utama</label>
            <select id="kategori_utama" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" name="kategori_utama">
              <option value="Kedinasan & Polri (SKD BKN/Akademik)" {{ ($soal->kategori_utama == 'Kedinasan & Polri (SKD BKN/Akademik)' || empty($soal->kategori_utama)) ? 'selected' : '' }}>Kedinasan &amp; Polri (SKD BKN/Akademik)</option>
              <option value="SMA & UTBK (SNBT)" {{ ($soal->kategori_utama == 'SMA & UTBK (SNBT)') ? 'selected' : '' }}>SMA &amp; UTBK (SNBT)</option>
            </select>
          </div>

          <div>
            <label for="sub_kategori" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sub Kategori</label>
            <input id="sub_kategori" type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" name="sub_kategori" placeholder="Contoh: TIU, TWK, TKP, Kuantitatif" value="{{ $soal->sub_kategori }}">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div>
            <label for="waktu" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Waktu (Detik)</label>
            <input id="waktu" type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition numOnly" name="waktu" placeholder="6000" value="{{ $soal->waktu }}">
            <span class="text-[11px] text-slate-400 mt-1 block">Setara {{ round($soal->waktu / 60) }} menit</span>
          </div>

          <div>
            <label for="jenis" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Model Waktu</label>
            <select id="jenis" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" name="jenis">
              <option value="0" @if($soal->jenis_soal == 0) selected @endif>Total Waktu Paket</option>
              <option value="1" @if($soal->jenis_soal == 1) selected @endif>Waktu Per Nomor</option>
            </select>
          </div>

          <div>
            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password Token</label>
            <input id="password" type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" name="password" placeholder="Kosongkan jika tanpa token" value="{{ $soal->password }}">
          </div>
        </div>

        <div id="notif" style="display: none;" class="p-3.5 rounded-xl text-xs font-semibold"></div>

        <div class="pt-4 border-t border-slate-100 flex items-center gap-3" id="wrap-btn">
          <button type="button" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm" id="btnSimpan">
            Simpan Perubahan Paket
          </button>
          <button type="button" class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition" onclick="self.history.back()">
            Batal
          </button>
        </div>
      </form>
    </div>

  </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function(){
  $("#btnSimpan").click(function(){
    var dataString = $("#formSoal").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/simpan-soal') }}",
      data: dataString,
      success: function(data){
        if (data == 'ok') {
          $("#notif").removeClass('bg-red-50 text-red-700').addClass('bg-emerald-50 text-emerald-800 border border-emerald-200').html("✓ Data paket berhasil disimpan.").show();
          setTimeout(function() {
            window.location.href = "{{ url('elearning/soal/detail/'.$soal->id) }}";
          }, 600);
        } else {
          $("#notif").removeClass('bg-emerald-50 text-emerald-800').addClass('bg-red-50 text-red-700 border border-red-200').html(data).show();
        }
      }
    });
  });
});
</script>
@endpush