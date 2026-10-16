@extends('layouts.app')
@section('title', 'Data Siswa - Latihan Soal Abdi Praja')
@section('breadcrumb')
  <div class="max-w-7xl mx-auto py-2">
    <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Master Data &bull; Administrasi</div>
    <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-0.5">Kelola Data Siswa &amp; Peserta</h1>
  </div>
@endsection
@section('content')
<?php include(app_path() . '/functions/myconf.php'); ?>
<div class="col-md-12">
  <div class="max-w-7xl mx-auto space-y-6">

    <!-- HERO HEADER -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-lg">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <span class="px-3 py-1 rounded-full bg-blue-600 text-white text-xs font-bold uppercase tracking-wider">
            Master Data
          </span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">Daftar Akun Siswa</h2>
          <p class="text-slate-300 text-xs sm:text-sm mt-1">
            Kelola data akun siswa, import data via Excel, atau buat akun baru untuk simulasi latihan soal.
          </p>
        </div>
        @if(Auth::user()->status == "A")
        <div class="flex items-center gap-2 flex-wrap">
          <button type="button" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm flex items-center gap-2" id="btn-siswa">
            <i class="fa fa-user-plus"></i> Tambah Siswa
          </button>
          <button type="button" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm flex items-center gap-2" id="btn-upload">
            <i class="fa fa-file-excel-o"></i> Import Excel
          </button>
          <a href="{{ url('/download-file-format/siswa') }}" class="px-3.5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs border border-white/20 transition flex items-center gap-1.5">
            <i class="fa fa-download"></i> Template Excel
          </a>
          <a href="{{ url('master/siswa/delete') }}" class="px-3.5 py-2.5 rounded-xl bg-red-600/80 hover:bg-red-700 text-white font-semibold text-xs transition flex items-center gap-1.5">
            <i class="fa fa-trash"></i> Hapus Semua
          </a>
        </div>
        @endif
      </div>
    </div>

    <!-- CARD FORM TAMBAH SISWA (COLLAPSIBLE) -->
    @if(Auth::user()->status == "A")
    <div style="display: none;" id="wrap-siswa" class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="pb-4 border-b border-slate-100 mb-6 flex items-center justify-between">
        <div>
          <h3 class="text-lg font-bold text-slate-900">Formulir Tambah Siswa Baru</h3>
          <p class="text-xs text-slate-500 mt-0.5">Isi data akun siswa di bawah ini secara lengkap.</p>
        </div>
        <button type="button" id="batal" class="text-slate-400 hover:text-slate-600 text-sm font-bold">✕ Tutup</button>
      </div>

      <form id="form-siswa" class="space-y-4 max-w-2xl">
        <input type="hidden" name="id" value="N">
        <input type="hidden" name="status_sekolah" value="Y">

        <div>
          <label for="nama" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap Siswa</label>
          <input type="text" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" id="nama" name="nama" placeholder="Contoh: Budi Santoso">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
            <input type="email" class="w-full px-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition" id="email" name="email" placeholder="budi@example.com">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Jenis Kelamin</label>
            <div class="flex items-center gap-6 pt-2">
              <label class="flex items-center gap-2 text-sm font-medium text-slate-700 cursor-pointer">
                <input type="radio" name="jk" id="l" value="L" checked class="text-blue-600 focus:ring-blue-500">
                Laki-laki
              </label>
              <label class="flex items-center gap-2 text-sm font-medium text-slate-700 cursor-pointer">
                <input type="radio" name="jk" id="p" value="P" class="text-blue-600 focus:ring-blue-500">
                Perempuan
              </label>
            </div>
          </div>
        </div>

        <div id="notif" style="display: none;" class="p-3.5 rounded-xl text-xs font-semibold"></div>

        <div class="pt-4 flex items-center gap-3">
          <button type="button" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm" id="simpan-siswa">
            Simpan Siswa
          </button>
          <button type="button" class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition" id="batal2" onclick="$('#wrap-siswa').slideUp();">
            Batal
          </button>
        </div>
      </form>
    </div>

    <!-- CARD FORM IMPORT EXCEL (COLLAPSIBLE) -->
    <div style="display: none;" id="wrap-upload-siswa" class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="pb-4 border-b border-slate-100 mb-6 flex items-center justify-between">
        <div>
          <h3 class="text-lg font-bold text-slate-900">Import Data Siswa Massal via Excel</h3>
          <p class="text-xs text-slate-500 mt-0.5">Unggah berkas spreadsheet Excel sesuai format yang disediakan.</p>
        </div>
        <button type="button" id="batal-upload" class="text-slate-400 hover:text-slate-600 text-sm font-bold">✕ Tutup</button>
      </div>

      <form action="{{ url('/crud/simpan-siswa-via-excel') }}" enctype="multipart/form-data" method="POST" id="form-upload-siswa" class="space-y-4 max-w-xl">
        {{ csrf_field() }}
        <div>
          <label for="file" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih File Spreadsheet (.xlsx / .xls)</label>
          <input type="file" name="file" id="file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
          <p class="text-xs text-slate-400 mt-1.5">Pastikan kolom Nama, Email, dan Jenis Kelamin terisi sesuai template resmi.</p>
        </div>

        <div class="pt-4 flex items-center gap-3">
          <input class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm cursor-pointer" name="upload" type="submit" value="Mulai Import Data" />
          <input class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition cursor-pointer" id="batal-upload2" type="button" value="Batal" onclick="$('#wrap-upload-siswa').slideUp();" />
        </div>
      </form>
    </div>
    @endif

    <!-- MAIN TABLE CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
        <div>
          <h3 class="text-lg font-bold text-slate-900">Semua Data Siswa</h3>
          <p class="text-xs text-slate-500 mt-0.5">Gunakan filter pencarian untuk menemukan nama siswa dengan cepat.</p>
        </div>
      </div>

      <div class="table-responsive">
        <table id="tabel_siswa" class="table table-hover table-striped" style="width: 100%;">
          <thead>
            <tr class="text-slate-600 text-xs font-bold uppercase tracking-wider bg-slate-50">
              <th style="padding: 14px 16px;">Nama Lengkap</th>
              <th style="padding: 14px 16px;">NIS / ID</th>
              <th style="padding: 14px 16px;">NISN</th>
              <th style="padding: 14px 16px;">Gender</th>
              <th style="padding: 14px 16px;">Kelas</th>
              <th style="padding: 14px 16px; width: 160px; text-align: center;">Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

  </div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/select2/select2.min.css')}}">
