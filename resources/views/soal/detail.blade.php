@extends('layouts.app')
@section('title', 'Detail Paket Soal: ' . $soal->paket)
@section('breadcrumb')
  <div class="w-full flex flex-col sm:flex-row sm:items-center justify-between gap-3 py-1">
    <div>
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
<?php
  include(app_path() . '/functions/myconf.php');
  $isPublished = ($soal->tampil == 1 || ($soal->tampil === null && $soals->count() > 0));
?>
<div class="col-md-12">
  <div class="max-w-6xl mx-auto space-y-6">

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
          @if($isPublished)
            <button type="button" id="btn-toggle-publish" onclick="togglePublishDetail({{ $soal->id }})" class="px-4 py-2.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 text-xs font-bold transition flex items-center gap-2 shadow-sm cursor-pointer" title="Paket sedang aktif terbit di katalog siswa. Klik untuk ubah ke Draft.">
              <i class="fa fa-check-circle text-emerald-600"></i>
              <span>Sedang Terbit (Draftkan)</span>
            </button>
          @else
            <button type="button" id="btn-toggle-publish" onclick="togglePublishDetail({{ $soal->id }})" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition flex items-center gap-2 shadow-sm cursor-pointer" title="Klik untuk menerbitkan paket ke katalog siswa">
              <i class="fa fa-paper-plane"></i>
              <span>Terbitkan Paket ke Siswa</span>
            </button>
          @endif
          <button type="button" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center gap-2 shadow-sm cursor-pointer" data-toggle="modal" data-target="#modal-import-soal">
            <i class="fa fa-file-excel-o"></i> Import Excel
          </button>
          <button type="button" id="btn-soal" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition flex items-center gap-2 shadow-sm cursor-pointer">
            <i class="fa fa-plus"></i> Tambah Butir Soal
          </button>
        </div>
      </div>

      <!-- Quick Specs Pills Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-5 gap-3.5 mt-6 pt-6 border-t border-slate-100">
        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60">
          <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Durasi</div>
          <div class="text-lg font-bold text-slate-900 mt-0.5">{{ round($soal->waktu / 60) }} Menit</div>
          <div class="text-xs text-slate-400">Total: {{ number_format($soal->waktu, 0, ',', '.') }}s</div>
        </div>

        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60">
          <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">KKM</div>
          <div class="text-lg font-bold text-emerald-600 mt-0.5">{{ $soal->kkm ?? 70 }} Poin</div>
          <div class="text-xs text-slate-400">Standar kelulusan</div>
        </div>

        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60">
          <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Mode CBT</div>
          <div class="text-lg font-bold text-slate-900 mt-0.5">{{ $soal->jenis_soal == 0 ? 'Total Paket' : 'Per Nomor' }}</div>
          <div class="text-xs text-slate-400">Hitung mundur</div>
        </div>

        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60">
          <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Token Akses</div>
          <div class="text-lg font-mono font-bold text-slate-900 mt-0.5">{{ $soal->password ?: 'Bebas' }}</div>
          <div class="text-xs text-slate-400">{{ $soal->password ? 'Wajib token' : 'Tanpa token' }}</div>
        </div>

        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60 col-span-2 sm:col-span-1">
          <div class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Status Siswa</div>
          <div class="text-sm font-bold mt-1">
            @if($isPublished)
              <span class="text-emerald-700 flex items-center gap-1"><i class="fa fa-check-circle text-emerald-600"></i> Terbit</span>
            @else
              <span class="text-amber-700 flex items-center gap-1"><i class="fa fa-clock-o text-amber-600"></i> Draft</span>
            @endif
          </div>
          <div class="text-[11px] text-slate-400 mt-0.5">{{ $isPublished ? 'Tampil di katalog' : 'Belum tampil' }}</div>
        </div>
      </div>
    </div>

    <!-- Banner Onboarding Paket Baru -->
    @if(request()->has('baru'))
    <div class="bg-indigo-50 border border-indigo-200 rounded-2xl p-4 sm:p-5 flex items-start gap-3.5 text-indigo-900 shadow-sm" id="welcome-new-banner">
      <div class="w-10 h-10 rounded-xl bg-indigo-100 border border-indigo-300 flex items-center justify-center shrink-0 text-indigo-700 font-bold text-lg">
        <i class="fa fa-check"></i>
      </div>
      <div>
        <div class="font-bold text-sm text-indigo-950">
          Paket Soal Baru Berhasil Dibuat! Langkah Selanjutnya: Tulis Butir Soal
        </div>
        <p class="text-xs text-indigo-800 mt-0.5 leading-relaxed">
          Formulir penulisan butir soal telah dibuka otomatis di bawah. Anda juga dapat menggunakan opsi <b>"Import Excel"</b> jika sudah memiliki berkas bank soal. Setelah selesai menambahkan soal, klik tombol <b>"Terbitkan Paket ke Siswa"</b> di atas.
        </p>
      </div>
    </div>
    @endif

    <!-- Banner Draft Guidance -->
    @if(!$isPublished)
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-amber-900 shadow-sm" id="draft-banner">
      <div class="flex items-start sm:items-center gap-3.5">
        <div class="w-10 h-10 rounded-xl bg-amber-100 border border-amber-300 flex items-center justify-center shrink-0 text-amber-700 font-bold text-lg">
          <i class="fa fa-clock-o"></i>
        </div>
        <div>
          <div class="font-bold text-sm text-amber-950 flex items-center gap-2">
            <span>Status Paket: DRAFT (Belum Terbit ke Siswa)</span>
            <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-amber-200/80 text-amber-900 uppercase tracking-wider">Mode Penyusunan</span>
          </div>
          <p class="text-xs text-amber-800 mt-0.5 max-w-2xl leading-relaxed">
            Paket ini tersimpan aman sebagai draft dan belum dapat dilihat oleh siswa di katalog. Tambahkan butir soal di bawah (minimal 1 soal), lalu klik <b>"Terbitkan Sekarang"</b> agar dapat dikerjakan siswa.
          </p>
        </div>
      </div>
      <div class="shrink-0 flex items-center gap-2">
        <button type="button" onclick="togglePublishDetail({{ $soal->id }})" class="px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm cursor-pointer">
          <i class="fa fa-paper-plane"></i> Terbitkan Sekarang
        </button>
      </div>
    </div>
    @endif

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
<div class="modal fade" id="modal-import-soal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
      <div class="modal-header" style="padding: 20px 24px; background: #0f172a; color: white;">
        <button type="button" class="close text-white opacity-80 hover:opacity-100" data-dismiss="modal" style="margin-top: -2px; font-size: 24px;">&times;</button>
        <h4 class="modal-title font-bold text-white text-base flex items-center gap-2.5">
          <span class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-sm border border-emerald-500/30">
            <i class="fa fa-file-excel-o"></i>
          </span>
          <span>Import Butir Soal via Excel</span>
        </h4>
      </div>
      <form action="{{ url('/crud/simpan-detail-soal-via-excel') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf
        <input type="hidden" name="id_soal" value="{{ $soal->id }}">

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Berkas Excel (.xlsx / .xls) *</label>
          <input type="file" name="file" required accept=".xlsx,.xls" class="block w-full text-sm text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 border border-slate-200 rounded-xl p-2 cursor-pointer bg-slate-50/50 transition">
          <p class="text-[11px] text-slate-400 mt-1.5">Mendukung berkas format spreadsheet Microsoft Excel (.xlsx dan .xls).</p>
        </div>

        <!-- Template Download Box: Elegant, High Contrast & Clear Button -->
        <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3.5">
          <div class="flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base font-bold border border-emerald-200 mt-0.5">
              <i class="fa fa-file-excel-o"></i>
            </div>
            <div>
              <div class="text-sm font-bold text-slate-900" style="font-size: 14px;">Format Kolom Soal Wajib Sesuai Template</div>
              <p class="text-xs text-slate-500 mt-1 leading-relaxed" style="font-size: 12.5px;">
                Susunan kolom harus mengikuti template resmi (Kolom Soal, Pilihan A-E, Kunci Jawaban, dan Bobot Skor) agar proses impor berjalan lancar tanpa kendala.
              </p>
            </div>
          </div>
          <div class="pt-1">
            <a href="{{ url('/download-file-format/soal') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition shadow-sm" style="font-size: 13px; color: #ffffff !important;">
              <i class="fa fa-download text-sm" style="color: #ffffff !important;"></i>
              <span style="color: #ffffff !important;">Unduh Format Template Excel (.xlsx)</span>
            </a>
          </div>
        </div>

        <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
          <button type="button" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition cursor-pointer" data-dismiss="modal">Batal</button>
          <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-md flex items-center gap-2 cursor-pointer">
            <i class="fa fa-upload"></i>
            <span>Unggah &amp; Import</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Hapus Soal -->
