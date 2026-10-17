@extends('layouts.app')
@section('title', 'Edit Soal Essay - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="w-full max-w-4xl py-1">
    <div class="text-xs text-slate-500 font-bold uppercase tracking-wider">Bank Soal &bull; Butir Essay</div>
    <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight">Edit Butir Soal Essay</h1>
  </div>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="w-full max-w-4xl space-y-6">

    <!-- HERO HEADER -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-lg">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
            Edit Soal Uraian / Essay
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">Soal Essay #{{ $essay->id }}</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            Ubah pertanyaan uraian dan atur status penayangan pada tryout.
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
      <form action="{{ url('elearning/soal/essay/'.$essay->id) }}" method="POST" class="space-y-6">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="soal_id" value="{{ $essay->id_soal }}">

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Teks Pertanyaan Essay</label>
          <textarea class="form-control textarea" name="soal" placeholder="Tuliskan soal essay...">{{ $essay->soal }}</textarea>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Penayangan</label>
          <div class="flex items-center gap-6 pt-1">
            <label class="flex items-center gap-2 text-sm font-medium text-slate-700 cursor-pointer">
              <input type="radio" name="status" id="y" value="Y" {{ $essay->status == 'Y' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
              Tampilkan pada Ujian
            </label>
            <label class="flex items-center gap-2 text-sm font-medium text-slate-700 cursor-pointer">
              <input type="radio" name="status" id="n" value="N" {{ $essay->status == 'N' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
              Sembunyikan Sementara
            </label>
          </div>
        </div>

        <div class="pt-6 border-t border-slate-100 flex items-center gap-3">
          <button class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm" type="submit">
            Simpan Soal Essay
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
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/summernote/summernote.css')}}">
@endpush
@push('scripts')
<script src="{{URL::asset('assets/plugins/summernote/summernote.min.js')}}"></script>
<script>
  $(document).ready(function() {
    $('.textarea').summernote({
      height: 200,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture', 'table']],
        ['view', ['fullscreen', 'codeview']]
      ]
    });
  });
</script>
@endpush