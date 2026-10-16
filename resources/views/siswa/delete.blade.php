@extends('layouts.app')
@section('title', 'Hapus Semua Siswa - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="px-4 py-2">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Master Data &bull; Siswa</div>
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">Danger Zone: Hapus Data Siswa</h1>
  </div>
@endsection
@section('content')
<div class="col-md-12">
  <div class="max-w-xl mx-auto space-y-6">

    <!-- DANGER CARD -->
    <div class="bg-white rounded-3xl border border-red-200 p-6 sm:p-8 shadow-sm">
      <div class="flex items-center gap-3 pb-4 border-b border-red-100 mb-6">
        <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center font-bold text-xl shrink-0">
          <i class="fa fa-exclamation-triangle"></i>
        </div>
        <div>
          <h2 class="text-lg font-bold text-red-900">Konfirmasi Penghapusan Seluruh Siswa</h2>
          <p class="text-xs text-red-700/80 mt-0.5">Tindakan ini permanen dan tidak dapat dibatalkan.</p>
        </div>
      </div>

      <div class="p-4 rounded-2xl bg-red-50/80 border border-red-200 text-xs text-red-900 leading-relaxed space-y-2 mb-6">
        <div class="font-bold">Perhatian:</div>
        <p>Dengan menghapus seluruh siswa, data hasil pengerjaan latihan, lembar nilai, riwayat jawaban, dan akun siswa akan terhapus dari sistem secara permanen.</p>
      </div>

      <div class="space-y-4">
        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
          Ketik Password Akun Admin Anda Untuk Mengonfirmasi:
        </label>
        <input type="password" name="password" id="password" class="w-full px-4 py-3.5 text-base rounded-2xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 outline-none transition" placeholder="Masukkan password admin...">
        <div class="notif" style="display: none;"></div>
      </div>

      <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
        <a href="{{ url('master/siswa') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition">
          &larr; Batalkan &amp; Kembali
        </a>
      </div>
    </div>

  </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
function delay(callback, ms) {
  var timer = 0;
  return function() {
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}

$(document).ready(function() {
  $('#password').keyup(delay(function (e) {
    var password = $(this).val();
    $.ajax({
      type: "GET",
      url: "{{ url('master/siswa/get-btn-delete') }}/"+password,
      success: function(data) {
        $('.notif').html(data).show();
      }
    });
  }, 700));

  $(document).on('click', '#delete-all', function() {
    $.ajax({
      type: "GET",
      url: "{{ url('master/siswa/delete-all') }}",
      success: function(data) {
        window.location.href = "{{ url('master/siswa') }}";
      }
    });
  });
});
</script>
@endpush