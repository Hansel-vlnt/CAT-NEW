@extends('layouts.app')
@section('title', 'Detail Paket Soal: ' . $soal->paket)
@section('breadcrumb')
  <div class="w-full max-w-7xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 py-1">
    <div>
      <div class="text-xs text-slate-500 font-bold uppercase tracking-wider">Bank Soal &bull; Manajemen Butir</div>
      <h1 class="text-2xl font-black text-slate-900 mt-0.5 tracking-tight">Detail Paket Soal</h1>
    </div>
    <div class="flex items-center gap-2">
      <a href="{{ url('/elearning/soal') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition flex items-center gap-2 shadow-sm">
        <i class="fa fa-arrow-left"></i> Kembali ke Katalog
      </a>
      <a href="{{ url('/elearning/soal/ubah/'.$id_soal) }}" class="px-4 py-2 rounded-xl bg-indigo-50 border border-indigo-200 hover:bg-indigo-100 text-indigo-700 text-xs font-bold transition flex items-center gap-2 shadow-sm">
        <i class="fa fa-pencil"></i> Edit Info Paket
      </a>
    </div>
  </div>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="w-full max-w-7xl space-y-6">

    <!-- Top Action Card: Info Paket & Quick Stats -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
      <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="space-y-2">
          <div class="flex flex-wrap items-center gap-2">
            <span class="px-3 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-bold uppercase tracking-wider">
              {{ $soal->kategori_utama ?? 'Kedinasan / SKD BKN' }}
            </span>
            @if(!empty($soal->sub_kategori))
              <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold uppercase tracking-wider">
                {{ $soal->sub_kategori }}
              </span>
            @endif
            <span class="text-xs text-slate-400 font-semibold">ID Paket: #{{ $soal->id }}</span>
          </div>
          <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $soal->paket }}</h2>
          @if(!empty($soal->deskripsi))
            <p class="text-sm text-slate-600 max-w-3xl leading-relaxed">{{ $soal->deskripsi }}</p>
          @endif
        </div>

        <div class="flex flex-wrap items-center gap-2.5 shrink-0">
          <button type="button" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center gap-2 shadow-sm cursor-pointer" data-toggle="modal" data-target="#modal-import-soal">
            <i class="fa fa-file-excel-o"></i> Import Excel
          </button>
          <button type="button" id="btn-soal" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition flex items-center gap-2 shadow-sm cursor-pointer">
            <i class="fa fa-plus"></i> Tambah Butir Soal
          </button>
        </div>
      </div>

      <!-- Quick Specs Pills Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6 pt-6 border-t border-slate-100">
        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60">
          <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Durasi Pengerjaan</div>
          <div class="text-lg font-bold text-slate-900 mt-0.5">{{ round($soal->waktu / 60) }} Menit</div>
          <div class="text-xs text-slate-400">Total: {{ number_format($soal->waktu, 0, ',', '.') }} detik</div>
        </div>

        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60">
          <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Passing Grade (KKM)</div>
          <div class="text-lg font-bold text-emerald-600 mt-0.5">{{ $soal->kkm ?? 70 }} Poin</div>
          <div class="text-xs text-slate-400">Standar kelulusan</div>
        </div>

        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60">
          <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Model Waktu</div>
          <div class="text-lg font-bold text-slate-900 mt-0.5">{{ $soal->jenis_soal == 0 ? 'Total Paket' : 'Per Nomor' }}</div>
          <div class="text-xs text-slate-400">Mode pengerjaan CBT</div>
        </div>

        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60">
          <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Token Akses</div>
          <div class="text-lg font-mono font-bold text-slate-900 mt-0.5">{{ $soal->password ?: 'Bebas Akses' }}</div>
          <div class="text-xs text-slate-400">{{ $soal->password ? 'Wajib verifikasi token' : 'Tanpa password token' }}</div>
        </div>
      </div>
    </div>

    <!-- Full-Width Card: Butir Soal Table -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
        <div>
          <h3 class="text-xl font-bold text-slate-900">Daftar Butir Soal</h3>
          <p class="text-sm text-slate-500 mt-0.5">Kelola butir soal, kunci jawaban, dan bobot skor pada paket ini.</p>
        </div>
      </div>

      <!-- Form Tambah Soal Baru (Collapsible) -->
      <div style="display: none; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; margin-bottom: 24px;" id="wrap-soal">
          <h4 style="margin-top: 0; font-weight: 700; color: #1e293b; margin-bottom: 16px;">
            <i class="fa fa-pencil-square-o text-primary"></i> Tulis Butir Soal Baru
          </h4>
          <form class="form-horizontal" id="form-soal">
            <input type="hidden" name="id" value="N">
            <input type="hidden" name="jenis" value="1">
            <input type="hidden" name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">

            <!-- Tipe Soal -->
            <div class="form-group">
              <label class="col-sm-3 control-label">Tipe Soal</label>
              <div class="col-sm-9">
                <label class="radio-inline" style="font-weight: 500;">
                  <input type="radio" name="tipe_soal" value="single" checked onchange="toggleFormTipeSoal('single')"> Single Key (1 Opsi)
                </label>
                <label class="radio-inline" style="font-weight: 500;">
                  <input type="radio" name="tipe_soal" value="multi" onchange="toggleFormTipeSoal('multi')"> Multi Key (Pilih > 1)
                </label>
                <label class="radio-inline" style="font-weight: 500;">
                  <input type="radio" name="tipe_soal" value="tkp" onchange="toggleFormTipeSoal('tkp')"> TKP Berbobot (1-5 Poin)
                </label>
              </div>
            </div>

            <!-- Teks Soal -->
            <div class="form-group">
              <label class="col-sm-3 control-label">Pertanyaan Soal</label>
              <div class="col-sm-9">
                <textarea class="form-control textarea-main" name="soal" placeholder="Tuliskan pertanyaan soal di sini..."></textarea>
              </div>
            </div>

            <!-- Opsi Jawaban -->
            <div class="form-group">
              <label class="col-sm-3 control-label">Pilihan A</label>
              <div class="col-sm-9">
                <textarea class="form-control textarea-opt" name="pila" placeholder="Pilihan A"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Pilihan B</label>
              <div class="col-sm-9">
                <textarea class="form-control textarea-opt" name="pilb" placeholder="Pilihan B"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Pilihan C</label>
              <div class="col-sm-9">
                <textarea class="form-control textarea-opt" name="pilc" placeholder="Pilihan C"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Pilihan D</label>
              <div class="col-sm-9">
                <textarea class="form-control textarea-opt" name="pild" placeholder="Pilihan D"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Pilihan E</label>
              <div class="col-sm-9">
                <textarea class="form-control textarea-opt" name="pile" placeholder="Pilihan E"></textarea>
              </div>
            </div>

            <!-- Kunci Jawaban Single vs Multi vs TKP -->
            <div class="form-group" id="form-wrap-kunci-single">
              <label class="col-sm-3 control-label">Kunci Jawaban</label>
              <div class="col-sm-9">
                <div class="radio">
                  <label><input type="radio" name="kunci" value="A" checked> <b>A</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="kunci" value="B"> <b>B</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="kunci" value="C"> <b>C</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="kunci" value="D"> <b>D</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="kunci" value="E"> <b>E</b></label>
                </div>
              </div>
            </div>

            <div class="form-group" id="form-wrap-kunci-multi" style="display: none;">
              <label class="col-sm-3 control-label">Kunci Jawaban Multi</label>
              <div class="col-sm-9">
                <div class="checkbox">
                  <label><input type="checkbox" name="kunci[]" value="A"> <b>A</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="checkbox" name="kunci[]" value="B"> <b>B</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="checkbox" name="kunci[]" value="C"> <b>C</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="checkbox" name="kunci[]" value="D"> <b>D</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="checkbox" name="kunci[]" value="E"> <b>E</b></label>
                </div>
                <small class="text-muted">Pilih dua atau lebih opsi benar.</small>
              </div>
            </div>

            <div class="form-group" id="form-wrap-kunci-tkp" style="display: none;">
              <label class="col-sm-3 control-label">Bobot Opsi TKP (1 - 5 Poin)</label>
              <div class="col-sm-9">
                <div class="row" style="margin-left: -5px; margin-right: -5px;">
                  @foreach(['A' => 5, 'B' => 4, 'C' => 3, 'D' => 2, 'E' => 1] as $huruf => $val)
                    <div class="col-xs-6 col-sm-2" style="padding: 0 5px; margin-bottom: 8px;">
                      <label style="font-size: 12px; margin-bottom: 2px;">Opsi <b>{{ $huruf }}</b></label>
                      <input type="number" min="0" max="10" name="bobot_opsi[{{ $huruf }}]" value="{{ $val }}" class="form-control input-sm numOnly" style="text-align: center; font-weight: bold;">
                    </div>
                  @endforeach
                </div>
                <small class="text-muted">Tentukan poin untuk masing-masing opsi jawaban (standar SKD TKP: 1 sampai 5 poin).</small>
              </div>
            </div>

            <!-- Skor dan Status -->
            <div class="form-group">
              <label class="col-sm-3 control-label">Score / Poin</label>
              <div class="col-sm-3">
                <input type="text" class="form-control numOnly" name="score" value="5" placeholder="Score">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Status Soal</label>
              <div class="col-sm-9">
                <label class="radio-inline"><input type="radio" name="status" value="Y" checked> Tampil (Aktif)</label>
                <label class="radio-inline"><input type="radio" name="status" value="N"> Tidak Tampil</label>
              </div>
            </div>

            <!-- Dual Pembahasan -->
            <hr style="margin: 15px 0;">
            <div class="form-group">
              <label class="col-sm-3 control-label">
                <span class="text-success"><i class="fa fa-bolt"></i> Trik Cepat / Solusi Praktis</span>
              </label>
              <div class="col-sm-9">
                <textarea class="form-control textarea-main" name="pembahasan_cepat" placeholder="Trik ringkas 30 detik atau eliminasi opsi cepat..."></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">
                <span class="text-primary"><i class="fa fa-book"></i> Pembahasan Konseptual</span>
              </label>
              <div class="col-sm-9">
                <textarea class="form-control textarea-main" name="pembahasan_konsep" placeholder="Pembahasan teoritis komprehensif dan runtut..."></textarea>
              </div>
            </div>

            <!-- Tombol Aksi Simpan -->
            <div class="form-group" style="margin-top: 20px">
              <div class="col-sm-offset-3 col-sm-9">
                <div id="notif-soal" style="display: none; margin-bottom: 10px;"></div>
                <img src="{{ url('/assets/images/facebook.gif') }}" style="display: none;" id="loading-soal">
                <div id="wrap-btn">
                  <button type="button" class="btn btn-default" id="batal">Batal</button>
                  <button type="button" class="btn btn-success" id="simpan-soal" style="font-weight: 600; padding: 6px 18px;">
                    <i class="fa fa-check"></i> Simpan Butir Soal
                  </button>
                </div>
              </div>
            </div>

          </form>
        </div>

        <!-- Tabel Data Soal -->
        <table class="table table-hover table-striped" id="table_detail_soal" style="width: 100%;">
          <thead>
            <tr>
              <th>Soal</th>
              <th>Pilihan A</th>
              <th>Pilihan B</th>
              <th>Pilihan C</th>
              <th>Pilihan D</th>
              <th>Pilihan E</th>
              <th style="text-align: center;">Kunci</th>
              <th style="text-align: center;">Score</th>
              <th style="text-align: center;">Status</th>
              <th style="text-align: center; width: 140px">Aksi</th>
            </tr>
          </thead>
        </table>
    </div>
  </div>
