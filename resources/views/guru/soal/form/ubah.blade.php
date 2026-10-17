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

    <!-- COMPACT ACTION HEADER -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Edit Paket: {{ $soal->paket }}</h2>
        <p class="text-sm text-slate-500 mt-1">
          Sesuaikan nama paket, deskripsi, durasi pengerjaan, KKM passing grade, dan password token.
        </p>
      </div>
      <div>
        <button onclick="self.history.back()" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center gap-2 cursor-pointer">
          <i class="fa fa-arrow-left"></i> Kembali
        </button>
      </div>
    </div>

    <!-- FORM CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <form id="formSoal" class="space-y-6 w-full">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$soal->id}}">

        <div>
          <label for="paket" class="block text-sm font-bold text-slate-700 mb-1.5" style="line-height: 1.4;">Nama Paket Soal</label>
          <input id="paket" type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" name="paket" placeholder="Contoh: Try Out Akbar SKD CPNS 2026" value="{{ $soal->paket }}">
        </div>

        <div>
          <label for="deskripsi" class="block text-sm font-bold text-slate-700 mb-1.5" style="line-height: 1.4;">Deskripsi Singkat</label>
          <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" placeholder="Deskripsi materi cakupan soal">{{ $soal->deskripsi }}</textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <div>
            <label for="kategori_utama" class="block text-sm font-bold text-slate-700 mb-1.5" style="line-height: 1.4;">Kategori Utama</label>
            <select id="kategori_utama" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" name="kategori_utama">
              <option value="Kedinasan & Polri (SKD BKN/Akademik)" {{ ($soal->kategori_utama == 'Kedinasan & Polri (SKD BKN/Akademik)' || empty($soal->kategori_utama)) ? 'selected' : '' }}>Kedinasan &amp; Polri (SKD BKN/Akademik)</option>
              <option value="SMA & UTBK (SNBT)" {{ ($soal->kategori_utama == 'SMA & UTBK (SNBT)') ? 'selected' : '' }}>SMA &amp; UTBK (SNBT)</option>
            </select>
          </div>

          <div>
            <label for="sub_kategori" class="block text-sm font-bold text-slate-700 mb-1.5" style="line-height: 1.4;">Sub Kategori</label>
            <input id="sub_kategori" type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" name="sub_kategori" placeholder="Contoh: TIU, TWK, TKP, Kuantitatif" value="{{ $soal->sub_kategori }}">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          <div>
            <label for="waktu_menit" class="block text-sm font-bold text-slate-700 mb-1.5" style="line-height: 1.4;">Durasi Waktu</label>
            <div class="relative">
              <input id="waktu_menit" type="number" min="1" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" placeholder="90" value="{{ round($soal->waktu / 60) }}">
              <input type="hidden" name="waktu" id="waktu" value="{{ $soal->waktu }}">
            </div>
            <span class="text-xs text-slate-500 mt-1 block" id="waktu-detik-info">Menit (= {{ number_format($soal->waktu, 0, ',', '.') }} detik)</span>
          </div>

          <div>
            <label for="kkm" class="block text-sm font-bold text-slate-700 mb-1.5" style="line-height: 1.4;">Passing Grade (KKM)</label>
            <input id="kkm" type="number" min="0" max="100" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" name="kkm" value="{{ $soal->kkm ?? 70 }}" placeholder="Contoh: 70">
            <span class="text-xs text-slate-500 mt-1 block">Skala nilai 0 - 100</span>
          </div>

          <div>
            <label for="jenis" class="block text-sm font-bold text-slate-700 mb-1.5" style="line-height: 1.4;">Model Waktu Ujian</label>
            <select id="jenis" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" name="jenis">
              <option value="0" @if($soal->jenis_soal == 0) selected @endif>Total Waktu Paket</option>
              <option value="1" @if($soal->jenis_soal == 1) selected @endif>Waktu Per Nomor</option>
            </select>
            <span class="text-xs text-slate-500 mt-1 block">Hitungan timer</span>
          </div>

          <div>
            <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5" style="line-height: 1.4;">Password Token</label>
            <input id="password" type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" name="password" placeholder="Kosongkan jika tanpa token" value="{{ $soal->password }}">
            <span class="text-xs text-slate-500 mt-1 block">Opsional proteksi</span>
          </div>
        </div>

        <div id="notif" style="display: none;" class="p-3.5 rounded-xl text-xs font-semibold"></div>

        <div class="pt-4 border-t border-slate-100 flex items-center gap-3" id="wrap-btn">
          <button type="button" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm" id="btnSimpan">
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