@extends('layouts.app')
@section('title', 'Ubah Materi: ' . $materi->judul . ' - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="px-4 py-2">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">E-Learning &bull; Materi</div>
    <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight">Ubah Materi Pembelajaran</h1>
  </div>
@endsection

@section('content')
<div class="col-md-12">
  <div class="max-w-5xl mx-auto space-y-6">

    <!-- COMPACT ACTION HEADER -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Edit: {{ $materi->judul }}</h2>
        <p class="text-sm text-slate-500 mt-1">
          Sesuaikan judul, isi modul belajar, atau status publikasi materi ini.
        </p>
      </div>
      <div>
        <a href="{{ url('/elearning/materi/detail/' . $materi->id) }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition flex items-center gap-1.5">
          <i class="fa fa-arrow-left"></i> Kembali
        </a>
      </div>
    </div>

    <!-- FORM CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <form id="formUbahMateri" class="space-y-5">
        {{ csrf_field() }}
        <input type="hidden" name="sesi" value="{{ $materi->sesi }}">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
          <div class="sm:col-span-2">
            <label for="judul" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Materi</label>
            <input type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" id="judul" name="judul" value="{{ $materi->judul }}" required>
          </div>
          <div>
            <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Publikasi</label>
            <select class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition" id="status" name="status">
              <option value="Y" {{ $materi->status == 'Y' ? 'selected' : '' }}>Terbitkan (Tampil ke Siswa)</option>
              <option value="N" {{ $materi->status == 'N' ? 'selected' : '' }}>Draft (Tidak Tampil)</option>
            </select>
          </div>
        </div>

        <div>
          <label for="isi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Isi Materi Pembelajaran</label>
          <textarea id="isi" name="isi" class="summernote">{!! $materi->isi !!}</textarea>
        </div>

        <div id="notif-ubah" style="display: none;" class="p-3.5 rounded-xl text-xs font-semibold"></div>

        <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
          <button type="button" id="btn-update-materi" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm cursor-pointer">
            <i class="fa fa-save mr-1.5"></i> Simpan Perubahan Materi
          </button>
          <a href="{{ url('/elearning/materi/detail/' . $materi->id) }}" class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition">
            Batal
          </a>
        </div>
      </form>
    </div>

  </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ url('/assets/plugins/summernote/summernote.css') }}">
@endpush

@push('scripts')
<script src="{{ url('/assets/plugins/summernote/summernote.min.js') }}"></script>
<script>
$(document).ready(function() {
  $('.summernote').summernote({
    height: 350,
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

  $('#btn-update-materi').click(function() {
    var dataString = $('#formUbahMateri').serialize();
    $.ajax({
      type: 'POST',
      url: '{{ url('/crud/simpan-materi') }}',
      data: dataString,
      success: function(data) {
        if (data == 'ok') {
          $('#notif-ubah').removeClass('bg-red-50 text-red-700').addClass('bg-emerald-50 text-emerald-800 border border-emerald-200').html('✓ Materi pembelajaran berhasil diperbarui.').show();
          setTimeout(function() {
            window.location.href = "{{ url('/elearning/materi/detail/' . $materi->id) }}";
          }, 800);
        } else {
          $('#notif-ubah').removeClass('bg-emerald-50 text-emerald-800').addClass('bg-red-50 text-red-700 border border-red-200').html(data).show();
        }
      }
    });
  });
});
</script>
@endpush
