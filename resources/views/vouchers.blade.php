@extends('layouts.app')
@section('title', 'Manajemen Voucher Lisensi')
@section('breadcrumb')
  <div class="w-full max-w-7xl">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Aktivasi &amp; Lisensi Siswa</div>
    <h1 class="text-2xl font-black text-slate-900 mt-0.5">Manajemen Voucher Lisensi</h1>
  </div>
@endsection
@section('content')
@if($user->status == 'A')
<div class="col-md-12">
  <div class="w-full max-w-7xl space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
        <div>
          <h2 class="text-lg font-bold text-slate-900">Daftar Kode Voucher Belum Terpakai</h2>
          <p class="text-sm text-slate-500 mt-0.5">Generate kode voucher untuk akses latihan simulasi CBT peserta bimbingan belajar.</p>
        </div>
        <div>
          <button type="button" class="py-3 px-5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-600/20 transition flex items-center gap-2" data-toggle="modal" data-target="#tambah-data" onclick="addData()">
            <i class="fa fa-plus-circle"></i>
            <span>Buat Voucher Baru</span>
          </button>
        </div>
      </div>

      <div class="mt-6 overflow-x-auto">
        <table class="table table-hover table-striped" id="table_voucher" style="width: 100%;">
          <thead>
            <tr>
              <th style="width: 60px; text-align: center;">No</th>
              <th>Kode Voucher</th>
              <th>Masa Berlaku</th>
              <th style="width: 160px; text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
          @if(count($vouchers) > 0)
            @foreach($vouchers as $key => $v)
              <tr>
                <td class="text-center font-bold text-slate-500">{{ $vouchers->firstItem() + $key }}</td>
                <td>
                  <code class="px-2.5 py-1 rounded bg-slate-100 text-indigo-700 font-bold text-sm tracking-wider font-mono">
                    {{ $v->kode_voucher }}
                  </code>
                </td>
                <td>
                  <span class="px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    {{ $v->masa_berlaku }} Hari
                  </span>
                </td>
                <td class="text-center">
                  <button title="Salin Kode Voucher" type="button" class="btn btn-default btn-sm" onclick="copy('{{ $v->kode_voucher }}')">
                    <i class="fa fa-copy text-indigo-600"></i> Salin
                  </button>
                  <button title="Hapus" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#del-data" onclick="deleteData({{ json_encode($vouchers[$loop->iteration-1]) }})">
                    <i class="fa fa-trash"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="4" class="text-center py-8 text-slate-500">Belum ada kode voucher yang tersedia. Silakan klik tombol "Buat Voucher Baru".</td>
            </tr>
          @endif
          </tbody>
        </table>
      </div>

      <div class="mt-4 flex justify-end">
        {{ $vouchers->links("pagination::bootstrap-4") }}
      </div>
    </div>

  </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambah-data">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 16px;">
      <div class="modal-header" style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title font-bold text-slate-900" style="font-size: 18px;">Buat Kode Voucher Baru</h4>
      </div>
      <div class="modal-body" style="padding: 24px;">
        <form role="form" id="save" action="{{ route('vouchers.save') }}" method="post" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="id_voucher" name="id_voucher">

          <div class="form-group" style="margin-bottom: 18px;">
            <label for="kode_voucher" style="font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Kode Voucher</label>
            <div class="input-group">
              <input type="text" class="form-control" id="kode_voucher" name="kode_voucher" max="50" placeholder="Contoh: ABDI-2026-X1" style="height: 46px; border-radius: 8px 0 0 8px; font-family: monospace; font-size: 15px; font-weight: 700;">
              <span class="input-group-btn">
                <button type="button" class="btn btn-default" onclick="generateRandomVoucher()" style="height: 46px; border-radius: 0 8px 8px 0; font-weight: 600;">
                  <i class="fa fa-magic"></i> Acak
                </button>
              </span>
            </div>
            <small class="text-muted">Kode voucher unik untuk dimasukkan siswa saat aktivasi ujian.</small>
          </div>

          <div class="form-group" style="margin-bottom: 18px;">
            <label for="masa_berlaku" style="font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 6px;">Masa Berlaku Voucher</label>
            <div class="row">
              <div class="col-xs-6">
                <input type="number" class="form-control" id="masa_berlaku" name="masa_berlaku" value="1" min="1" style="height: 46px; border-radius: 8px; font-size: 15px; font-weight: 600;">
              </div>
              <div class="col-xs-6">
                <select class="form-control" style="height: 46px; border-radius: 8px; font-size: 14px; font-weight: 600;" id="masa_berlaku2" name="masa_berlaku2">
                  <option value="0">Hari</option>
                  <option value="1">Minggu</option>
                  <option value="2" selected>Bulan</option>
                  <option value="3">Tahun</option>
                </select>
              </div>
            </div>
          </div>
        </form>
        <div id="note"></div>
      </div>
      <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; padding: 8px 16px; font-weight: 600;">Batal</button>
        <button id="button-save" type="button" class="btn btn-primary" onclick="document.getElementById('save').submit();" style="border-radius: 8px; padding: 8px 20px; font-weight: 700; background: #4f46e5; border-color: #4338ca;">
          <i class="fa fa-check"></i> Buat Voucher
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Hapus Data -->
<div class="modal fade" id="del-data">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 16px;">
      <div class="modal-header" style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title font-bold text-slate-900" style="font-size: 18px;">Hapus Kode Voucher</h4>
      </div>
      <div class="modal-body" style="padding: 24px;">
        <form role="form" id="delete" action="{{ route('vouchers.delete') }}" method="post">
          @csrf
          @method('delete')
          <input type="hidden" id="delete_id" name="delete_id">
        </form>
        <p style="font-size: 15px; color: #1e293b;">
          Anda yakin ingin menghapus kode voucher <b><span id="delete_name" style="color: #ef4444; font-family: monospace;"></span></b>?
        </p>
      </div>
      <div class="modal-footer" style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; padding: 8px 16px;">Batal</button>
        <button id="button-delete" type="button" class="btn btn-danger" onclick="document.getElementById('delete').submit();" style="border-radius: 8px; padding: 8px 20px; font-weight: 700;">
          Ya, Hapus
        </button>
      </div>
    </div>
  </div>
</div>
@endif
@endsection

@push('scripts')
<script>
  function addData() {
    $('#save')[0].reset();
    $('#id_voucher').val('');
  }

  function generateRandomVoucher() {
    var chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
    var result = "AP-";
    for (var i = 0; i < 8; i++) {
      result += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    $('#kode_voucher').val(result);
  }

  function copy(text) {
    var input = document.createElement('textarea');
    input.innerHTML = text;
    document.body.appendChild(input);
    input.select();
    var result = document.execCommand('copy');
    document.body.removeChild(input);
    swal("", "Kode voucher " + text + " berhasil disalin ke clipboard!", "success");
  }

  function deleteData(data) {
    $('#delete_id').val(data.id_voucher);
    $('#delete_name').text(data.kode_voucher);
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