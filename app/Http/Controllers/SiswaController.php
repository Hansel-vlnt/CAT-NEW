<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DataTables;
use DB;
use Hash;
use Session;

use App\User;
use App\Models\Soal;
use App\Models\Aktifitas;
use App\Models\Jawab;
use App\Models\Distribusisoal;
use App\Models\Detailsoal;
use App\Models\DetailSoalEssay;
use App\Models\JawabEsay;
use App\Models\PaketLangganan;

class SiswaController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function cekVoucher(){
    $userInfo = User::where('id', Auth::user()->id)->first();
    $result   = true;
    if(!empty($userInfo->voucher)){
      $checkVoucher   = DB::table('vouchers')->where('id_voucher', $userInfo->voucher)->whereNotNull("used_by")->first();
      $expiry         = date('Y-m-d', strtotime(date($checkVoucher->used_date). ' + '.$checkVoucher->masa_berlaku.' days'));
      $now            = date("Y-m-d");
      if($now > $expiry){
        $result = false;
      }
    } else {
      $result = false;
    }

    return $result;
  }

  public function index()
  {
    if (auth()->user()->status == 'G' or auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      $kelas = \App\Models\Kelas::all();
      return view('siswa.index', compact('user', 'kelas'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function editSiswa(Request $request)
  {
    if (auth()->user()->status == 'G' or auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      $siswa = User::where('id', $request->id)->first();
      $kelas = \App\Models\Kelas::all();
      return view('siswa.form.ubah', compact('user', 'siswa', 'kelas'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function dataSiswa()
  {
    $siswas = User::with('getKelas')->where('status', 'S');
    if (auth()->user()->status == 'G') {
      return Datatables::of($siswas)
        ->editColumn('jk', function ($siswas) {
          if ($siswas->jk == 'L') {
            return 'Laki-laki';
          } else {
            return 'Perempuan';
          }
        })
        ->addColumn('kelas', function ($siswas) {
          return $siswas->getKelas ? $siswas->getKelas->nama : '-';
        })
        ->addColumn('status_langganan', function ($siswas) {
          if ($siswas->isLanggananLes()) {
            $exp = $siswas->tgl_berakhir_les ? date('d/m/Y', strtotime($siswas->tgl_berakhir_les)) : 'Aktif';
            return '<center><span class="label label-warning" style="background-color:#f59e0b; color:#fff; font-weight:bold; padding:4px 8px; border-radius:6px;">👑 Siswa Les (' . $exp . ')</span></center>';
          }
          return '<center><span class="label label-default" style="background-color:#94a3b8; color:#fff; font-weight:bold; padding:4px 8px; border-radius:6px;">Reguler / Gratis</span></center>';
        })
        ->addColumn('action', function ($siswas) {
          return '<div style="text-align:center"><a href="' . url('master/siswa/detail/' . $siswas->id) . '" class="btn btn-xs btn-success">Detail</a></div>';
        })
        ->rawColumns(['action', 'status_langganan'])
        ->make(true);
    } elseif (auth()->user()->status == 'A') {
      return Datatables::of($siswas)
        ->editColumn('jk', function ($siswas) {
          if ($siswas->jk == 'L') {
            return 'Laki-laki';
          } else {
            return 'Perempuan';
          }
        })
        ->addColumn('kelas', function ($siswas) {
          return $siswas->getKelas ? $siswas->getKelas->nama : '-';
        })
        ->addColumn('status_langganan', function ($siswas) {
          if ($siswas->isLanggananLes()) {
            $exp = $siswas->tgl_berakhir_les ? date('d/m/Y', strtotime($siswas->tgl_berakhir_les)) : 'Aktif';
            return '<center><span class="label label-warning" style="background-color:#f59e0b; color:#fff; font-weight:bold; padding:4px 8px; border-radius:6px;">👑 Siswa Les (' . $exp . ')</span></center>';
          }
          return '<center><span class="label label-default" style="background-color:#94a3b8; color:#fff; font-weight:bold; padding:4px 8px; border-radius:6px;">Reguler / Gratis</span></center>';
        })
        ->addColumn('action', function ($siswas) {
          return '<div style="text-align:center">
                              <a href="' . url('master/siswa/edit/' . $siswas->id) . '" class="btn btn-xs btn-primary">Ubah</a>
                              <button type="button" class="btn btn-xs btn-danger del-siswa" id="' . $siswas->id . '">Hapus</button>
                              <a href="' . url('master/siswa/detail/' . $siswas->id) . '" class="btn btn-xs btn-success">Detail</a>
                            </div>';
        })
        ->rawColumns(['action', 'status_langganan'])
        ->make(true);
    }
  }

  public function detailSiswa(Request $request)
  {
    if (auth()->user()->status == 'G' or auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      $siswa = User::where('id', $request->id)->first();
      $hasil_ujians = Jawab::join('soals', 'jawabs.id_soal', '=', 'soals.id')
        ->select('soals.paket', 'jawabs.*', DB::raw('SUM(jawabs.score) as jumlah_nilai'))
        ->where('jawabs.id_user', $siswa->id)->where('soals.id_user', auth()->user()->id)
        ->orderBy('jawabs.id', 'DESC')->groupBy('jawabs.id_soal')->paginate(15);
      return view('siswa.detail', compact('user', 'siswa', 'hasil_ujians'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function materi()
  {
    if (auth()->user()->status == 'S') {
      $user = User::where('id', auth()->user()->id)->first();
      $pakets_langganan = PaketLangganan::where('is_aktif', 1)->orderBy('urutan', 'asc')->orderBy('harga', 'asc')->get();
      return view('halaman-siswa.index', compact('user', 'pakets_langganan'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function dataMateri()
  {
    $materis = \App\Models\Materi::where('status', 'Y')->get();
    $user = auth()->user();
    $isLes = $user ? $user->isLanggananLes() : false;

    return Datatables::of($materis)
      ->editColumn('judul', function ($materis) {
        $badge = $materis->isGratis()
          ? '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 mr-2">🟢 Gratis</span>'
          : '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 mr-2">🔒 Khusus Les</span>';
        return '<div class="flex items-center">' . $badge . '<span class="font-bold text-slate-900">' . e($materis->judul) . '</span></div>';
      })
      ->addColumn('action', function ($materis) use ($isLes) {
        if ($materis->isGratis() || $isLes) {
          return '<div style="text-align:center"><a href="' . url('/siswa/materi/detail/' . $materis->id) . '" class="btn btn-primary btn-xs">Baca Materi &rarr;</a></div>';
        }
        return '<div style="text-align:center"><button type="button" onclick="bukaModalVoucher(\'Materi: ' . addslashes($materis->judul) . '\', 0)" class="btn btn-warning btn-xs" style="background-color:#f59e0b; border-color:#d97706; color:#fff;"><i class="fa fa-lock"></i> Khusus Siswa Les</button></div>';
      })
      ->rawColumns(['judul', 'action'])
      ->make(true);
  }

  public function detailMateri(Request $req)
  {
    if (auth()->user()->status == 'S') {
      $user = User::where('id', auth()->user()->id)->first();
      $materi = \App\Models\Materi::where('id', $req->id)->first();
      if (!$materi) {
        Session::flash('error', 'Materi pembelajaran tidak ditemukan!');
        return redirect('/siswa/materi');
      }

      if (!$materi->isGratis() && !$user->isLanggananLes()) {
        Session::flash('error', 'Materi ini khusus untuk siswa bimbingan belajar Abdi Praja. Silakan daftar di website utama https://abdipraja.id/ atau masukkan kode voucher lisensi Anda.');
        return redirect('/siswa/materi');
      }

      $materi->hits = $materi->hits + 1;
      $materi->save();
      return view('halaman-siswa.detail_materi', compact('user', 'materi'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function ujian()
  {
    if (auth()->user()->status == 'S') {
      $user = User::where('id', auth()->user()->id)->first();
      $pakets = Soal::where(function($q) {
          $q->where('tampil', 1)->orWhere(function($sub) {
            $sub->whereNull('tampil');
          });
        })
        ->has('detailSoal')
        ->orderBy('id', 'ASC')
        ->get();
      $pakets_langganan = PaketLangganan::where('is_aktif', 1)->orderBy('urutan', 'asc')->orderBy('harga', 'asc')->get();
      return view('halaman-siswa.ujian', compact('user', 'pakets', 'pakets_langganan'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function detailUjian(Request $req)
  {
    if (auth()->user()->status == 'S') {
      $id         = $req->id;
      $key        = $req->key;
      $soal       = Soal::with('detail_soal_essays')->where('id', $id)->first();
      if (!$soal) {
        Session::flash('error', "Paket latihan soal tidak ditemukan!");
        return redirect('/siswa/ujian');
      }

      $user = auth()->user();
      // Guard: Cek apakah paket draft atau belum memiliki butir soal
      if ($soal->detailSoal()->count() == 0 || $soal->tampil === 0 || $soal->tampil === '0') {
        Session::flash('error', "Paket latihan soal ini masih dalam status DRAFT (sedang disusun) dan belum diterbitkan.");
        return redirect('/siswa/ujian');
      }

      // Guard: Cek apakah paket berbayar dan siswa belum berlangganan les
      if (!$soal->isGratis() && !$user->isLanggananLes()) {
        Session::flash('error', "Paket latihan ini khusus untuk siswa bimbingan belajar Abdi Praja. Silakan daftar di website utama https://abdipraja.id/ atau masukkan kode voucher lisensi Anda.");
        return redirect('/siswa/ujian');
      }

      $soals      = Detailsoal::where('id_soal', $id)->where('status', 'Y')->inRandomOrder()->get();
      $kunciSoal  = !empty($soal->password) ? hash("sha256", $soal->password.Auth::user()->id) : null;

      if($soal->isGratis() || empty($soal->password) || (!empty($key) && $key == $kunciSoal)){
        if($soal->jenis_soal == 0){
          return view('halaman-siswa.detail_ujian', compact('soal', 'soals'));
        } else {
          return view('halaman-siswa.detail_ujian2', compact('soal', 'soals'));
        }
      } else {
        if(!empty($key) && $key != $kunciSoal){
          Session::flash('error', "Password salah! Silahkan hubungi Admin untuk mendapatkan password paket soal ini!");
          return redirect()->back();
        } else {
          return view('halaman-siswa.password_ujian');
        }
      }
    } else {
      return redirect()->route('home.index');
    }
  }

  public function passwordUjian(Request $req, $id = null)
  {
    $id         = $id ?: ($req->id ?: $req->route('id'));
    $password   = $req->password;
    $kunciSoal  = hash("sha256", $password.Auth::user()->id);

    return redirect('/siswa/ujian/detail/'.$id.'/'.$kunciSoal);
  }

  public function getSoal(Request $req)
  {
    $id       = $req->id;
    $id_soal  = $req->id_soal;
    $soal     = Detailsoal::find($id);

    if ($soal) {
      $paket = Soal::find($soal->id_soal);
      if ($paket && !$paket->isGratis() && !auth()->user()->isLanggananLes()) {
        return response("Akses ditolak: Paket soal ini khusus untuk siswa les.", 403);
      }
    }

    return view('halaman-siswa.get_soal', compact('soal'));
  }

  /*public function getSoal(Request $req)
  {
    $id       = $req->id;
    $id_soal  = $req->id_soal;
    $soal     = Detailsoal::find($id);
    $prev     = $soal->select("id")->where([["id", "<", $id],["id_soal", $id_soal]])->orderBy("id", "DESC")->first();
    $next     = $soal->select("id")->where([["id", ">", $id],["id_soal", $id_soal]])->orderBy("id", "ASC")->first();

    return view('halaman-siswa.get_soal', compact('soal', 'prev', 'next'));
  }*/

  public function jawab(Request $request)
  {
    $get_jawab = explode('/', $request->get_jawab);
    $pilihan = $get_jawab[0];
    $id_detail_soal = $get_jawab[1];
    $id_siswa = $get_jawab[2];
    $detail_soal = Detailsoal::find($id_detail_soal);
    if (!$detail_soal) {
      return response("Soal tidak ditemukan", 404);
    }
    $paket = Soal::find($detail_soal->id_soal);
    if ($paket && !$paket->isGratis() && !auth()->user()->isLanggananLes()) {
      return response('Akses ditolak', 403);
    }

    // Bersihkan jawaban lama yang sudah selesai (status = 1) pada paket ini agar sesi baru mulai dari nol
    Jawab::where('id_soal', $detail_soal->id_soal)
      ->where('id_user', auth()->user()->id)
      ->where('status', 1)
      ->delete();

    $jawab = Jawab::where('no_soal_id', $id_detail_soal)
      ->where('id_user', auth()->user()->id)
      ->where('status', 0)
      ->first();
    if (!$jawab) {
      $jawab = new Jawab;
      $jawab->revisi = 0;
    } else {
      $jawab->revisi = $jawab->revisi + 1;
    }

    $jawab->no_soal_id = $id_detail_soal;
    $jawab->id_soal = $detail_soal->id_soal;
    $jawab->id_user = auth()->user()->id;
    $jawab->nama = auth()->user()->nama;
    $jawab->status = 0;

    if ($detail_soal->tipe_soal == 'multi') {
      $current_multi = !empty($jawab->jawaban_multi) ? json_decode($jawab->jawaban_multi, true) : [];
      if (!is_array($current_multi)) {
        $current_multi = !empty($jawab->pilihan) ? explode(',', $jawab->pilihan) : [];
      }
      if (in_array($pilihan, $current_multi)) {
        $current_multi = array_values(array_diff($current_multi, [$pilihan]));
      } else {
        $current_multi[] = $pilihan;
        sort($current_multi);
      }
      $jawab->jawaban_multi = json_encode($current_multi);
      $jawab->pilihan = implode(',', $current_multi);

      $kunci_multi = json_decode($detail_soal->kunci, true);
      if (!is_array($kunci_multi)) {
        $kunci_multi = explode(',', $detail_soal->kunci);
      }
      sort($kunci_multi);
      if ($current_multi == $kunci_multi) {
        $jawab->score = $detail_soal->score;
      } else {
        $jawab->score = 0;
      }
    } elseif ($detail_soal->tipe_soal == 'tkp') {
      $jawab->pilihan = $pilihan;
      $bobot_map = !empty($detail_soal->bobot_opsi) ? json_decode($detail_soal->bobot_opsi, true) : [];
      if (is_array($bobot_map) && isset($bobot_map[$pilihan])) {
        $jawab->score = floatval($bobot_map[$pilihan]);
      } else {
        $default_map = ['A' => 5, 'B' => 4, 'C' => 3, 'D' => 2, 'E' => 1];
        $jawab->score = isset($default_map[$pilihan]) ? $default_map[$pilihan] : 0;
      }
    } else {
      $jawab->pilihan = $pilihan;
      if ($detail_soal->kunci == $pilihan) {
        $jawab->score = $detail_soal->score;
      } else {
        $jawab->score = 0;
      }
    }

    $jawab->save();
    
    return 1;
  }

  public function kirimJawaban(Request $req)
  {
    $paket = Soal::find($req->id_soal);
    if ($paket && !$paket->isGratis() && !auth()->user()->isLanggananLes()) {
      return response('Akses ditolak', 403);
    }

    if($req->autoclose == 1){
      $try_count  = DB::table("jawabs_count")->select("try_count")->where([["id_soal", $req->id_soal], ["id_user", auth()->user()->id]])->first();
      if($try_count){
        $try_count  = $try_count->try_count+0;
        DB::table("jawabs_count")->where([["id_soal", $req->id_soal], ["id_user", auth()->user()->id]])->update(["try_count" => $try_count]);
      } else {
        DB::table('jawabs_count')->insertGetId(["id_soal" => $req->id_soal, "id_user" => auth()->user()->id]);
      }
    } else {
      DB::table('jawabs_count')->insertGetId(["id_soal" => $req->id_soal, "id_user" => auth()->user()->id, "try_count" => 3]);
    }

    if (Jawab::where('id_soal', $req->id_soal)->where('id_user', auth()->user()->id)->where('status', 0)->exists()) {
      Jawab::where('id_soal', $req->id_soal)->where('id_user', auth()->user()->id)->where('status', 1)->delete();
    }

    Jawab::where('id_soal', $req->id_soal)->where('id_user', auth()->user()->id)->update(['status' => 1]);
  }

  public function hapusJawaban(Request $request)
  {
    $resp = Jawab::where([['id_soal', $request->id_soal], ['id_user', auth()->user()->id]])->delete();
    if($resp){
      return 1;
    } else {
      return 0;
    }
  }

  public function finishUjian($id)
  {
    $soal = Soal::find($id);
    if (!$soal) {
      Session::flash('error', "Paket soal tidak ditemukan.");
      return redirect('/siswa/ujian');
    }
    if (!$soal->isGratis() && !auth()->user()->isLanggananLes()) {
      Session::flash('error', "Paket latihan ini khusus untuk siswa bimbingan belajar Abdi Praja. Silakan daftar di website utama https://abdipraja.id/ atau masukkan kode voucher lisensi Anda.");
      return redirect('/siswa/ujian');
    }
    $user_id = auth()->user()->id;
    $nilai = Jawab::where('id_soal', $id)->where('id_user', $user_id)->sum('score');
    $jawabs = Jawab::where('id_soal', $id)->where('id_user', $user_id)->get()->keyBy('no_soal_id');
    $detail_soals = Detailsoal::where('id_soal', $id)->where('status', 'Y')->get();

    $total_soal = $detail_soals->count();
    $benar = 0;
    $salah = 0;
    $kosong = 0;

    foreach ($detail_soals as $ds) {
      if (isset($jawabs[$ds->id]) && !empty($jawabs[$ds->id]->pilihan)) {
        $user_ans = $jawabs[$ds->id]->pilihan;
        if ($ds->tipe_soal == 'multi') {
          $user_arr = array_map('trim', explode(',', $user_ans));
          $kunci_decoded = json_decode($ds->kunci, true);
          $kunci_arr = is_array($kunci_decoded) ? $kunci_decoded : array_map('trim', explode(',', $ds->kunci));
          sort($user_arr);
          sort($kunci_arr);
          if ($user_arr == $kunci_arr) {
            $benar++;
          } else {
            $salah++;
          }
        } elseif ($ds->tipe_soal == 'tkp') {
          $benar++;
        } else {
          if (trim(strtoupper($user_ans)) == trim(strtoupper($ds->kunci))) {
            $benar++;
          } else {
            $salah++;
          }
        }
      } else {
        $kosong++;
      }
    }

    return view('halaman-siswa.finish', compact('soal', 'nilai', 'detail_soals', 'jawabs', 'total_soal', 'benar', 'salah', 'kosong'));
  }

  public function delete()
  {
    return view('siswa.delete');
  }

  public function getBtnDelete($password)
  {
    $validate_admin = User::where('email', auth()->user()->email)->first();
    if ($validate_admin && Hash::check($password, $validate_admin->password)) {
      $cocok = 'Y';
    } else {
      $cocok = 'N';
    }
    return view('siswa.tombol_hapus', compact('cocok'));
  }

  public function deleteAll()
  {
    $users = User::where('status', 'S')->get();
    foreach ($users as $key => $value) {
      $jawab = Jawab::where('id_user', $value->id)->first();
      if ($jawab) {
        $jawab->delete();
      }
    }
    User::where('status', 'S')->delete();
  }

  public function getDetailEssay(Request $request)
  {
    $soal_essay = DetailSoalEssay::with('userJawab')->find($request->id_soal_esay);
    if ($soal_essay) {
      $paket = Soal::find($soal_essay->id_soal);
      if ($paket && !$paket->isGratis() && !auth()->user()->isLanggananLes()) {
        return response('Akses ditolak', 403);
      }
    }
    return view('halaman-siswa.get_soal_essay', compact('soal_essay'));
  }

  public function simpanJawabanEssay(Request $request)
  {
    if ($request->jawab_essay == '' || $request->jawab_essay == null) {
      return '';
    }
    $soal_essay = DetailSoalEssay::find($request->id_soal_esay);
    if ($soal_essay) {
      $paket = Soal::find($soal_essay->id_soal);
      if ($paket && !$paket->isGratis() && !auth()->user()->isLanggananLes()) {
        return response('Akses ditolak', 403);
      }
    }
    $check_jawaban = JawabEsay::where('id_user', auth()->user()->id)->where('id_detail_soal_esay', $request->id_soal_esay)->first();
    if (!$check_jawaban) {
      $save = new JawabEsay;
      $save->id_detail_soal_esay = $request->id_soal_esay;
      $save->id_user = auth()->user()->id;
    } else {
      $save = $check_jawaban;
    }
    $save->jawab = $request->jawab_essay;
    if ($save->save()) {
      return 1;
    }
  }
}
