@extends('layouts.app')
@section('title', 'Ubah Siswa: ' . $siswa->nama . ' - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="w-full max-w-4xl py-1">
    <div class="text-xs text-slate-500 font-bold uppercase tracking-wider">Master Data &bull; Siswa</div>
    <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight">Ubah Data Akun Siswa</h1>
  </div>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="w-full max-w-4xl space-y-6">

    <!-- HERO HEADER -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-lg">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
            Edit Profil Siswa
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">{{ $siswa->nama }}</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            Perbarui informasi identitas, kelas, foto profil, dan kata sandi siswa.
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
      <form id="form-siswa" class="space-y-6">
        <input type="hidden" name="id" value="{{ $siswa->id }}">

        <!-- FOTO PROFIL SECTION -->
        <div class="pb-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center gap-6">
          <img src="{{ $siswa->gambar ? url('assets/img/user/'.$siswa->gambar) : url('assets/img/siswa.png') }}" id="wrap-img" class="w-20 h-20 rounded-2xl object-cover border-2 border-slate-200 shadow-sm shrink-0">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Foto Profil</label>
            <input type="file" class="upload_url_img hidden" id="upload_url_img" name="upload_url_img" />
            <label for="upload_url_img" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition cursor-pointer border border-slate-200">
              <i class="fa fa-camera"></i> Pilih Foto Baru
            </label>
            <div id="message" class="text-xs text-slate-500 mt-1"></div>
          </div>
        </div>

        <!-- FORM INPUTS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <div class="sm:col-span-2">
            <label for="nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
            <input type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" id="nama" name="nama" value="{{ $siswa->nama }}">
          </div>

          <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
            <input type="email" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" id="email" name="email" value="{{ $siswa->email }}">
          </div>

          <div>
            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password Baru (Opsional)</label>
            <input type="password" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" id="password" name="password" placeholder="Kosongkan jika tidak diubah">
          </div>

          <div>
            <label for="no_induk" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Induk Siswa (NIS)</label>
            <input type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" id="no_induk" name="no_induk" value="{{ $siswa->no_induk }}">
          </div>

          <div>
            <label for="nisn" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">NISN</label>
            <input type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" id="nisn" name="nisn" value="{{ $siswa->nisn }}">
          </div>

          <div>
            <label for="kelas" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kelas / Rombel</label>
            <select class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition select2Class" id="kelas" name="kelas">
              <option value="@if($siswa->getKelas) {{ $siswa->getKelas->id }} @else Pilih kelas @endif">@if($siswa->getKelas) {{ $siswa->getKelas->nama }} @else Pilih kelas @endif</option>
              @if($kelas->count())
                @foreach($kelas as $data_kelas)
                  <option value="{{ $data_kelas->id }}">{{ $data_kelas->nama }}</option>
                @endforeach
              @endif
            </select>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Kelamin</label>
            <div class="flex items-center gap-6 pt-3">
              <label class="flex items-center gap-2 text-sm font-medium text-slate-700 cursor-pointer">
                <input type="radio" name="jk" id="l" value="L" @if($siswa->jk == 'L') checked @endif class="text-blue-600 focus:ring-blue-500">
                Laki-laki
              </label>
              <label class="flex items-center gap-2 text-sm font-medium text-slate-700 cursor-pointer">
                <input type="radio" name="jk" id="p" value="P" @if($siswa->jk == 'P') checked @endif class="text-blue-600 focus:ring-blue-500">
                Perempuan
              </label>
            </div>
          </div>
        </div>

        <div id="notif" style="display: none;" class="p-3.5 rounded-xl text-xs font-semibold"></div>

        <div class="pt-6 border-t border-slate-100 flex items-center gap-3" id="wrap-btn">
          <button type="button" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm" id="simpan">
            Simpan Perubahan
          </button>
          <button type="button" class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition" onclick="self.history.back()">
            Batal &amp; Kembali
          </button>
        </div>
      </form>
    </div>

  </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function (){
  $('#upload_url_img').change(function(){
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#wrap-img').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
      $('#form-siswa').trigger('submit');
    }
  });

  $('#form-siswa').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: "{{ url('crud/update-img-siswa') }}",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      success: function(data) {
        $("#message").html('<span class="text-emerald-600 font-bold">✓ Foto profil berhasil diunggah.</span>');
      }
    });
  });

  $("#simpan").click(function() {
    var dataString = $("#form-siswa").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/update-siswa') }}",
      data: dataString,
      success: function(data){
        if (data == 'ok') {
          $("#notif").removeClass('bg-red-50 text-red-700').addClass('bg-emerald-50 text-emerald-800 border border-emerald-200').html("Data siswa berhasil diupdate.").show();
          setTimeout(function() {
            window.location.href = "{{ url('master/siswa/detail/'.$siswa->id) }}";
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