<div class="modal fade" id="del-soal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
      <div class="modal-header" style="padding: 18px 22px; background: #ef4444; color: white;">
        <button type="button" class="close text-white opacity-80 hover:opacity-100" data-dismiss="modal" style="margin-top: -2px; font-size: 22px;">&times;</button>
        <h4 class="modal-title font-bold text-white text-base flex items-center gap-2">
          <i class="fa fa-trash-o"></i> Hapus Butir Soal
        </h4>
      </div>
      <div class="p-6 space-y-4">
        <form role="form" id="delete" action="{{ route('soal.hapus') }}" method="post">
          @csrf
          @method('delete')
          <input type="hidden" id="id_soal" name="id_soal">
        </form>
        <p class="text-sm text-slate-600 leading-relaxed">
          Apakah Anda yakin ingin menghapus butir soal ini? Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
        </p>
        <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2.5">
          <button type="button" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition cursor-pointer" data-dismiss="modal">Batal</button>
          <button id="button-delete" type="button" class="px-5 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs uppercase tracking-wider transition shadow-sm cursor-pointer" onclick="$('#delete').submit();">Ya, Hapus</button>
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
<link rel="stylesheet" href="{{URL::asset('assets/plugins/summernote/summernote.css')}}?v={{ time() }}">
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

  /* Summernote Dropdown Bulletproof Styling */
  .note-editor .dropdown-menu {
    background-color: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.08) !important;
    padding: 6px 0 !important;
    z-index: 1050 !important;
    min-width: 120px !important;
  }
  .note-editor .dropdown-menu.note-check {
    max-height: 260px !important;
    overflow-y: auto !important;
  }
  .note-editor .dropdown-menu.note-check li {
    display: block !important;
    margin: 0 !important;
    padding: 0 !important;
  }
  .note-editor .dropdown-menu.note-check li a {
    display: flex !important;
    align-items: center !important;
    padding: 7px 14px !important;
    color: #1e293b !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    text-decoration: none !important;
    line-height: 1.4 !important;
    visibility: visible !important;
    opacity: 1 !important;
    cursor: pointer !important;
  }
  .note-editor .dropdown-menu.note-check li a:hover,
  .note-editor .dropdown-menu.note-check li a:focus {
    background-color: #f1f5f9 !important;
    color: #4f46e5 !important;
  }
  .note-editor .dropdown-menu.note-check li a.checked {
    font-weight: 700 !important;
    color: #4f46e5 !important;
    background-color: #eef2ff !important;
  }
  .note-editor .dropdown-menu.note-check li a i.note-icon-check {
    display: inline-block !important;
    width: 16px !important;
    margin-right: 8px !important;
    font-family: FontAwesome !important;
    font-style: normal !important;
    color: transparent !important;
    visibility: visible !important;
  }
  .note-editor .dropdown-menu.note-check li a.checked i.note-icon-check {
    color: #4f46e5 !important;
  }
  .note-editor .dropdown-menu.note-check li a.checked i.note-icon-check:before {
    content: "\f00c" !important;
  }
