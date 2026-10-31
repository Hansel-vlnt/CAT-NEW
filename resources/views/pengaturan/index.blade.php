@extends('layouts.app')
@section('title', 'Pengaturan Akun & Kontak Sistem')
@section('breadcrumb')
  <div class="w-full">
    <div class="flex items-center gap-2 text-sm font-semibold text-slate-500 mb-1.5">
      <a href="{{ url('/home') }}" class="hover:text-indigo-600 transition">Dashboard</a>
      <span>/</span>
      <span class="text-slate-800">Pengaturan</span>
    </div>
    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan Profil &amp; Sistem</h1>
  </div>
@endsection

@section('content')
<div class="col-xs-12">
  <div class="max-w-4xl mx-auto py-2 space-y-6">

    <!-- USER BADGE SUMMARY HEADER -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-5">
      <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-extrabold text-2xl shadow-md shadow-indigo-500/20 shrink-0">
          {{ strtoupper(substr($user->nama, 0, 1)) }}
        </div>
        <div class="min-w-0">
          <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-tight">{{ $user->nama }}</h2>
          <div class="flex flex-wrap items-center gap-2.5 mt-1.5">
            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $user->status == 'S' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-indigo-50 text-indigo-700 border border-indigo-200' }}">
              @if($user->status == 'A')
                Administrator
              @elseif($user->status == 'G')
                Guru / Instruktur
              @else
                Peserta / Siswa
              @endif
            </span>
            <span class="text-sm text-slate-500 font-mono">{{ $user->email }}</span>
          </div>
        </div>
      </div>

      @if($user->status == 'A')
        <!-- TABS NAVIGASI UNTUK ADMIN -->
        <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl border border-slate-200 shrink-0">
          <button type="button" onclick="switchTab('profil')" id="tab-btn-profil" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition cursor-pointer bg-white text-indigo-600 shadow-sm">
            <i class="fa fa-user"></i> Profil Admin
          </button>
          <button type="button" onclick="switchTab('kontak')" id="tab-btn-kontak" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition cursor-pointer text-slate-600 hover:text-slate-900">
            <i class="fa fa-whatsapp"></i> Kontak &amp; Pembayaran
          </button>
        </div>
      @endif
    </div>

    <!-- TAB 1: FORM PROFIL PENGGUNA -->
    <div id="section-profil" class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm relative">
      <div class="pb-4 mb-6 border-b border-slate-100">
        <h3 class="text-xl font-bold text-slate-900">Biodata &amp; Keamanan Akun</h3>
        <p class="text-xs text-slate-500 mt-0.5">Kelola informasi identitas akun login Anda.</p>
      </div>

      <form method="post" id="form_profil" class="space-y-6">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $user->id }}">

        <div>
          <label for="nama" class="block text-sm sm:text-base font-bold text-slate-800 mb-2">Nama Lengkap</label>
          <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama lengkap" value="{{ $user->nama }}" required style="height: 52px !important; font-size: 15px !important; border-radius: 12px !important;">
        </div>

        <div>
          <label class="block text-sm sm:text-base font-bold text-slate-800 mb-2">Jenis Kelamin</label>
          <div class="grid grid-cols-2 gap-3">
            <label class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-indigo-300 cursor-pointer bg-slate-50/50 transition">
              <input type="radio" name="jk" id="laki_laki" value="L" <?php if ($user->jk == 'L') { echo "checked"; } ?> class="w-5 h-5 text-indigo-600">
              <span class="text-sm sm:text-base font-semibold text-slate-800">Laki-laki</span>
            </label>
            <label class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 hover:border-indigo-300 cursor-pointer bg-slate-50/50 transition">
              <input type="radio" name="jk" id="perempuan" value="P" <?php if ($user->jk == 'P') { echo "checked"; } ?> class="w-5 h-5 text-indigo-600">
              <span class="text-sm sm:text-base font-semibold text-slate-800">Perempuan</span>
            </label>
          </div>
        </div>

        <div>
          <label for="email" class="block text-sm sm:text-base font-bold text-slate-800 mb-2">Alamat Email</label>
          <input type="email" class="form-control" name="email" id="email" placeholder="nama@email.com" value="{{ $user->email }}" required style="height: 52px !important; font-size: 15px !important; border-radius: 12px !important;">
        </div>

        <div>
          <div class="flex items-center justify-between mb-2">
            <label for="password" class="block text-sm sm:text-base font-bold text-slate-800">Kata Sandi Baru</label>
            <span class="text-xs text-slate-400 font-medium">(Opsional)</span>
          </div>
          <input type="password" class="form-control" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengubah kata sandi" style="height: 52px !important; font-size: 15px !important; border-radius: 12px !important;">
          <p class="text-xs text-slate-500 mt-2 flex items-center gap-2">
            <i class="fa fa-info-circle text-indigo-500 text-xs"></i>
            <span>Biarkan kosong apabila Anda tetap ingin menggunakan kata sandi saat ini.</span>
          </p>
        </div>

        <div id="notif" style="display: none; border-radius: 12px; font-weight: 600; font-size: 14px; padding: 14px 18px;"></div>

        <div class="pt-4 flex items-center justify-between border-t border-slate-100">
          <a href="{{ url('/home') }}" class="text-sm font-semibold text-slate-500 hover:text-slate-800 transition">Batal</a>
          <button type="button" class="px-7 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-500/20 transition flex items-center gap-2 cursor-pointer" id="update_profil">
            <i class="fa fa-check"></i>
            <span>Simpan Profil</span>
          </button>
        </div>
      </form>
    </div>

    @if($user->status == 'A')
      <!-- TAB 2: PENGATURAN KONTAK WHATSAPP ADMIN & PEMBAYARAN -->
      <div id="section-kontak" style="display: none;" class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200 shadow-sm relative">
        <div class="pb-4 mb-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
          <div>
            <h3 class="text-xl font-bold text-slate-900">Kontak Admin &amp; Data Pembayaran</h3>
            <p class="text-xs text-slate-500 mt-0.5">Semua perubahan di sini akan <strong>otomatis terupdate di seluruh halaman siswa</strong> (tombol WhatsApp, invoice QRIS, dan rekening bank).</p>
          </div>
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
            <i class="fa fa-link"></i> Sinkronisasi Otomatis
          </span>
        </div>

        <form method="post" id="form_kontak" class="space-y-6">
          {{ csrf_field() }}

          <!-- NOMOR WHATSAPP ADMIN -->
          <div class="p-5 rounded-2xl bg-emerald-50/60 border border-emerald-200 space-y-3">
            <div class="flex items-center gap-2">
              <i class="fa fa-whatsapp text-emerald-600 text-xl"></i>
              <label for="no_wa_admin" class="text-base font-bold text-emerald-950">Nomor WhatsApp Resmi Admin</label>
            </div>
            <p class="text-xs text-emerald-800 leading-relaxed">
              Nomor ini digunakan siswa untuk konfirmasi pendaftaran, pengiriman bukti transfer, dan bantuan. Anda dapat menginput nomor dengan format <code>08...</code> atau <code>62...</code>.
            </p>
            <div class="relative">
              <input type="text" class="form-control" name="no_wa_admin" id="no_wa_admin" value="{{ $settings['no_wa_admin'] ?? '085767629211' }}" required placeholder="Contoh: 085767629211" style="height: 52px !important; font-size: 16px !important; font-weight: 700 !important; border-radius: 12px !important;">
            </div>
            <div class="text-xs text-emerald-700 flex items-center gap-2 pt-1">
              <span>Preview Link:</span>
              <a href="{{ \App\Models\Setting::getAdminWaUrl('Halo Admin') }}" target="_blank" id="preview_wa_link" class="font-mono font-bold underline hover:text-emerald-900">
                https://wa.me/{{ \App\Models\Setting::getAdminWaSanitized() }}
              </a>
            </div>
          </div>

          <!-- JAM OPERASIONAL LAYANAN -->
          <div>
            <label for="jam_layanan" class="block text-sm sm:text-base font-bold text-slate-800 mb-2">Jam Layanan &amp; Konfirmasi Admin</label>
            <input type="text" class="form-control" name="jam_layanan" id="jam_layanan" value="{{ $settings['jam_layanan'] ?? '09.00 - 21.00 WIB' }}" placeholder="Contoh: 09.00 - 21.00 WIB" style="height: 52px !important; font-size: 15px !important; border-radius: 12px !important;">
            <p class="text-xs text-slate-500 mt-1.5">Ditampilkan pada footer modal langganan siswa.</p>
          </div>

          <!-- REKENING BANK ADMIN -->
          <div class="p-5 rounded-2xl bg-indigo-50/60 border border-indigo-200 space-y-4">
            <div class="flex items-center gap-2">
              <i class="fa fa-credit-card text-indigo-600 text-lg"></i>
              <h4 class="text-base font-bold text-indigo-950">Informasi Rekening Bank Penerima</h4>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div>
                <label for="nama_bank" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Bank</label>
                <input type="text" class="form-control" name="nama_bank" id="nama_bank" value="{{ $settings['nama_bank'] ?? 'Bank BCA' }}" placeholder="Contoh: Bank BCA" style="height: 48px !important; border-radius: 10px !important;">
              </div>
              <div>
                <label for="no_rekening" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor Rekening</label>
                <input type="text" class="form-control" name="no_rekening" id="no_rekening" value="{{ $settings['no_rekening'] ?? '8280912345' }}" placeholder="Contoh: 8280912345" style="height: 48px !important; font-family: monospace; font-size: 15px; font-weight: bold; border-radius: 10px !important;">
              </div>
              <div>
                <label for="atas_nama_rekening" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Atas Nama (A.N.)</label>
                <input type="text" class="form-control" name="atas_nama_rekening" id="atas_nama_rekening" value="{{ $settings['atas_nama_rekening'] ?? 'Abdi Praja Edukasi' }}" placeholder="Contoh: Abdi Praja Edukasi" style="height: 48px !important; border-radius: 10px !important;">
              </div>
            </div>
          </div>

          <div id="notif_kontak" style="display: none; border-radius: 12px; font-weight: 600; font-size: 14px; padding: 14px 18px;"></div>

          <div class="pt-4 flex items-center justify-between border-t border-slate-100">
            <span class="text-xs text-slate-400">Pembaruan langsung aktif secara instan tanpa perlu restart server.</span>
            <button type="button" class="px-7 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md shadow-emerald-500/20 transition flex items-center gap-2 cursor-pointer" id="update_kontak">
              <i class="fa fa-save"></i>
              <span>Simpan Pengaturan Kontak &amp; Bank</span>
            </button>
          </div>
        </form>
      </div>
    @endif

    <!-- OVERLAY LOADING -->
    <div class="overlay flex items-center justify-center bg-white/80 fixed inset-0 z-50 rounded-3xl" id="loading" style="display: none;">
      <div class="flex flex-col items-center gap-2 text-indigo-600 bg-white p-6 rounded-2xl shadow-xl border border-slate-200">
        <i class="fa fa-refresh fa-spin text-3xl"></i>
        <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Menyimpan Perubahan...</span>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
