@extends('layouts.app')
@section('title', 'Pengaturan Akun')
@section('breadcrumb')
  <div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
      <a href="{{ url('/home') }}" class="hover:text-indigo-600 transition">Dashboard</a>
      <span>/</span>
      <span class="text-slate-800">Pengaturan</span>
    </div>
    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pengaturan Profil Pengguna</h1>
    <p class="text-sm text-slate-500 mt-0.5">Kelola data personal, alamat email, dan kata sandi akun Anda di Latihan Soal Abdi Praja.</p>
  </div>
@endsection

@section('content')
<div class="col-xs-12">
  <div class="max-w-2xl mx-auto py-2">
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200 shadow-sm relative">

      <!-- User Badge Summary Header -->
      <div class="flex items-center gap-4 pb-6 mb-6 border-b border-slate-100">
        <div class="w-16 h-16 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-extrabold text-2xl shadow-md shadow-indigo-500/20">
          {{ strtoupper(substr($user->nama, 0, 1)) }}
        </div>
        <div>
          <h2 class="text-xl font-bold text-slate-900">{{ $user->nama }}</h2>
          <div class="flex items-center gap-2 mt-1">
            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $user->status == 'S' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-indigo-50 text-indigo-700 border border-indigo-200' }}">
              @if($user->status == 'A')
                Administrator
              @elseif($user->status == 'G')
                Guru / Instruktur
              @else
                Peserta / Siswa
              @endif
            </span>
            <span class="text-xs text-slate-400 font-mono">{{ $user->email }}</span>
          </div>
        </div>
      </div>

      <!-- Settings Form -->
      <form method="post" id="form_profil" class="space-y-6">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $user->id }}">

        <div>
          <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
          <div class="relative">
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama lengkap" value="{{ $user->nama }}" required style="height: 50px !important; font-size: 15px !important; border-radius: 12px !important;">
          </div>
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
          <div class="grid grid-cols-2 gap-3">
            <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 hover:border-indigo-300 cursor-pointer bg-slate-50/50 transition">
              <input type="radio" name="jk" id="laki_laki" value="L" <?php if ($user->jk == 'L') { echo "checked"; } ?> class="w-4 h-4 text-indigo-600">
              <span class="text-sm font-medium text-slate-800">Laki-laki</span>
            </label>
            <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 hover:border-indigo-300 cursor-pointer bg-slate-50/50 transition">
              <input type="radio" name="jk" id="perempuan" value="P" <?php if ($user->jk == 'P') { echo "checked"; } ?> class="w-4 h-4 text-indigo-600">
              <span class="text-sm font-medium text-slate-800">Perempuan</span>
            </label>
          </div>
        </div>

        <div>
          <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Alamat Email</label>
          <div class="relative">
            <input type="email" class="form-control" name="email" id="email" placeholder="nama@email.com" value="{{ $user->email }}" required style="height: 50px !important; font-size: 15px !important; border-radius: 12px !important;">
          </div>
        </div>

        <div>
          <div class="flex items-center justify-between mb-2">
            <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi Baru</label>
            <span class="text-xs text-slate-400 font-medium">(Opsional)</span>
          </div>
          <div class="relative">
            <input type="password" class="form-control" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengubah kata sandi" style="height: 50px !important; font-size: 15px !important; border-radius: 12px !important;">
          </div>
          <p class="text-xs text-slate-400 mt-1.5 flex items-center gap-1.5">
            <i class="fa fa-info-circle text-slate-400"></i>
            <span>Biarkan kosong apabila Anda tetap ingin menggunakan kata sandi saat ini.</span>
          </p>
        </div>

        <div id="notif" style="display: none; border-radius: 12px; font-weight: 600; font-size: 14px; padding: 14px 16px;"></div>

        <div class="pt-4 flex items-center justify-between border-t border-slate-100">
          <a href="{{ url('/home') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition">
            Batal
          </a>
          <button type="button" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-bold text-sm shadow-md shadow-indigo-500/25 transition duration-150 flex items-center gap-2 cursor-pointer" id="update_profil">
            <i class="fa fa-check"></i>
            <span>Simpan Perubahan</span>
          </button>
        </div>
      </form>

      <!-- Overlay Loading -->
      <div class="overlay flex items-center justify-center bg-white/80 absolute inset-0 rounded-3xl" id="loading" style="display: none;">
        <div class="flex flex-col items-center gap-2 text-indigo-600">
          <i class="fa fa-refresh fa-spin text-3xl"></i>
          <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Menyimpan Perubahan...</span>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
  $("#update_profil").click(function(){
    $(this).hide();
    $("#notif").hide();
    $("#loading").show();
    var formData = $("#form_profil").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/update-profil') }}",
      data: formData,
      success: function(data){
        $("#loading").hide();
        if(data == 'ok'){
          $("#notif").removeClass('alert alert-danger').addClass('alert alert-success').html('<i class="fa fa-check-circle mr-2"></i> Data profil berhasil diperbarui!').fadeIn(350);
          setTimeout(function(){
            location.href = "{{ url('/pengaturan') }}";
          }, 800);
        }else{
          $("#notif").removeClass('alert alert-success').addClass('alert alert-danger').html('<i class="fa fa-exclamation-triangle mr-2"></i> ' + data).fadeIn(350);
          $("#update_profil").show();
        }
      },
      error: function(){
        $("#loading").hide();
        $("#notif").removeClass('alert alert-success').addClass('alert alert-danger').html('<i class="fa fa-exclamation-triangle mr-2"></i> Terjadi kesalahan saat menyimpan data.').fadeIn(350);
        $("#update_profil").show();
      }
    });
  });
});
</script>
@endpush