</style>
@endpush

@push('scripts')
<script src="{{URL::asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.js')}}"></script>
<script src="{{URL::asset('assets/plugins/summernote/summernote.min.js')}}?v={{ time() }}"></script>
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

function togglePublishDetail(id) {
  $.ajax({
    url: "{{ url('/elearning/soal/toggle-publish') }}/" + id,
    type: "POST",
    data: {
      _token: "{{ csrf_token() }}"
    },
    success: function(res) {
      if (res.success) {
        swal({
          title: "Berhasil!",
          text: res.message,
          type: "success",
          confirmButtonColor: "#4f46e5",
          confirmButtonText: "Sip, Mengerti"
        }, function() {
          window.location.reload();
        });
      }
    },
    error: function(xhr) {
      var msg = "Gagal mengubah status publikasi.";
      if (xhr.responseJSON && xhr.responseJSON.message) {
        msg = xhr.responseJSON.message;
      }
      swal({
        title: "Perhatian",
        text: msg,
        type: "warning",
        confirmButtonColor: "#4f46e5",
        confirmButtonText: "Mengerti"
      });
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

  @if(request()->has('baru') || $soals->count() == 0)
    $("#wrap-soal").show();
    setTimeout(function() {
      if ($("#wrap-soal").length) {
        $('html, body').animate({
          scrollTop: $("#wrap-soal").offset().top - 80
        }, 400);
      }
    }, 250);
  @endif

  // DOM Rehydrator on font and size dropdown clicks
  $(document).on('click', '.note-fontname .dropdown-toggle, .note-fontsize .dropdown-toggle', function() {
    var $menu = $(this).closest('.btn-group').find('.dropdown-menu');
    setTimeout(function() {
      $menu.find('li a').each(function() {
        var val = $(this).attr('data-value');
        if ($(this).find('span').length) {
          $(this).find('span').css({
            'color': '#1e293b',
            'visibility': 'visible',
            'display': 'inline-block'
          });
        } else if (val) {
          var textNode = $(this).contents().filter(function() { return this.nodeType === 3; }).first();
          if (textNode.length) {
            textNode.replaceWith('<span class="dropdown-item-label" style="display:inline-block; color:#1e293b; font-weight:600; font-size:13px;">' + val + '</span>');
          }
        }
      });
    }, 10);
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
    fontNames: ['Plus Jakarta Sans', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana'],
    fontNamesIgnoreCheck: ['Plus Jakarta Sans', 'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana'],
    fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '18', '20', '24', '28', '36', '48', '64', '82', '150'],
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