</div>

<!-- Modal Import Soal Excel -->
<div class="modal fade" id="modal-import-soal">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 12px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-weight: 700;"><i class="fa fa-file-excel-o text-success"></i> Import Butir Soal via Excel</h4>
      </div>
      <form action="{{ url('/crud/simpan-detail-soal-via-excel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body" style="padding: 20px;">
          <input type="hidden" name="id_soal" value="{{ $soal->id }}">
          <div class="form-group">
            <label style="font-weight: 600; margin-bottom: 6px;">Pilih File Excel (.xlsx / .xls)</label>
            <input type="file" name="file" required class="form-control" accept=".xlsx,.xls">
          </div>
          <div class="alert alert-info" style="font-size: 12px; margin-bottom: 0;">
            <i class="fa fa-info-circle"></i> Pastikan format file sesuai dengan template.
            <div style="margin-top: 6px;">
              <a href="{{ url('/download-file-format/soal') }}" class="btn btn-default btn-xs" style="font-weight: 600;">
                <i class="fa fa-download"></i> Unduh Format Soal Excel
              </a>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success font-bold"><i class="fa fa-upload"></i> Unggah &amp; Import</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus Soal -->
<div class="modal fade" id="del-soal">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 8px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-weight: 600;">Hapus Butir Soal</h4>
      </div>
      <div class="modal-body">
        <form role="form" id="delete" action="{{ route('soal.hapus') }}" method="post">
          @csrf
          @method('delete')
          <input type="hidden" id="id_soal" name="id_soal">
        </form>
        <p>Anda yakin ingin menghapus butir soal ini? Tindakan ini tidak dapat dibatalkan.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button id="button-delete" type="button" class="btn btn-danger" onclick="$('#delete').submit();">Ya, Hapus</button>
      </div>
    </div>
  </div>
    </div>
  </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/summernote/summernote.css')}}">
