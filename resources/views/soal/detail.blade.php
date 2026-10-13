@extends('layouts.app')
@section('title', 'Detail soal')
@section('breadcrumb')
<h1><i class="fa fa-book"></i> Data Soal</h1>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-4">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">Informasi</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <a href="{{ url('/elearning/soal/ubah/'.$id_soal) }}" class="btn btn-primary btn-md">Ubah Data</a>
      <hr style="margin: 10px 0">
      <table class="table table-condensed">
        <tbody>
          <tr>
            <td width="100px">Nama Paket</td>
            <td width="15px">:</td>
            <td>{{ $soal->paket }}</td>
          </tr>
          <tr>
            <td>ID Paket</td>
            <td>:</td>
            <td>{{ $soal->id }}</td>
          </tr>
          <tr>
            <td>Deskripsi</td>
            <td>:</td>
            <td>{{ $soal->deskripsi }}</td>
          </tr>
          <tr>
            <td>Waktu</td>
            <td>:</td>
            <td>{{ $soal->waktu.' Detik' }}</td>
          </tr>
          <tr>
            <td>Jenis Soal</td>
            <td>:</td>
            <td>{{ $soal->jenis }}</td>
          </tr>
          <tr>
            <td>Password</td>
            <td>:</td>
            <td>{{ $soal->password }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="col-md-8">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Soal Pilihan Ganda</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <button type="button" id="btn-soal" class="btn btn-primary btn-md">Tulis Soal</button>
      {{-- <button type="button" id="btn-upload-soal" class="btn btn-success btn-md">Import via Excel</button>
      <a class="pull-right" href="{{ url('/download-file-format/soal') }}">Download format Excel</a> --}}
      <div style="display: none;" id="wrap-soal">
        <form class="form-horizontal" id="form-soal">
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">Soal</label>
              <div class="col-sm-10">
                <input type="hidden" name="id" value="N">
                <!-- <input type="hidden" name="id_soal" value="N"> -->
                <input type="hidden" name="jenis" value="1">
                <input type="hidden" name="sesi" value="{{ md5(rand(0000000000, mt_getrandmax())) }}">
                <textarea class="form-control textarea" name="soal" placeholder="Soal"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Pilihan A</label>
              <div class="col-sm-10">
                <textarea class="form-control textarea" name="pila" placeholder="Pilihan A"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Pilihan B</label>
              <div class="col-sm-10">
                <textarea class="form-control textarea" name="pilb" placeholder="Pilihan B"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Pilihan C</label>
              <div class="col-sm-10">
                <textarea class="form-control textarea" name="pilc" placeholder="Pilihan C"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Pilihan D</label>
              <div class="col-sm-10">
                <textarea class="form-control textarea" name="pild" placeholder="Pilihan D"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Pilihan E</label>
              <div class="col-sm-10">
                <textarea class="form-control textarea" name="pile" placeholder="Pilihan E"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Kunci</label>
              <div class="col-sm-10">
                <div class="radio">
                  <label><input type="radio" name="kunci" id="a" value="A"> Jawaban <b>A</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="kunci" id="b" value="B"> Jawaban <b>B</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="kunci" id="c" value="C"> Jawaban <b>C</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="kunci" id="d" value="D"> Jawaban <b>D</b></label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="kunci" id="e" value="E"> Jawaban <b>E</b></label>
                </div>
              </div>
            </div>
            <div class="form-group" style="margin-top: 15px">
              <label class="col-sm-2 control-label">Score</label>
              <div class="col-sm-2">
                <input type="text" class="form-control numOnly" name="score" placeholder="Score">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Status</label>
              <div class="col-sm-10">
                <div class="radio">
                  <label><input type="radio" name="status" id="y" value="Y"> Tampil</label> &nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="status" id="n" value="N"> Tidak tampil</label>
                </div>
              </div>
            </div>
            <div class="form-group" style="margin-top: 20px">
              <div class="col-sm-offset-2 col-sm-10">
                <div id="notif-soal" style="display: none;"></div>
                <img src="{{ url('/assets/images/facebook.gif') }}" style="display: none;" id="loading-soal">
                <div id="wrap-btn">
                  <button type="button" class="btn btn-danger" id="batal">Batal</button>
                  <button type="button" class="btn btn-success" id="simpan-soal">Simpan</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="well" style="margin-top: 15px; display: none;" id="wrap-upload-soal">
        {{-- <form class="form-horizontal" action="{{ url('/crud/simpan-detail-soal-via-excel') }}" enctype="multipart/form-data" method="POST">
          {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <input type="file" name="file" id="file" class="inputfile" />
              <label for="file"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Pilih file excel</label>
              <p class="help-block">Silahkan pilih file format soal dalam bentuk excel yang telah diisi dengan benar.</p>
            </div>
            <div class="box-footer">
              <input class="btn btn-danger" id="batal-upload" type="button" value="Batal" />
              <input class="btn btn-primary" name="upload" type="submit" value="Import" />
            </div>
          </div>
        </form> --}}
      </div>
      <hr style="margin: 10px 0">
      <table class="table table-hover table-striped" id="table_detail_soal">
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
            <th style="text-align: center; width: 150px">Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <!--<div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title">Soal Essay</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <button type="button" id="btn-soal-essay" class="btn btn-primary btn-md">Tulis Soal</button>
      <form class="form-horizontal" action="{{ url('elearning/soal/essay') }}" method="POST" style="display: none" id="form-essay">
        {{ csrf_field() }}
        <input type="hidden" name="soal_id" value="{{ $soal->id }}">
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">Soal</label>
            <div class="col-sm-10">
              <textarea class="form-control textarea" name="soal" placeholder="Soal"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10">
              <div class="radio">
                <label><input type="radio" name="status" id="y" value="Y"> Tampil</label> &nbsp;&nbsp;&nbsp;
                <label><input type="radio" name="status" id="n" value="N"> Tidak tampil</label>
              </div>
            </div>
          </div>
          <div class="form-group" style="margin-top: 20px">
            <div class="col-sm-offset-2 col-sm-10">
              <input class="btn btn-danger" id="batal-simpan-essay" type="button" value="Batal" />
              <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
          </div>
        </div>
      </form>
      <div style="height: 20px">&nbsp;</div>
      <table class="table table-hover table-striped" id="table_detail_soal_essay">
        <thead>
          <tr>
            <th>Soal</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
      </table>

    </div>
  </div>-->
</div>
<div class="modal fade" id="del-soal">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger">Hapus Soal</h4>
          </div>
            <div class="modal-body">
                <form role="form" id="delete" action="{{ route('soal.hapus') }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="hidden" id="id_soal" name="id_soal">
                </form>
                <div>
                    <p>Anda yakin ingin menghapus soal ini?</p>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
                <button id="button-delete" type="button" class="btn btn-danger" onclick="$('#delete').submit();">{{ __('Ya, hapus') }}</button>
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
  .panel {
    margin-bottom: 5px !important;
  }

  .form-group {
    margin-bottom: 5px;
  }

  .label-success {
    background-color: #ffffff !important;
    border: solid thin #00a65a;
    color: #018833 !important;
  }

  .label-danger {
    background-color: #ffffff !important;
    border: solid thin #a70909;
    color: #da1616 !important;
  }

  .inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
  }

  .inputfile+label {
    font-size: 1.25em;
    font-weight: 700;
    color: white;
    background-color: green;
    display: inline-block;
    padding: 10px;
  }

  .inputfile:focus+label,
  .inputfile+label:hover {
    background-color: darkgreen;
  }

  .inputfile+label {
    cursor: pointer;
  }

  .inputfile:focus+label {
    outline: 1px dotted #000;
    outline: -webkit-focus-ring-color auto 5px;
  }

  .inputfile+label * {
    pointer-events: none;
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
  $(document).ready(function() {
    $("#btn-soal").click(function() {
      $("#wrap-soal").slideToggle();
    });
    $("#batal").click(function() {
      $("#wrap-soal").slideToggle();
    });
    $("#btn-upload-soal").click(function() {
      $("#wrap-soal").hide();
      $("#wrap-upload-soal").slideToggle();
    })
    $("#batal-upload").click(function() {
      $("#wrap-upload-soal").slideToggle();
    })
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

    var id = document.URL;
    var id = id.split('/');
    var id = id[id.length - 1];
    table_soal = $('#table_detail_soal').DataTable({
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
      columns: [{
          data: 'soal',
          name: 'soal',
          orderable: true,
          searchable: true
        },
        {
          data: 'pila',
          name: 'pila',
          "visible": false,
          orderable: true,
          searchable: true
        },
        {
          data: 'pilb',
          name: 'pilb',
          "visible": false,
          orderable: true,
          searchable: true
        },
        {
          data: 'pilc',
          name: 'pilc',
          "visible": false,
          orderable: true,
          searchable: true
        },
        {
          data: 'pild',
          name: 'pild',
          "visible": false,
          orderable: true,
          searchable: true
        },
        {
          data: 'pile',
          name: 'pile',
          "visible": false,
          orderable: true,
          searchable: true
        },
        {
          data: 'kunci',
          name: 'kunci',
          orderable: true,
          searchable: true
        },
        {
          data: 'score',
          name: 'score',
          orderable: true,
          searchable: true
        },
        {
          data: 'status',
          name: 'status',
          orderable: true,
          searchable: true
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false,
        },
      ],
      "drawCallback": function(setting) {}
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
            location.reload();
          } else {
            $("#notif-soal").removeClass('alert alert-info').addClass('alert alert-danger').html(data).show();
          }
        }
      })
    });

    $("#btn-soal-essay").click(function() {
      $("#form-essay").slideToggle();
    });

    $("#batal-simpan-essay").click(function(){
      $("#form-essay").slideUp();
    })

    let table_soal_essay = $("#table_detail_soal_essay").DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      lengthChange: true,
      ajax: {
        url: "{{ url('elearning/soal/essay/data') }}",
        data: function(d) {
          d.id_soal = "{{ $soal->id }}"
        }
      },
      columns: [{
        data: 'soal',
        name: 'soal'
      }, {
        data: 'status',
        name: 'status'
      }, {
        data: 'action',
        name: 'action'
      }]
    });
  });


function deleteSoal(id_soal, paketSoal) {
  $("#id_soal").val(id_soal);
  $("#paket_soal").text(paketSoal);
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