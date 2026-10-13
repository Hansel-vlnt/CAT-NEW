@extends('layouts.app')
@section('title', __('Vouchers'))
@section('content')
@if($user->status == 'A')
<div class="widget-box">
  <div class="widget-header">
    <div class="widget-toolbar no-border">
      <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#tambah-data" onclick="addData()"><i class="fa fa-vcard"></i> Buat Voucher</button>
    </div>
  </div>
  <div class="box-body">
    <table class="table table-hover table-striped" id="table_voucher">
      <thead>
        <tr>
          <th>{{ __('No') }}</th>
          <th>{{ __('Kode Voucher') }}</th>
          <th>{{ __('Masa Berlaku') }}</th>
          <th>{{ __('Aksi') }}</th>
        </tr>
      </thead>
      <tbody>
      @if(count($vouchers) > 0)
        @foreach($vouchers as $key => $v)
          <tr>
            <td class="text-center">{{ $vouchers->firstItem() + $key }}</td>
            <td>{{ $v->kode_voucher }}</td>
            <td>{{ $v->masa_berlaku }} Hari</td>
            <td class="text-center"><button title="Copy Kode Voucher" type="button" class="btn btn-secondary btn-xs" onclick="copy('{{ $v->kode_voucher }}')"><i class="fa fa-copy"></i></button> <button title="Hapus" type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#del-data" onclick="deleteData({{ json_encode($vouchers[$loop->iteration-1]) }})"><i class="fa fa-trash"></i></button></td>
          </tr>
        @endforeach
      @else
          <tr>
              <td colspan="5">{{ __('Belum ada voucher') }}</td>
          </tr>
      @endif
      </tfoot>
    </table>
  </div>
</div>
<div class="float-right">
  {{ $vouchers->links("pagination::bootstrap-4") }}
</div>
<div class="modal fade" id="tambah-data">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="blue bigger">Buat Voucher</h4>
      </div>
      <div class="modal-body">
          <form role="form" id="save" action="{{ route('vouchers.save') }}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="hidden" id="id_voucher" name="id_voucher">
              <div class="form-group row">
                <label for="kode_voucher" class="col-sm-4 col-form-label">Kode Voucher</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="kode_voucher" name="kode_voucher" max="50">
                </div>
              </div>
              <div class="form-group row">
                <label for="masa_berlaku" class="col-sm-4 col-form-label">Masa Berlaku</label>
                <div class="col-sm-2 no-padding-right">
                  <input type="number" class="form-control" id="masa_berlaku" name="masa_berlaku" value="1" min="1">
                </div>
                <div class="col-sm-2 no-padding-left">
                  <select class="form-control select2 no-padding" style="width: 100%;" id="masa_berlaku2" name="masa_berlaku2">
                    <option value="0">Hari</option>
                    <option value="1">Minggu</option>
                    <option value="2" selected>Bulan</option>
                    <option value="3">Tahun</option>
                  </select>
                </div>
              </div>
          </form>
          <div id="note"></div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
        <button id="button-save" type="button" class="btn btn-primary" onclick="document.getElementById('save').submit();">{{ __('Buat Voucher') }}</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="del-data">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="blue bigger">Hapus Kode Voucher</h4>
          </div>
            <div class="modal-body">
                <form role="form" id="delete" action="{{ route('vouchers.delete') }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="hidden" id="delete_id" name="delete_id">
                </form>
                <div>
                    <p>Anda yakin ingin menghapus kode voucher <b><span id="delete_name" class="bolder"></span></b>?</p>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
                <button id="button-delete" type="button" class="btn btn-danger" onclick="$('#delete').submit();">{{ __('Ya, hapus') }}</button>
            </div>
        </div>
    </div>
</div>
@else
  Anda tidak diperkenankan memasuki halaman ini.
@endif
@endsection
@push('scripts')
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
  <script>
    function resetForm(){
      $('#save').trigger("reset");
    }

    function addData(){
      $("#button-save").show();
      $("#modal-title").text("Buat Voucher");
      $("#button-save").text("Buat Voucher");
      resetForm();
    }

    function deleteData(data) {
      $("#delete_id").val(data.id_voucher);
      $("#delete_name").text(data.kode_voucher);
    }

    function copy(text) {
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = text;
        sampleTextarea.select();
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
        alert("Kode Voucher "+text+" berhasil di-copy.");
    }
  </script>
@endpush