<style type="text/css">
  .panel { margin-bottom: 5px !important; }
  .form-group { margin-bottom: 10px; }
  .label-success {
    background-color: #ecfdf5 !important;
    border: solid 1px #10b981;
    color: #047857 !important;
  }
  .label-danger {
    background-color: #fef2f2 !important;
    border: solid 1px #f87171;
    color: #b91c1c !important;
  }
</style>
@endpush

@push('scripts')
<script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script src="{{URL::asset('assets/plugins/summernote/summernote.min.js')}}"></script>
<script>
function toggleFormTipeSoal(tipe) {
  if (tipe === 'multi') {
    $('#form-wrap-kunci-single').hide().find('input').prop('disabled', true);
    $('#form-wrap-kunci-tkp').hide().find('input').prop('disabled', true);
    $('#form-wrap-kunci-multi').show().find('input').prop('disabled', false);
  } else if (tipe === 'tkp') {
    $('#form-wrap-kunci-single').hide().find('input').prop('disabled', true);
    $('#form-wrap-kunci-multi').hide().find('input').prop('disabled', true);
    $('#form-wrap-kunci-tkp').show().find('input').prop('disabled', false);
  } else {
    $('#form-wrap-kunci-multi').hide().find('input').prop('disabled', true);
    $('#form-wrap-kunci-tkp').hide().find('input').prop('disabled', true);
    $('#form-wrap-kunci-single').show().find('input').prop('disabled', false);
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

$(document).ready(function() {
  toggleFormTipeSoal('single');

  $("#btn-soal").click(function() {
    $("#wrap-soal").slideToggle();
  });
  $("#batal").click(function() {
    $("#wrap-soal").slideToggle();
  });

  $('.textarea-main').summernote({
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
    fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48', '64', '82', '150'],
    callbacks: {
      onImageUpload: function(files) {
        sendFile(files[0], this);
      }
    }
  });

  $('.textarea-opt').summernote({
    toolbar: [
      ['font', ['bold', 'italic', 'underline', 'clear']],
      ['insert', ['picture']]
    ],
    height: 75,
    callbacks: {
      onImageUpload: function(files) {
        sendFile(files[0], this);
      }
    }
  });

  var pathParts = window.location.pathname.split('/');
  var id = pathParts[pathParts.length - 1];

  var table_soal = $('#table_detail_soal').DataTable({
    processing: true,
    serverSide: true,
    responsive: false,
    autoWidth: false,
    lengthChange: true,
    pageLength: 10,
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Cari butir soal...",
      lengthMenu: "Tampilkan _MENU_ butir",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ butir soal",
      infoEmpty: "Tidak ada butir soal",
      zeroRecords: "Butir soal tidak ditemukan",
      paginate: {
        first: "Awal",
        last: "Akhir",
        next: "Berikutnya",
        previous: "Sebelumnya"
      }
    },
    ajax: {
      url: "{!! route('elearning.get-detail-soal') !!}",
      data: function(d) {
        d.id = id;
      }
    },
    columns: [
      { data: 'soal', name: 'soal', orderable: true, searchable: true, width: '55%' },
      { data: 'pila', name: 'pila', visible: false, orderable: true, searchable: true },
      { data: 'pilb', name: 'pilb', visible: false, orderable: true, searchable: true },
      { data: 'pilc', name: 'pilc', visible: false, orderable: true, searchable: true },
      { data: 'pild', name: 'pild', visible: false, orderable: true, searchable: true },
      { data: 'pile', name: 'pile', visible: false, orderable: true, searchable: true },
      { data: 'kunci', name: 'kunci', orderable: true, searchable: true, className: 'text-center', width: '8%' },
      { data: 'score', name: 'score', orderable: true, searchable: true, className: 'text-center', width: '8%' },
      { data: 'status', name: 'status', orderable: true, searchable: true, className: 'text-center', width: '12%' },
      { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center', width: '17%' }
    ]
  });

  $("#simpan-soal").click(function() {
    $("#wrap-btn").hide();
    $("#loading-soal").show();
    var dataString = $("#form-soal").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/simpan-detail-soal') }}",
      data: dataString + "&id_soal=" + id,
      success: function(data) {
        $("#loading-soal").hide();
        $("#wrap-btn").show();
        if (data == 'ok') {
          $("#notif-soal").removeClass('alert alert-danger').addClass('alert alert-info').html("Soal berhasil disimpan.").show();
          $("#form-soal")[0].reset();
          $('.textarea-main, .textarea-opt').summernote('reset');
          setTimeout(function() {
            $("#notif-soal").hide();
            $("#wrap-soal").slideUp();
            table_soal.ajax.reload(null, false);
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

function deleteSoal(id_soal) {
  $("#id_soal").val(id_soal);
}
</script>

@if(Session::has('success'))
  <script>
    swal("", '{!! Session::get("success") !!}', "success");
  </script>
@endif
@if(Session::has('error'))
  <script>
    swal("", '{!! Session::get("error") !!}', "error");
  </script>
@endif
@endpush