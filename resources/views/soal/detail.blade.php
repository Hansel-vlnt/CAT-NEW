@extends('layouts.app')
@section('title', 'Detail Paket Soal: ' . $soal->paket)
@section('breadcrumb')
  <h1><i class="fa fa-book"></i> Manajemen Bank Soal</h1>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="row">
  <!-- Kolom Kiri: Informasi Paket -->
  <div class="col-md-4">
    <div class="box box-primary" style="border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
      <div class="box-header with-border" style="padding: 16px 20px;">
        <h3 class="box-title" style="font-size: 15px; font-weight: 600;">Informasi Paket Soal</h3>
      </div>
      <div class="box-body" style="padding: 18px 20px;">
        <div style="margin-bottom: 14px;">
          <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Nama Paket</span>
          <h4 style="margin: 4px 0 0 0; font-weight: 700; color: #0f172a;">{{ $soal->paket }}</h4>
        </div>

        <table class="table table-condensed" style="margin-bottom: 16px;">
          <tbody>
            <tr>
              <td style="color: #64748b; font-weight: 500; width: 110px;">ID Paket</td>
              <td width="10px">:</td>
              <td style="font-weight: 600; color: #1e293b;">#{{ $soal->id }}</td>
            </tr>
            <tr>
              <td style="color: #64748b; font-weight: 500;">Kategori Utama</td>
              <td>:</td>
              <td><span class="label label-primary">{{ $soal->kategori_utama ?? 'Kedinasan / SKD BKN' }}</span></td>
            </tr>
            <tr>
              <td style="color: #64748b; font-weight: 500;">Sub Kategori</td>
              <td>:</td>
              <td style="font-weight: 500;">{{ $soal->sub_kategori ?? 'Umum' }}</td>
            </tr>
            <tr>
              <td style="color: #64748b; font-weight: 500;">Deskripsi</td>
              <td>:</td>
              <td style="font-size: 13px;">{{ $soal->deskripsi }}</td>
            </tr>
            <tr>
              <td style="color: #64748b; font-weight: 500;">Durasi Pengerjaan</td>
              <td>:</td>
              <td style="font-weight: 600; color: #0f172a;">{{ round($soal->waktu / 60) }} Menit ({{ $soal->waktu }} Detik)</td>
            </tr>
            <tr>
              <td style="color: #64748b; font-weight: 500;">Tipe Tryout</td>
              <td>:</td>
              <td>{{ $soal->jenis }}</td>
            </tr>
            <tr>
              <td style="color: #64748b; font-weight: 500;">Token / Password</td>
              <td>:</td>
              <td><code style="background: #f1f5f9; color: #0f172a; font-weight: 700;">{{ $soal->password ?: 'Tanpa Token' }}</code></td>
            </tr>
          </tbody>
        </table>

        <div style="display: flex; gap: 8px;">
          <a href="{{ url('/elearning/soal/ubah/'.$id_soal) }}" class="btn btn-default btn-sm" style="flex: 1;">
            <i class="fa fa-pencil"></i> Edit Info Paket
          </a>
          <a href="{{ url('/elearning/soal') }}" class="btn btn-default btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Kolom Kanan: Butir Soal -->
  <div class="col-md-8">
    <div class="box box-primary" style="border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
      <div class="box-header with-border" style="padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;">
        <h3 class="box-title" style="font-size: 15px; font-weight: 600;">Daftar Butir Soal</h3>
        <div>
          <button type="button" id="btn-soal" class="btn btn-primary btn-sm" style="font-weight: 600;">
            <i class="fa fa-plus"></i> Tambah Butir Soal
          </button>
        </div>
      </div>

      <div class="box-body" style="padding: 20px;">
        <!-- Form Tambah Soal Baru (Collapsible) -->
        <div style="display: none; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 24px;" id="wrap-soal">
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
                  <input type="radio" name="tipe_soal" value="tkp" onchange="toggleFormTipeSoal('tkp')"> TKP Berbobot
                </label>
              </div>
            </div>

            <!-- Teks Soal -->
            <div class="form-group">
              <label class="col-sm-3 control-label">Pertanyaan Soal</label>
              <div class="col-sm-9">
                <textarea class="form-control textarea" name="soal" placeholder="Tuliskan pertanyaan soal di sini..."></textarea>
              </div>
            </div>

            <!-- Opsi Jawaban -->
            <div class="form-group">
              <label class="col-sm-3 control-label">Pilihan A</label>
              <div class="col-sm-9">
                <textarea class="form-control textarea" name="pila" placeholder="Pilihan A"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Pilihan B</label>
              <div class="col-sm-9">
                <textarea class="form-control textarea" name="pilb" placeholder="Pilihan B"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Pilihan C</label>
              <div class="col-sm-9">
                <textarea class="form-control textarea" name="pilc" placeholder="Pilihan C"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Pilihan D</label>
              <div class="col-sm-9">
                <textarea class="form-control textarea" name="pild" placeholder="Pilihan D"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Pilihan E</label>
              <div class="col-sm-9">
                <textarea class="form-control textarea" name="pile" placeholder="Pilihan E"></textarea>
              </div>
            </div>

            <!-- Kunci Jawaban Single vs Multi -->
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
                <textarea class="form-control textarea" name="pembahasan_cepat" placeholder="Trik ringkas 30 detik atau eliminasi opsi cepat..."></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">
                <span class="text-primary"><i class="fa fa-book"></i> Pembahasan Konseptual</span>
              </label>
              <div class="col-sm-9">
                <textarea class="form-control textarea" name="pembahasan_konsep" placeholder="Pembahasan teoritis komprehensif dan runtut..."></textarea>
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
    $('#form-wrap-kunci-single').hide();
    $('#form-wrap-kunci-multi').show();
  } else {
    $('#form-wrap-kunci-single').show();
    $('#form-wrap-kunci-multi').hide();
  }
}

$(document).ready(function() {
  $("#btn-soal").click(function() {
    $("#wrap-soal").slideToggle();
  });
  $("#batal").click(function() {
    $("#wrap-soal").slideToggle();
  });

  $('.textarea').summernote({
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
    height: 100,
    fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48', '64', '82', '150']
  });

  var pathParts = window.location.pathname.split('/');
  var id = pathParts[pathParts.length - 1];

  var table_soal = $('#table_detail_soal').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    ajax: {
      url: "{!! route('elearning.get-detail-soal') !!}",
      data: function(d) {
        d.id = id;
      }
    },
    columns: [
      { data: 'soal', name: 'soal', orderable: true, searchable: true },
      { data: 'pila', name: 'pila', visible: false, orderable: true, searchable: true },
      { data: 'pilb', name: 'pilb', visible: false, orderable: true, searchable: true },
      { data: 'pilc', name: 'pilc', visible: false, orderable: true, searchable: true },
      { data: 'pild', name: 'pild', visible: false, orderable: true, searchable: true },
      { data: 'pile', name: 'pile', visible: false, orderable: true, searchable: true },
      { data: 'kunci', name: 'kunci', orderable: true, searchable: true },
      { data: 'score', name: 'score', orderable: true, searchable: true },
      { data: 'status', name: 'status', orderable: true, searchable: true },
      { data: 'action', name: 'action', orderable: false, searchable: false }
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
          setTimeout(function() { location.reload(); }, 600);
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