@endpush
@push('scripts')
<script src="{{ url('assets/dist/js/sweetalert2.all.min.js') }}"></script>
<script src="{{URL::asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script>
$(document).ready(function() {
  $('.select2Class').select2();

  tabel_siswa = $('#tabel_siswa').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: true,
    pageLength: 10,
    language: {
      search: "Cari siswa:",
      lengthMenu: "Tampilkan _MENU_ per halaman",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ siswa",
      paginate: {
        first: "Awal",
        last: "Akhir",
        next: "Lanjut",
        previous: "Sebelum"
      }
    },
    ajax: '{{ route("master.data_siswa") }}',
    columns: [
      {
        data: 'nama',
        name: 'nama',
        orderable: true,
        searchable: true,
        render: function(data, type, row) {
          return '<div class="font-bold text-slate-900 text-sm">' + (data || '-') + '</div>' +
                 '<div class="text-xs text-slate-400">' + (row.email || '') + '</div>';
        }
      },
      {
        data: 'no_induk',
        name: 'no_induk',
        orderable: true,
        searchable: true
      },
      {
        data: 'nisn',
        name: 'nisn',
        orderable: true,
        searchable: true
      },
      {
        data: 'jk',
        name: 'jk',
        orderable: false,
        searchable: false
      },
      {
        data: 'kelas',
        name: 'kelas',
        orderable: false,
        searchable: false,
        defaultContent: '-'
      },
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false,
        className: "text-center"
      },
    ],
    "drawCallback": function(setting) {
      $('.del-siswa').on('click', function() {
        var id_siswa = $(this).attr('id');
        var $this = $(this);
        if (confirm('Yakin ingin menghapus data siswa ini?')) {
          $.ajax({
            type: 'POST',
            url: "{{ url('crud/delete-siswa') }}",
            data: {
              id_siswa: id_siswa
            },
            success: function(data) {
              alert('Data siswa berhasil dihapus.');
              $this.closest('tr').hide();
            }
          });
        }
      });
    }
  });

  $("#btn-siswa").click(function() {
    $("#wrap-upload-siswa").hide();
    $("#wrap-siswa").slideToggle();
  });

  $("#batal").click(function() {
    $("#wrap-siswa").slideUp();
  });

  $("#btn-upload").click(function() {
    $("#wrap-siswa").hide();
    $("#wrap-upload-siswa").slideToggle();
  });
  
  $("#batal-upload").click(function() {
    $("#wrap-upload-siswa").slideUp();
  });

  $("#simpan-siswa").click(function() {
    var dataString = $("#form-siswa").serialize();
    $.ajax({
      type: "POST",
      url: "{{ url('/crud/simpan-siswa') }}",
      data: dataString,
      success: function(data) {
        if (data == '1') {
          $("#notif").removeClass('bg-red-50 text-red-700').addClass('bg-emerald-50 text-emerald-800 border border-emerald-200').html("Siswa berhasil ditambahkan.").show();
          setTimeout(function() {
            window.location.reload();
          }, 800);
        } else {
          $("#notif").removeClass('bg-emerald-50 text-emerald-800').addClass('bg-red-50 text-red-700 border border-red-200').html(data).show();
        }
      }
    });
  });
});
</script>
@endpush