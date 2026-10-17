@extends('layouts.app')
@section('title', 'Ubah Soal #' . $soal->id)
@section('breadcrumb')
  <div class="w-full max-w-5xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 py-1">
    <div>
      <div class="text-xs text-slate-500 font-bold uppercase tracking-wider">Bank Soal &bull; Butir Pertanyaan</div>
      <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight"><i class="fa fa-pencil text-indigo-600 mr-1.5"></i> Ubah Soal & Pembahasan</h1>
    </div>
    <a href="{{ url('elearning/soal/detail/'.$soal->id_soal) }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition flex items-center gap-2 shadow-sm">
      <i class="fa fa-arrow-left"></i> Kembali ke Paket
    </a>
  </div>
@endsection
@section('content')
<?php include(app_path().'/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="w-full max-w-5xl space-y-6">
  <div class="box box-primary" style="border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
    <div class="box-header with-border" style="padding: 16px 20px;">
      <h3 class="box-title" style="font-size: 16px; font-weight: 600;">Edit Butir Soal, Kunci, & Pembahasan</h3>
    </div>
    <div class="box-body" style="padding: 24px;">
      <div id="wrap-soal">
        <form class="form-horizontal" id="form-soal">
          <input type="hidden" name="id" value="{{ $soal->id }}">
          <input type="hidden" name="id_soal" value="{{ $soal->id_soal }}">
          <input type="hidden" name="jenis" value="@if($soal->jenis != ''){{ $soal->jenis }}@else 1 @endif">
          <input type="hidden" name="sesi" value="@if($soal->sesi != ''){{ $soal->sesi }}@else{{ md5(rand(0000000000, mt_getrandmax())) }}@endif">

          <!-- Tipe Soal -->
          <div class="form-group">
            <label class="col-sm-2 control-label">Tipe Soal</label>
            <div class="col-sm-10">
              <label class="radio-inline" style="font-weight: 500;">
                <input type="radio" name="tipe_soal" value="single" {{ ($soal->tipe_soal == 'single' || empty($soal->tipe_soal)) ? 'checked' : '' }} onchange="toggleTipeSoal('single')">
                Pilihan Ganda Tunggal (1 Kunci)
              </label>
              <label class="radio-inline" style="font-weight: 500;">
                <input type="radio" name="tipe_soal" value="multi" {{ ($soal->tipe_soal == 'multi') ? 'checked' : '' }} onchange="toggleTipeSoal('multi')">
                Pilihan Ganda Majemuk / Multi (Pilih Lebih Dari 1)
              </label>
              <label class="radio-inline" style="font-weight: 500;">
                <input type="radio" name="tipe_soal" value="tkp" {{ ($soal->tipe_soal == 'tkp') ? 'checked' : '' }} onchange="toggleTipeSoal('tkp')">
                TKP Kedinasan (Skala Nilai 1-5)
              </label>
            </div>
          </div>

          <hr style="margin: 15px 0;">

          <!-- Soal Text -->
          <div class="form-group">
            <label class="col-sm-2 control-label">Pertanyaan Soal</label>
            <div class="col-sm-10">
              <textarea class="form-control textarea" name="soal" placeholder="Tuliskan butir soal...">{{ $soal->soal }}</textarea>
            </div>
          </div>

          <!-- Opsi A - E -->
          <div class="form-group">
            <label class="col-sm-2 control-label">Pilihan A</label>
            <div class="col-sm-10">
              <textarea class="form-control textarea" name="pila" placeholder="Pilihan A">{{ $soal->pila }}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Pilihan B</label>
            <div class="col-sm-10">
              <textarea class="form-control textarea" name="pilb" placeholder="Pilihan B">{{ $soal->pilb }}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Pilihan C</label>
            <div class="col-sm-10">
              <textarea class="form-control textarea" name="pilc" placeholder="Pilihan C">{{ $soal->pilc }}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Pilihan D</label>
            <div class="col-sm-10">
              <textarea class="form-control textarea" name="pild" placeholder="Pilihan D">{{ $soal->pild }}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Pilihan E</label>
            <div class="col-sm-10">
              <textarea class="form-control textarea" name="pile" placeholder="Pilihan E">{{ $soal->pile }}</textarea>
            </div>
          </div>

          <hr style="margin: 15px 0;">

          <!-- Kunci Jawaban Single vs Multi -->
          <?php
            $kunci_arr = [];
            if ($soal->tipe_soal == 'multi') {
              $decoded = json_decode($soal->kunci, true);
              $kunci_arr = is_array($decoded) ? $decoded : explode(',', $soal->kunci);
            } else {
              $kunci_arr = [$soal->kunci];
            }
          ?>
          <div class="form-group" id="wrap-kunci-single" style="{{ $soal->tipe_soal == 'multi' ? 'display:none;' : '' }}">
            <label class="col-sm-2 control-label">Kunci Jawaban</label>
            <div class="col-sm-10">
              <div class="radio">
                @foreach(['A','B','C','D','E'] as $huruf)
                  <label style="margin-right: 18px;">
                    <input type="radio" name="kunci" value="{{ $huruf }}" {{ ($soal->kunci == $huruf) ? 'checked' : '' }}>
                    Jawaban <b>{{ $huruf }}</b>
                  </label>
                @endforeach
              </div>
            </div>
          </div>

          <div class="form-group" id="wrap-kunci-multi" style="{{ $soal->tipe_soal == 'multi' ? '' : 'display:none;' }}">
            <label class="col-sm-2 control-label">Kunci Multi (Pilih Semua yang Benar)</label>
            <div class="col-sm-10">
              <div class="checkbox">
                @foreach(['A','B','C','D','E'] as $huruf)
                  <label style="margin-right: 18px;">
                    <input type="checkbox" name="kunci[]" value="{{ $huruf }}" {{ in_array($huruf, $kunci_arr) ? 'checked' : '' }}>
                    Jawaban <b>{{ $huruf }}</b>
                  </label>
                @endforeach
              </div>
              <small class="text-muted">Centang dua atau lebih opsi yang merupakan kunci jawaban yang benar.</small>
            </div>
          </div>

          <?php
            $saved_bobot = !empty($soal->bobot_opsi) ? (is_array(json_decode($soal->bobot_opsi, true)) ? json_decode($soal->bobot_opsi, true) : []) : [];
            $default_bobots = ['A' => 5, 'B' => 4, 'C' => 3, 'D' => 2, 'E' => 1];
          ?>
          <div class="form-group" id="wrap-kunci-tkp" style="{{ $soal->tipe_soal == 'tkp' ? '' : 'display:none;' }}">
            <label class="col-sm-2 control-label">Bobot Opsi TKP (1 - 5 Poin)</label>
            <div class="col-sm-10">
              <div class="row" style="margin-left: -5px; margin-right: -5px;">
                @foreach(['A','B','C','D','E'] as $huruf)
                  <div class="col-xs-6 col-sm-2" style="padding: 0 5px; margin-bottom: 8px;">
                    <label style="font-size: 12px; margin-bottom: 2px;">Opsi <b>{{ $huruf }}</b></label>
                    <input type="number" min="0" max="10" name="bobot_opsi[{{ $huruf }}]" value="{{ isset($saved_bobot[$huruf]) ? $saved_bobot[$huruf] : (isset($default_bobots[$huruf]) ? $default_bobots[$huruf] : 1) }}" class="form-control input-sm numOnly" style="text-align: center; font-weight: bold;">
                  </div>
                @endforeach
              </div>
              <small class="text-muted">Tentukan nilai poin untuk setiap opsi jawaban (1-5 poin).</small>
            </div>
          </div>

          <!-- Bobot Score & Status -->
          <div class="form-group" style="margin-top: 15px">
            <label class="col-sm-2 control-label">Bobot Score</label>
            <div class="col-sm-3">
              <input type="text" class="form-control numOnly" name="score" placeholder="Score" value="{{ $soal->score }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Status Soal</label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <input type="radio" name="status" value="Y" {{ ($soal->status == 'Y') ? 'checked' : '' }}> Aktif (Tampil)
              </label>
              <label class="radio-inline">
                <input type="radio" name="status" value="N" {{ ($soal->status == 'N') ? 'checked' : '' }}> Non-aktif
              </label>
            </div>
          </div>

          <hr style="margin: 20px 0;">
          <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 16px;">
            <i class="fa fa-graduation-cap text-primary"></i> Modul Pembahasan & Solusi
          </h4>

          <!-- Pembahasan Cepat -->
          <div class="form-group">
            <label class="col-sm-2 control-label">
              <span class="text-success"><i class="fa fa-bolt"></i> Trik Cepat / Solusi Praktis</span>
            </label>
            <div class="col-sm-10">
              <textarea class="form-control textarea-main" name="pembahasan_cepat" placeholder="Tuliskan trik cepat 30 detik, kata kunci eliminasi opsi, atau rumus ringkas...">{{ $soal->pembahasan_cepat }}</textarea>
              <small class="text-muted">Trik cepat membantu siswa menyelesaikan soal secara efisien saat latihan berbatas waktu.</small>
            </div>
          </div>

          <!-- Pembahasan Konsep -->
          <div class="form-group">
            <label class="col-sm-2 control-label">
              <span class="text-primary"><i class="fa fa-book"></i> Pembahasan Konseptual</span>
            </label>
            <div class="col-sm-10">
              <textarea class="form-control textarea-main" name="pembahasan_konsep" placeholder="Tuliskan uraian konsep mendalam, asal mula rumus, atau teori dasar yang mendasari soal...">{{ $soal->pembahasan_konsep }}</textarea>
              <small class="text-muted">Langkah runtut dan dasar teori komprehensif untuk penguasaan materi jangka panjang.</small>
            </div>
          </div>

          <div class="form-group" style="margin-top: 30px">
            <div class="col-sm-offset-2 col-sm-10">
              <div id="notif-soal" style="display: none; margin-bottom: 15px;"></div>
              <img src="{{ url('/assets/images/facebook.gif') }}" style="display: none;" id="loading-soal">
              <div id="wrap-btn">
                <a href="{{ url('elearning/soal/detail/'.$soal->id_soal) }}" class="btn btn-default">
                  <i class="fa fa-arrow-left"></i> Kembali ke Paket
                </a>
                <button type="button" class="btn btn-success" id="simpan-soal" style="font-weight: 600; padding: 6px 20px;">
                  <i class="fa fa-check"></i> Simpan Perubahan
                </button>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
  </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/summernote/summernote.css')}}">
<style type="text/css">
  .panel { margin-bottom: 5px !important; }
  .form-group { margin-bottom: 12px; }
</style>
@endpush

@push('scripts')
<script src="{{URL::asset('assets/plugins/summernote/summernote.min.js')}}"></script>
<script>
function toggleTipeSoal(tipe) {
  if (tipe === 'multi') {
    $('#wrap-kunci-single').hide().find('input').prop('disabled', true);
    $('#wrap-kunci-tkp').hide().find('input').prop('disabled', true);
    $('#wrap-kunci-multi').show().find('input').prop('disabled', false);
  } else if (tipe === 'tkp') {
    $('#wrap-kunci-single').hide().find('input').prop('disabled', true);
    $('#wrap-kunci-multi').hide().find('input').prop('disabled', true);
    $('#wrap-kunci-tkp').show().find('input').prop('disabled', false);
  } else {
    $('#wrap-kunci-multi').hide().find('input').prop('disabled', true);
    $('#wrap-kunci-tkp').hide().find('input').prop('disabled', true);
    $('#wrap-kunci-single').show().find('input').prop('disabled', false);
  }
}

function sendFile(file, editor) {
  var data = new FormData();
  data.append("image", file);
  data.append("_token", "{{ csrf_token() }}");
  $.ajax({
    data: data,
    type: "POST",
    url: "{{ url('/crud/upload-gambar-soal') }}",
    cache: false,
    contentType: false,
    processData: false,
    success: function(url) {
      if (url) {
        $(editor).summernote('insertImage', url);
      }
    }
  });
}

$(document).ready(function (){
  toggleTipeSoal('{{ $soal->tipe_soal ?: "single" }}');

  $('.textarea, .textarea-main').summernote({
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'italic', 'underline', 'clear']],
      ['fontname', ['fontname']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['insert', ['link', 'picture', 'hr']],
      ['view', ['fullscreen', 'codeview']]
    ],
    height: 120,
    fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48' , '64', '82', '150'],
    callbacks: {
      onImageUpload: function(files) {
        sendFile(files[0], this);
      }
    }
  });

  $("#simpan-soal").click(function() {
    $("#wrap-btn").hide();
    $("#loading-soal").show();
    var dataString = $("#form-soal").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/simpan-detail-soal') }}",
      data: dataString,
      success: function(data){
        $("#loading-soal").hide();
        $("#wrap-btn").show();
        if (data == 'ok') {
          $("#notif-soal").removeClass('alert alert-danger').addClass('alert alert-info').html("Soal dan pembahasan berhasil diperbarui.").show();
          setTimeout(function(){
            window.location.href = "{{ url('elearning/soal/detail/'.$soal->id_soal) }}";
          }, 800);
        } else {
          $("#notif-soal").removeClass('alert alert-info').addClass('alert alert-danger').html(data).show();
        }
      },
      error: function() {
        $("#loading-soal").hide();
        $("#wrap-btn").show();
        $("#notif-soal").removeClass('alert alert-info').addClass('alert alert-danger').html("Terjadi kesalahan jaringan.").show();
      }
    });
  });
});
</script>
@endpush