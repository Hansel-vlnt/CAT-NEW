@extends('layouts.app')
@section('title', 'Manajemen Materi Pembelajaran - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="w-full">
    <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight">Manajemen Materi Belajar</h1>
  </div>
@endsection

@section('content')
<div class="col-md-12">
  <div class="max-w-6xl mx-auto space-y-6">

    <!-- COMPACT ACTION HEADER -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Modul &amp; Materi Pembelajaran</h2>
        <p class="text-sm text-slate-500 mt-1">
          Kelola ringkasan konsep, modul referensi SKD Kedinasan dan UTBK-SNBT untuk dibaca siswa.
        </p>
      </div>
      <div>
        <button type="button" id="btn-tambah-materi" class="px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm transition shadow-sm flex items-center gap-2 cursor-pointer">
          <i class="fa fa-plus-circle"></i> <span>Tulis Materi Baru</span>
        </button>
      </div>
    </div>

    <!-- FORM TAMBAH MATERI (COLLAPSIBLE) -->
    <div id="wrap-form-materi" style="display: none;" class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="pb-4 border-b border-slate-100 mb-6 flex items-center justify-between">
        <div>
          <h3 class="text-lg font-bold text-slate-900">Formulir Materi Pembelajaran Baru</h3>
          <p class="text-xs text-slate-500 mt-0.5">Tuliskan konten modul pembelajaran lengkap dengan gambar dan rumus.</p>
        </div>
        <button type="button" id="btn-batal-materi" class="text-slate-400 hover:text-slate-600 text-sm font-bold cursor-pointer">✕ Tutup</button>
      </div>

      <form id="formMateri" class="space-y-5">
        {{ csrf_field() }}
        <?php $sesi = md5(microtime(true) . rand(1000, 9999)); ?>
        <input type="hidden" name="sesi" value="{{ $sesi }}">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
          <div class="sm:col-span-2">
            <label for="judul" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Materi</label>
            <input type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" id="judul" name="judul" placeholder="Contoh: Trik Cepat Silogisme & Logika Posisi SKD TIU" required>
          </div>
          <div>
            <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Publikasi</label>
            <select class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" id="status" name="status">
              <option value="Y" selected>Terbitkan (Tampil ke Siswa)</option>
              <option value="N">Draft (Tidak Tampil)</option>
            </select>
          </div>
        </div>

        <div>
          <label for="isi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Isi Materi Pembelajaran</label>
          <textarea id="isi" name="isi" class="summernote" placeholder="Tuliskan materi pembelajaran..."></textarea>
          <p class="text-xs text-slate-400 mt-1.5">
            <i class="fa fa-info-circle text-indigo-500"></i> Mendukung rumus matematika KaTeX ($...$ atau $$...$$) serta penyisipan gambar ilustrasi.
          </p>
        </div>

        <div id="notif-materi" style="display: none;" class="p-3.5 rounded-xl text-xs font-semibold"></div>

        <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
          <button type="button" id="btn-simpan-materi" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm cursor-pointer">
            <i class="fa fa-save mr-1.5"></i> Simpan &amp; Terbitkan Materi
          </button>
          <button type="button" class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition cursor-pointer" onclick="$('#wrap-form-materi').slideUp();">
            Batal
          </button>
        </div>
      </form>
    </div>

    <!-- MAIN TABLE CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
        <div>
          <h3 class="text-lg font-bold text-slate-900">Daftar Modul Belajar</h3>
          <p class="text-xs text-slate-500 mt-0.5">Kelola isi, status tampil, dan tinjau jumlah pembaca pada setiap modul.</p>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover table-striped" id="table_materi" style="width: 100%;">
          <thead>
            <tr class="text-slate-600 text-xs font-bold uppercase tracking-wider bg-slate-50">
              <th style="padding: 14px 16px; width: 60px;">ID</th>
              <th style="padding: 14px 16px;">Judul Materi</th>
              <th style="padding: 14px 16px; text-align: center; width: 120px;">Dibaca</th>
              <th style="padding: 14px 16px; text-align: center; width: 120px;">Status</th>
              <th style="padding: 14px 16px; text-align: center; width: 160px;">Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

  </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ url('/assets/plugins/summernote/summernote.css') }}">
<link rel="stylesheet" href="{{ url('/assets/plugins/datatables/media/css/dataTables.bootstrap.css') }}">
@endpush

@push('scripts')
<script src="{{ url('/assets/plugins/summernote/summernote.min.js') }}"></script>
<script src="{{ url('/assets/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/assets/plugins/datatables/media/js/dataTables.bootstrap.min.js') }}"></script>
<script>
$(document).ready(function() {
  $('.summernote').summernote({
    height: 300,
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'italic', 'underline', 'clear']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'picture', 'video']],
      ['view', ['fullscreen', 'codeview']]
    ]
  });

  var table = $('#table_materi').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('elearning.dataMateriGuru') !!}',
    columns: [
      { data: 'id', name: 'id', className: 'font-mono text-slate-500' },
      { data: 'judul', name: 'judul', className: 'font-bold text-slate-900 text-sm' },
      { data: 'hits', name: 'hits', className: 'text-center text-xs' },
      { data: 'status', name: 'status', className: 'text-center text-xs' },
      { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
    ]
  });

  $('#btn-tambah-materi').click(function() {
    $('#wrap-form-materi').slideToggle();
  });

  $('#btn-batal-materi').click(function() {
    $('#wrap-form-materi').slideUp();
  });

  $('#btn-simpan-materi').click(function() {
    var dataString = $('#formMateri').serialize();
    $.ajax({
      type: 'POST',
      url: '{{ url('/crud/simpan-materi') }}',
      data: dataString,
      success: function(data) {
        if (data == 'ok') {
          $('#notif-materi').removeClass('bg-red-50 text-red-700').addClass('bg-emerald-50 text-emerald-800 border border-emerald-200').html('✓ Materi pembelajaran berhasil disimpan.').show();
          $('#formMateri')[0].reset();
          $('.summernote').summernote('code', '');
          table.ajax.reload();
          setTimeout(function() {
            $('#wrap-form-materi').slideUp();
            $('#notif-materi').hide();
          }, 1000);
        } else {
          $('#notif-materi').removeClass('bg-emerald-50 text-emerald-800').addClass('bg-red-50 text-red-700 border border-red-200').html(data).show();
        }
      }
    });
  });
});
</script>
@endpush
