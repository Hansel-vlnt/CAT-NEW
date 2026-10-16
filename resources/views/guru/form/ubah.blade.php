@extends('layouts.app')
@section('title', 'Ubah Guru: ' . $guru->nama . ' - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="px-4 py-2">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Master Data &bull; Guru</div>
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">Ubah Data Instruktur / Guru</h1>
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
            Edit Data Pengajar
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">{{ $guru->nama }}</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            NIP: <b>{{ $guru->no_induk ?: '-' }}</b> &bull; Email: {{ $guru->email }}
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
      <form id="form-guru" class="space-y-5 max-w-2xl">
        <input type="hidden" name="id" value="{{ $guru->id }}">

        <div>
          <label for="nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
          <input type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" id="nama" name="nama" value="{{ $guru->nama }}">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="no_induk" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NIP / No. Identitas</label>
            <input type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" id="no_induk" name="no_induk" value="{{ $guru->no_induk }}">
          </div>

          <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
            <input type="email" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" id="email" name="email" value="{{ $guru->email }}">
          </div>
        </div>

        <div>
          <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password Baru (Opsional)</label>
          <input type="password" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Kelamin</label>
          <div class="flex items-center gap-6 pt-2">
            <label class="flex items-center gap-2 text-sm font-medium text-slate-700 cursor-pointer">
              <input type="radio" name="jk" id="l" value="L" @if($guru->jk == 'L') checked @endif class="text-blue-600 focus:ring-blue-500">
              Laki-laki
            </label>
            <label class="flex items-center gap-2 text-sm font-medium text-slate-700 cursor-pointer">
              <input type="radio" name="jk" id="p" value="P" @if($guru->jk == 'P') checked @endif class="text-blue-600 focus:ring-blue-500">
              Perempuan
            </label>
          </div>
        </div>

        <div id="notif" style="display: none;" class="p-3.5 rounded-xl text-xs font-semibold"></div>

        <div class="pt-4 border-t border-slate-100 flex items-center gap-3" id="wrap-btn">
          <button type="button" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm" id="simpan">
            Simpan Data Guru
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
$(document).ready(function() {
  $("#simpan").click(function() {
    var dataString = $("#form-guru").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/update-guru') }}",
      data: dataString,
      success: function(data){
        if (data == 'ok') {
          $("#notif").removeClass('bg-red-50 text-red-700').addClass('bg-emerald-50 text-emerald-800 border border-emerald-200').html("Data guru berhasil diupdate.").show();
          setTimeout(function() {
            window.location.href = "{{ url('master/guru') }}";
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