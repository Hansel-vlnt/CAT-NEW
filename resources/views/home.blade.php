<?php use Carbon\Carbon; ?>
@extends('layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb')
  <div class="w-full max-w-7xl flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Dashboard Utama</h1>
      <p class="text-sm text-slate-500 mt-0.5">Ringkasan aktivitas, statistik soal, dan akses simulasi CBT.</p>
    </div>
    <div class="hidden sm:flex items-center gap-2 text-xs font-semibold text-slate-500 bg-white px-3.5 py-2 rounded-xl border border-slate-200 shadow-sm">
      <i class="fa fa-calendar text-indigo-600"></i>
      <span>{{ Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
    </div>
  </div>
@endsection

@section('content')
  <?php include(app_path().'/functions/myconf.php'); ?>
  <div class="col-xs-12">
    <div class="w-full max-w-7xl space-y-6">

      <!-- Hero Sambutan Modern -->
      <div class="relative overflow-hidden rounded-2xl bg-slate-900 text-white p-6 sm:p-8 shadow-sm border border-slate-800">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div class="space-y-2 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-400/30 text-xs font-bold tracking-wide uppercase">
              <i class="fa fa-graduation-cap"></i>
              <span>Latihan Soal Abdi Praja</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
              Selamat Datang, {{ Auth::user()->nama }}!
            </h2>
            <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
              Portal simulasi ujian dan evaluasi belajar terpadu. Persiapkan diri menghadapi Seleksi Kompetensi Dasar (SKD) Kedinasan, CPNS, serta UTBK-SNBT dengan bank soal berstandar nasional dan pembahasan komprehensif.
            </p>
          </div>
          <div class="flex flex-col sm:flex-row md:flex-col gap-2.5 shrink-0">
            @if(Auth::user()->status == 'S')
              <a href="{{ url('/siswa/ujian') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-600/30 transition">
                <i class="fa fa-play-circle text-base"></i>
                <span>Mulai Simulasi Ujian</span>
              </a>
              <a href="{{ url('/pengaturan') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs border border-slate-700 transition">
                <i class="fa fa-user"></i>
                <span>Profil Akun</span>
              </a>
            @else
              <a href="{{ url('/elearning/soal') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-600/30 transition">
                <i class="fa fa-plus-circle text-base"></i>
                <span>Kelola Paket Soal</span>
              </a>
              <a href="{{ url('/elearning/laporan') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs border border-slate-700 transition">
                <i class="fa fa-bar-chart"></i>
                <span>Lihat Laporan Siswa</span>
              </a>
            @endif
          </div>
        </div>
      </div>

      <!-- Grid Statistik 4 Box Seimbang -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Siswa -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
          <div class="w-14 h-14 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-2xl shrink-0">
            <i class="fa fa-users"></i>
          </div>
          <div class="min-w-0 flex-1">
            <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Jumlah Siswa</div>
            <div class="text-3xl font-black text-slate-900 mt-0.5">{{ number_format($siswas) }} <span class="text-sm font-semibold text-slate-500">siswa</span></div>
            <div class="text-sm text-slate-500 mt-0.5">Peserta terdaftar aktif</div>
          </div>
        </div>

        <!-- Card 2: Paket Soal -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
          <div class="w-14 h-14 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-2xl shrink-0">
            <i class="fa fa-book"></i>
          </div>
          <div class="min-w-0 flex-1">
            <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Paket Soal</div>
            <div class="text-3xl font-black text-slate-900 mt-0.5">{{ number_format($pakets) }} <span class="text-sm font-semibold text-slate-500">paket</span></div>
            <div class="text-sm text-slate-500 mt-0.5">SKD &amp; UTBK-SNBT</div>
          </div>
        </div>

        <!-- Card 3: Butir Soal -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
          <div class="w-14 h-14 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center text-2xl shrink-0">
            <i class="fa fa-check-square-o"></i>
          </div>
          <div class="min-w-0 flex-1">
            <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Butir Soal</div>
            <div class="text-3xl font-black text-slate-900 mt-0.5">{{ number_format($soals) }} <span class="text-sm font-semibold text-slate-500">butir</span></div>
            <div class="text-sm text-slate-500 mt-0.5">Trik cepat &amp; konsep</div>
          </div>
        </div>

        <!-- Card 4: Status Voucher -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
          <div class="w-14 h-14 rounded-xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center text-2xl shrink-0">
            <i class="fa fa-id-card"></i>
          </div>
          <div class="min-w-0 flex-1">
            <div class="text-sm font-bold text-slate-500 uppercase tracking-wider">Status Lisensi</div>
            @if(Auth::user()->status == 'A' || Auth::user()->status == 'G')
              <div class="text-xl font-black text-slate-900 mt-0.5">Akses Penuh</div>
              <div class="text-sm text-emerald-600 font-bold mt-0.5">Admin / Guru</div>
            @else
              @if(!empty($voucher["expiry_date"]))
                <div class="text-lg font-black text-slate-900 mt-0.5">{{ date("d-m-Y", strtotime($voucher["expiry_date"])) }}</div>
                <div class="text-sm {{ $voucher['status'] == 1 ? 'text-emerald-600 font-bold' : 'text-red-500 font-bold' }} mt-0.5">
                  {{ $voucher['status'] == 1 ? 'Lisensi Aktif' : 'Lisensi Berakhir' }}
                </div>
              @else
                <div class="text-lg font-black text-amber-700 mt-0.5">Belum Aktif</div>
                <div class="text-sm text-slate-500 mt-0.5">Aktivasi voucher</div>
              @endif
            @endif
          </div>
        </div>
      </div>

      <!-- Card Akses Cepat (3 Grand Action Cards) -->
      <div>
        <div class="mb-4">
          <h3 class="text-xl font-bold text-slate-900">Akses Cepat Pembelajaran &amp; Ujian</h3>
          <p class="text-base text-slate-500">Pilih modul simulasi untuk mulai menguji pemahaman dan kecepatan berpikir Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <!-- Card 1: SKD Kedinasan -->
          <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:border-indigo-300 hover:shadow-md transition">
            <div class="space-y-3">
              <div class="flex items-center justify-between">
                <span class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center text-xl">
                  <i class="fa fa-shield"></i>
                </span>
                <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold uppercase tracking-wider">SKD CAT</span>
              </div>
              <h4 class="text-xl font-bold text-slate-900">Mulai Latihan SKD Kedinasan</h4>
              <p class="text-base text-slate-600 leading-relaxed">
                Latihan soal TWK, TIU, dan TKP sesuai kisi-kisi resmi BKN untuk seleksi IPDN, STAN, Poltekip, Poltekim, STIS, dan Sekolah Kedinasan.
              </p>
            </div>
            <div class="pt-5 mt-4 border-t border-slate-100">
              @if(Auth::user()->status == 'S')
                <a href="{{ url('/siswa/ujian') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base transition shadow-sm">
                  <span>Mulai Latihan SKD</span>
                  <i class="fa fa-arrow-right text-sm"></i>
                </a>
              @else
                <a href="{{ url('/elearning/soal') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base transition shadow-sm">
                  <span>Kelola Soal SKD</span>
                  <i class="fa fa-arrow-right text-sm"></i>
                </a>
              @endif
            </div>
          </div>

          <!-- Card 2: UTBK-SNBT -->
          <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:border-emerald-300 hover:shadow-md transition">
            <div class="space-y-3">
              <div class="flex items-center justify-between">
                <span class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
                  <i class="fa fa-graduation-cap"></i>
                </span>
                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider">UTBK SNBT</span>
              </div>
              <h4 class="text-xl font-bold text-slate-900">Mulai Latihan UTBK-SNBT</h4>
              <p class="text-base text-slate-600 leading-relaxed">
                Simulasi Tes Potensi Skolastik (TPS), Literasi Bahasa Indonesia, Literasi Bahasa Inggris, serta Penalaran Matematika mutakhir.
              </p>
            </div>
            <div class="pt-5 mt-4 border-t border-slate-100">
              @if(Auth::user()->status == 'S')
                <a href="{{ url('/siswa/ujian') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base transition shadow-sm">
                  <span>Mulai Latihan UTBK</span>
                  <i class="fa fa-arrow-right text-sm"></i>
                </a>
              @else
                <a href="{{ url('/elearning/soal') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base transition shadow-sm">
                  <span>Kelola Soal UTBK</span>
                  <i class="fa fa-arrow-right text-sm"></i>
                </a>
              @endif
            </div>
          </div>

          <!-- Card 3: Rapor Nilai -->
          <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between hover:border-blue-300 hover:shadow-md transition">
            <div class="space-y-3">
              <div class="flex items-center justify-between">
                <span class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center text-xl">
                  <i class="fa fa-line-chart"></i>
                </span>
                <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold uppercase tracking-wider">Evaluasi</span>
              </div>
              <h4 class="text-xl font-bold text-slate-900">Lihat Rapor Nilai</h4>
              <p class="text-base text-slate-600 leading-relaxed">
                Evaluasi capaian skor per materi ujian, rincian jawaban benar/salah, serta tinjauan trik praktis dan solusi konseptual.
              </p>
            </div>
            <div class="pt-5 mt-4 border-t border-slate-100">
              @if(Auth::user()->status == 'S')
                <a href="{{ url('/siswa/ujian') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-base transition shadow-sm">
                  <span>Lihat Riwayat &amp; Rapor</span>
                  <i class="fa fa-arrow-right text-sm"></i>
                </a>
              @else
                <a href="{{ url('/elearning/laporan') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-base transition shadow-sm">
                  <span>Rekapitulasi Nilai Siswa</span>
                  <i class="fa fa-arrow-right text-sm"></i>
                </a>
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Aktivasi Voucher Box (Jika Siswa Belum Aktif / Habis Masa Aktif) -->
      @if(Auth::user()->status == 'S' && $voucher["status"] == 0)
        <div id="cekVoucher" class="bg-amber-50 rounded-2xl p-6 sm:p-7 border border-amber-200 shadow-sm">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
              <div class="flex items-center gap-2 text-amber-900 font-bold text-base">
                <i class="fa fa-key text-amber-600"></i>
                <span>Aktivasi Kode Voucher Ujian</span>
              </div>
              <p class="text-sm text-amber-800">
                {{ $voucher["message"] ?: 'Masukkan kode voucher yang Anda miliki untuk membuka seluruh paket latihan soal CBT.' }}
              </p>
            </div>
            <form method="post" id="voucher" action="{{ route('aktivasi') }}" class="flex flex-col sm:flex-row items-center gap-2.5 w-full md:w-auto">
              {{ csrf_field() }}
              <input type="text" class="form-control" name="kode_voucher" id="kode_voucher" placeholder="Masukkan Kode Voucher" required style="height: 48px !important; font-size: 15px !important; min-width: 240px;">
              <button type="submit" class="btn btn-primary whitespace-nowrap" id="aktivasi" style="height: 48px !important; padding: 0 24px !important;">
                <i class="fa fa-unlock-alt mr-1"></i> Aktivasi Sekarang
              </button>
            </form>
          </div>
        </div>
      @endif

      <!-- Admin / Guru: Daftar Paket Soal Terkini Datatable -->
      @if(Auth::user()->status == 'A' || Auth::user()->status == 'G')
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
          <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <div>
              <h3 class="text-base font-bold text-slate-900">Daftar Paket Soal Tersedia</h3>
              <p class="text-xs text-slate-500 mt-0.5">Pemantauan data paket soal aktif dalam sistem CBT</p>
            </div>
            <a href="{{ url('/elearning/soal') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
              <span>Kelola Seluruh Soal</span>
              <i class="fa fa-angle-right"></i>
            </a>
          </div>

          <div class="table-responsive">
            <table class="table table-hover table-striped" id="table_soal" style="width: 100%;">
              <thead>
                <tr class="bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider">
                  <th style="width: 30%;">Paket Soal</th>
                  <th style="width: 35%;">Deskripsi</th>
                  <th style="width: 15%;">Waktu</th>
                  <th style="width: 20%; text-align: center;">Aksi</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      @endif

    </div>
  </div>
@endsection

@push('css')
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/Responsive/css/responsive.dataTables.css')}}">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/css/fixedHeader.bootstrap.css')}}">
@endpush

@push('scripts')
  <script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
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
  @if(Session::has('status'))
  <script>
      swal("", '{!! Session::get("status") !!}', "success");
  </script>
  @endif
  <script>
  $(document).ready(function (){
    @if(Auth::user()->status == 'A' || Auth::user()->status == 'G')
    table_soal = $('#table_soal').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      lengthChange: true,
      ajax: {
        url: '{!! route('elearning.get-soal-home') !!}',
      },
      columns: [
        {data: 'paket', name: 'paket', orderable: true, searchable: true },
        {data: 'deskripsi', name: 'deskripsi', orderable: true, searchable: true },
        {data: 'waktu', name: 'waktu', orderable: true, searchable: true },
        {data: 'action', name: 'action', orderable: false, searchable: false, },
      ],
      "drawCallback": function (setting) {}
    });
    @endif
    $("#btn-wrap-info").click(function() {
      $(this).hide();
      $("#wrap-info").show();
    });
  });
  </script>
@endpush