function switchTab(tab) {
  if (tab === 'profil') {
    $('#section-profil').show();
    $('#section-kontak').hide();
    $('#tab-btn-profil').addClass('bg-white text-indigo-600 shadow-sm').removeClass('text-slate-600');
    $('#tab-btn-kontak').removeClass('bg-white text-indigo-600 shadow-sm').addClass('text-slate-600');
  } else {
    $('#section-profil').hide();
    $('#section-kontak').show();
    $('#tab-btn-kontak').addClass('bg-white text-indigo-600 shadow-sm').removeClass('text-slate-600');
    $('#tab-btn-profil').removeClass('bg-white text-indigo-600 shadow-sm').addClass('text-slate-600');
  }
}

$(document).ready(function(){
  // Simpan Profil Pengguna
  $("#update_profil").click(function(){
    var btn = $(this);
    btn.hide();
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
          btn.show();
        }
      },
      error: function(){
        $("#loading").hide();
        $("#notif").removeClass('alert alert-success').addClass('alert alert-danger').html('<i class="fa fa-exclamation-triangle mr-2"></i> Terjadi kesalahan saat menyimpan data.').fadeIn(350);
        btn.show();
      }
    });
  });

  // Simpan Kontak Admin & Pembayaran
  $("#update_kontak").click(function(){
    var btn = $(this);
    btn.hide();
    $("#notif_kontak").hide();
    $("#loading").show();
    var formData = $("#form_kontak").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/pengaturan/update-kontak-pembayaran') }}",
      data: formData,
      success: function(res){
        $("#loading").hide();
        btn.show();
        if(res.success){
          $("#notif_kontak").removeClass('alert alert-danger').addClass('alert alert-success').html('<i class="fa fa-check-circle mr-2"></i> ' + res.message).fadeIn(350);
          if(res.no_wa_sanitized){
            $("#preview_wa_link").attr("href", "https://wa.me/" + res.no_wa_sanitized).text("https://wa.me/" + res.no_wa_sanitized);
          }
        }else{
          $("#notif_kontak").removeClass('alert alert-success').addClass('alert alert-danger').html('<i class="fa fa-exclamation-triangle mr-2"></i> ' + (res.message || 'Gagal menyimpan.')).fadeIn(350);
        }
      },
      error: function(xhr){
        $("#loading").hide();
        btn.show();
        var errMsg = 'Terjadi kesalahan saat menyimpan pengaturan kontak.';
        if(xhr.responseJSON && xhr.responseJSON.message){
          errMsg = xhr.responseJSON.message;
        }
        $("#notif_kontak").removeClass('alert alert-success').addClass('alert alert-danger').html('<i class="fa fa-exclamation-triangle mr-2"></i> ' + errMsg).fadeIn(350);
      }
    });
  });
});
</script>
@endpush
