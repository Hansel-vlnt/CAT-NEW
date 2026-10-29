<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Auth;
// use Datatables;
use DB;
// use Input;
use Spreadsheet_Excel_Reader;
use Excel;

use App\User;
use App\Models\Soal;
use App\Models\Detailsoal;
use App\Models\Aktifitas;
use Illuminate\Support\Facades\Auth;
use Input;
use DataTables;

class SoalController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    if (Auth::user()->status == 'G' or Auth::user()->status == 'A') {
      $user = User::where('id', Auth::user()->id)->first();
      if (Auth::user()->status == 'G') {
        $soals = Soal::where('id_user', Auth::user()->id)->paginate(5);
      } elseif (Auth::user()->status == 'A') {
        $soals = Soal::orderBy('id', 'DESC')->paginate(5);
      }

      foreach($soals as $s){
        if($s->jenis_soal == 0){
          $s->jenis = "Normal";
        } else {
          $s->jenis = "Cerdas Cermat";
        }
      }

      return view('soal.index', compact('user', 'soals'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function deleteSoal(Request $req){
    $soal  = DetailSoal::where('id', $req->id_soal)->first();

    if($soal){
      $del       = DB::table('detailsoals')->where("id", $req->id_soal)->delete();
      $del2       = DB::table('jawabs')->where("no_soal_id", $req->id_soal)->delete();

      if ($del || $del2) {
          $req->session()->flash('success', "Soal berhasil dihapus!");
      } else {
          $req->session()->flash('error', "Soal gagal dihapus!");
      }
    } else {
      $req->session()->flash('error', "Soal gagal dihapus!");
    }

    return redirect()->back();
  }

  public function deletePaketSoal(Request $req){
    $paketSoal  = Soal::where('id', $req->id_soal)->first();

    if($paketSoal){
      $paketSoal  = $paketSoal->paket;
      $del        = DB::table('soals')->where("id", $req->id_soal)->delete();
      $del2       = DB::table('detailsoals')->where("id_soal", $req->id_soal)->delete();
      $del3       = DB::table('jawabs')->where("id_soal", $req->id_soal)->delete();

      if ($del || $del2 || $del3) {
          $req->session()->flash('success', "Paket soal ".$paketSoal." berhasil dihapus!");
      } else {
          $req->session()->flash('error', "Paket soal ".$paketSoal." gagal dihapus!");
      }
    } else {
      $req->session()->flash('error', "Paket soal gagal dihapus!");
    }

    return redirect()->back();
  }

  public function dataSoal()
  {
    if (Auth::user()->status == 'G') {
      $soals = Soal::where('id_user', Auth::user()->id)->get();
    } else {
      $soals = Soal::get();
    }

    foreach($soals as $s){
      $waktu = $s->waktu / 60;
      if($waktu >= 1){
        $s->waktu = $waktu." Menit";
      } else {
        $s->waktu = $s->waktu." Detik";
      }
      if($s->jenis_soal == 0){
        $s->jenis = "Normal";
      } else {
        $s->jenis = "Cerdas Cermat";
      }
    }
    
    return Datatables::of($soals)
      ->editColumn('waktu', function ($soals) {
        return $soals->waktu;
      })
      ->editColumn('jenis', function ($soals) {
        return $soals->jenis;
      })
      ->addColumn('jumlah_soal', function ($soals) {
        $count = $soals->detailSoal()->count();
        if ($count > 0) {
          return '<center><span class="label label-info" style="background-color:#e0e7ff; color:#3730a3; font-weight:700; padding:4px 8px; border-radius:6px; border:1px solid #c7d2fe;">' . $count . ' Butir</span></center>';
        }
        return '<center><span class="label label-default" style="background-color:#f1f5f9; color:#64748b; font-weight:700; padding:4px 8px; border-radius:6px; border:1px solid #cbd5e1;">0 Butir (Kosong)</span></center>';
      })
      ->editColumn('tipe_akses', function ($soals) {
        if ($soals->tipe_akses == 'berbayar') {
          return '<center><span class="label label-warning" style="background-color:#f59e0b; color:#fff; font-weight:bold; padding:4px 8px; border-radius:6px;">Khusus Les</span></center>';
        }
        return '<center><span class="label label-success" style="background-color:#10b981; color:#fff; font-weight:bold; padding:4px 8px; border-radius:6px;">Gratis</span></center>';
      })
      ->addColumn('status_terbit', function ($soals) {
        $count = $soals->detailSoal()->count();
        $isPub = $soals->tampil == 1 || ($soals->tampil === null && $count > 0);
        if ($isPub) {
          return '<center><button type="button" onclick="togglePublish('.$soals->id.')" class="btn btn-xs cursor-pointer" style="background-color:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; font-weight:700; border-radius:6px; padding:3px 8px;" title="Klik untuk ubah ke Draft"><i class="fa fa-check-circle text-emerald-600"></i> Terbit</button></center>';
        }
        return '<center><button type="button" onclick="togglePublish('.$soals->id.')" class="btn btn-xs cursor-pointer" style="background-color:#fef3c7; color:#92400e; border:1px solid #fde68a; font-weight:700; border-radius:6px; padding:3px 8px;" title="Klik untuk terbitkan paket"><i class="fa fa-clock-o text-amber-600"></i> Draft</button></center>';
      })
      ->addColumn('action', function ($soals) {
        return '<div style="text-align:center; display:flex; align-items:center; justify-content:center; gap:4px; flex-wrap:wrap;">'
          . '<a href="soal/detail/' . $soals->id . '" class="btn btn-primary btn-xs font-bold" title="Kelola Butir Soal"><i class="fa fa-tasks"></i> Isi Soal</a> '
          . '<a href="soal/ubah/' . $soals->id . '" class="btn btn-default btn-xs font-bold" title="Ubah Info Paket"><i class="fa fa-pencil text-blue-600"></i></a> '
          . '<button type="button" class="btn btn-danger btn-xs" title="Hapus Paket" data-toggle="modal" data-target="#del-soal" onclick="deleteSoal('.$soals->id.',\''.addslashes($soals->paket).'\')"><i class="fa fa-trash"></i></button>'
          . '</div>';
      })
      ->rawColumns(['tipe_akses', 'jumlah_soal', 'status_terbit', 'action'])->make(true);
  }
  public function dataSoalHome()
  {
    if (Auth::user()->status == 'G') {
      $soals = Soal::where('id_user', Auth::user()->id)->get();
    } else {
      $soals = Soal::get();
    }
    return DataTables::of($soals)
      ->editColumn('waktu', function ($soals) {
        return '<center>' . $soals->waktu . ' detik</center>';
      })
      ->addColumn('action', function ($soals) {
        return '<div style="text-align:center"><a href="elearning/soal/ubah/' . $soals->id . '" class="btn btn-success btn-xs">Ubah</a> <a href="elearning/soal/detail/' . $soals->id . '" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->rawColumns(['waktu', 'action'])->make(true);
  }
  public function detail(Request $request)
  {
    if (Auth::user()->status == 'G' or Auth::user()->status == 'A') {
      $id_soal = $request->id;
      $user = User::where('id', Auth::user()->id)->first();
      $soal = Soal::where('id', $request->id)->first();
      $soals = Detailsoal::where('id_soal', $request->id)->get();

      if($soal->jenis_soal == 0){
        $soal->jenis = "Normal";
      } else {
        $soal->jenis = "Cerdas Cermat";
      }

      return view('soal.detail', compact('user', 'soal', 'soals', 'id_soal'));
    } else {
      return redirect()->route('home.index');
    }
  }
  public function dataDetailSoal(Request $request)
  {
    // return Input::get('id');
    $soals = Detailsoal::where('id_soal', Input::get('id'));
    return Datatables::of($soals)
      ->editColumn('status', function ($soals) {
        if ($soals->status == 'Y') {
          return "<center><span class='label label-success'>Tampil</span></center>";
        } else {
          return "<center><span class='label label-danger'>Tidak tampil</span></center>";
        }
      })
      ->editColumn('kunci', function ($soals) {
        return '<center>' . $soals->kunci . '</center>';
      })
      ->editColumn('score', function ($soals) {
        return '<center>' . $soals->score . '</center>';
      })
      ->addColumn('action', function ($soals) {
        return '<div style="text-align:center"><a href="ubah/' . $soals->id . '" class="btn btn-success btn-xs">Ubah</a> <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#del-soal" onclick="deleteSoal('.$soals->id.')">Hapus</a> <a href="data-soal/' . $soals->id . '" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->rawColumns(['soal', 'kunci', 'score', 'action', 'status'])
      ->make(true);
  }

  public function ubahSoal(Request $request)
  {
    if (Auth::user()->status == 'G' or Auth::user()->status == 'A') {
      $soal = Soal::where('id', $request->id)->first();
      $user = User::where('id', Auth::user()->id)->first();
      return view('guru.soal.form.ubah', compact('user', 'soal'));
    } else {
      return redirect()->route('home.index');
    }
  }


  // for crud
  public function simpanSoal(Request $request)
  {
    if ($request['paket'] == "") {
      return response()->json(['status' => 'error', 'message' => 'Nama paket soal tidak boleh kosong.'], 422);
    } elseif ($request['deskripsi'] == "") {
      return response()->json(['status' => 'error', 'message' => 'Deskripsi tidak boleh kosong.'], 422);
    } elseif ($request['waktu'] == "") {
      return response()->json(['status' => 'error', 'message' => 'Waktu tidak boleh kosong.'], 422);
    } elseif ($request['jenis'] == "") {
      return response()->json(['status' => 'error', 'message' => 'Jenis waktu ujian belum dipilih.'], 422);
    } else {
      $isNew = ($request['id'] == 'N');
      if ($isNew) {
        $query = new Soal;
        $query->id_user = Auth::user()->id;
        $query->tampil = 0; // Default DRAFT: paket baru yang belum berisi butir soal tidak langsung terbit ke siswa
      } else {
        $query = Soal::where('id', $request['id'])->first();
      }
      $query->paket = $request['paket'];
      $query->deskripsi = $request['deskripsi'];
      $query->waktu = $request['waktu'];
      $query->jenis_soal = $request['jenis'];
      $query->password = !empty($request['password']) ? $request['password'] : null;
      if ($request->has('kkm') && $request['kkm'] !== null) {
        $query->kkm = $request['kkm'];
      }
      if($request->has('kategori_utama')){
        $query->kategori_utama = $request['kategori_utama'];
      }
      if($request->has('sub_kategori')){
        $query->sub_kategori = $request['sub_kategori'];
      }
      if($request->has('tipe_akses')){
        $query->tipe_akses = $request['tipe_akses'];
      }
      if($request->has('harga')){
        $query->harga = intval($request['harga']) ?: 0;
      }
      $query->save();

      if ($isNew) {
        return response()->json([
          'status' => 'ok',
          'id' => $query->id,
          'message' => 'Paket soal berhasil dibuat! Mengalihkan ke pengisian butir soal...',
          'redirect' => url('/elearning/soal/detail/' . $query->id . '?baru=1')
        ]);
      }
      return response()->json(['status' => 'ok', 'message' => 'Perubahan paket soal berhasil disimpan.']);
    }
  }

  public function togglePublish($id)
  {
    if (Auth::user()->status != 'G' && Auth::user()->status != 'A') {
      return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }
    $soal = Soal::findOrFail($id);
    $count = $soal->detailSoal()->count();

    $isCurrentlyPublished = ($soal->tampil == 1 || ($soal->tampil === null && $count > 0));

    if ($isCurrentlyPublished) {
      $soal->tampil = 0;
      $soal->save();
      return response()->json([
        'success' => true,
        'tampil' => 0,
        'message' => 'Paket soal berhasil diubah menjadi DRAFT (disembunyikan dari katalog siswa).'
      ]);
    } else {
      if ($count == 0) {
        return response()->json([
          'success' => false,
          'message' => 'Paket soal belum memiliki butir soal! Tambahkan minimal 1 butir soal sebelum menerbitkan paket ini ke siswa.'
        ], 422);
      }
      $soal->tampil = 1;
      $soal->save();
      return response()->json([
        'success' => true,
        'tampil' => 1,
        'message' => 'Paket soal berhasil DITERBITKAN dan kini dapat diakses oleh siswa di katalog.'
      ]);
    }
  }
  public function simpanDetailSoal(Request $request)
  {
    if ($request->soal == "") {
      return "Soal tidak boleh kosong.";
    }

    $kunci = $request->kunci;
    if ($request->tipe_soal == 'tkp' && empty($kunci)) {
      if ($request->has('bobot_opsi') && is_array($request->bobot_opsi)) {
        $sorted_bobot = $request->bobot_opsi;
        arsort($sorted_bobot);
        $kunci = key($sorted_bobot) ?: 'A';
      } else {
        $kunci = 'A';
      }
    }

    if (empty($kunci)) {
      return "Kunci jawaban soal tidak boleh kosong.";
    } elseif ($request->score == "") {
      return "Score soal tidak boleh kosong.";
    } elseif ($request->status == "") {
      return "Status soal tidak boleh kosong.";
    } else {
      if ($request->id == 'N') {
        $query = new Detailsoal;
        $query->id_soal = $request->id_soal;
        $query->jenis = 1;
        $query->id_user = Auth::user()->id;
        $query->sesi = $request->sesi;
      } else {
        $query = Detailsoal::where('id', $request->id)->first();
      }
      $query->soal = $request->soal;
      $query->pila = $request->pila;
      $query->pilb = $request->pilb;
      $query->pilc = $request->pilc;
      $query->pild = $request->pild;
      $query->pile = $request->pile;
      $query->kunci = is_array($kunci) ? json_encode($kunci) : $kunci;
      $query->score = $request->score;
      $query->status = $request->status;

      if ($request->has('tipe_soal')) {
        $query->tipe_soal = $request->tipe_soal;
      }
      if ($request->has('pembahasan_cepat')) {
        $query->pembahasan_cepat = $request->pembahasan_cepat;
      }
      if ($request->has('pembahasan_konsep')) {
        $query->pembahasan_konsep = $request->pembahasan_konsep;
      }
      if ($request->has('bobot_opsi')) {
        $query->bobot_opsi = is_array($request->bobot_opsi) ? json_encode($request->bobot_opsi) : $request->bobot_opsi;
      }

      $query->save();
      return 'ok';
    }
  }
  public function ubahDetailSoal(Request $request)
  {
    if (Auth::user()->status == 'G' or Auth::user()->status == 'A') {
      $id_soal = $request->id;
      $user = User::where('id', Auth::user()->id)->first();
      $soal = Detailsoal::where('id', $request->id)->first();
      return view('soal.form.ubah', compact('user', 'soal', 'id_soal'));
    } else {
      return redirect()->route('home.index');
    }
  }
  public function detailDataSoal(Request $request)
  {
    if (Auth::user()->status == 'G' or Auth::user()->status == 'A') {
      $id_soal = $request->id;
      $user = User::where('id', Auth::user()->id)->first();
      $soal = Detailsoal::where('id', $request->id)->first();
      return view('soal.detailSoal', compact('user', 'soal', 'id_soal'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function simpanDetailSoalExcel(Request $request)
  {
    $sesi = md5(rand(0000000000, mt_getrandmax()));
    $baris = 1;
    $sukses = 0;
    $gagal = 0;
    $kesalahan = '';
    if ($request->hasFile('file')) {
      $path = $request->file('file')->getRealPath();
      $data = Excel::load($request->file('file'), function ($reader) {
      })->get();
      foreach ($data as $data_arr) {
        foreach ($data_arr as $key => $value) {
          $jumlah = $key;
          if ($value->id_soal == '') {
            if ($kesalahan) {
              $kesalahan = $kesalahan . '<br>- Kode soal kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            } else {
              $kesalahan = $kesalahan . '- Kode soal kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            }
            return view('soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
          } elseif ($value->soal == '') {
            if ($kesalahan) {
              $kesalahan = $kesalahan . '<br>- Soal kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            } else {
              $kesalahan = $kesalahan . '- Soal kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            }
            return view('soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
          } elseif ($value->kunci_jawaban == '') {
            if ($kesalahan) {
              $kesalahan = $kesalahan . '<br>- Pilihan jawaban kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            } else {
              $kesalahan = $kesalahan . '- Pilihan jawaban kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            }
            return view('soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
          } elseif ($value->score == '') {
            if ($kesalahan) {
              $kesalahan = $kesalahan . '<br>- Score kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            } else {
              $kesalahan = $kesalahan . '- Score kosong pada baris <b>' . $baris . '</b>, proses upload dihentikan. Silahkan cek file Excel Anda lalu upload kembali.';
            }
            return view('soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
          }
          $query = new Detailsoal;
          $query->id_soal = $value->id_soal;
          $query->soal = $value->soal;
          $query->pila = $value->pilihan_a;
          $query->pilb = $value->pilihan_b;
          $query->pilc = $value->pilihan_c;
          $query->pild = $value->pilihan_d;
          $query->pile = $value->pilihan_e;
          $query->kunci = $value->kunci_jawaban;
          $query->score = $value->score;
          $query->id_user = Auth::user()->id;
          $query->status = 'Y';
          $query->sesi = $sesi;
          $query->tipe_soal = isset($value->tipe_soal) ? $value->tipe_soal : 'single';
          $query->pembahasan_cepat = isset($value->pembahasan_cepat) ? $value->pembahasan_cepat : (isset($value->trik_cepat) ? $value->trik_cepat : null);
          $query->pembahasan_konsep = isset($value->pembahasan_konsep) ? $value->pembahasan_konsep : (isset($value->pembahasan) ? $value->pembahasan : null);
          if ($query->save()) {
            $sukses = $sukses + 1;
          }
        }
      }
      if ($sukses > $jumlah) {
        $sukses == $jumlah;
      }
      $aktifitas = new Aktifitas;
      $aktifitas->id_user = Auth::user()->id;
      $aktifitas->nama = 'Mengupload data detail soal via Excel. Jumlah data ' . $jumlah . ', sukses diupload sebanyak: ' . $sukses . ' dan gagal diupload sebanyak: ' . $gagal;
      $aktifitas->save();
      return view('soal.hasil_upload_via_excel', compact('sukses', 'gagal', 'jumlah', 'kesalahan'));
    } else {
      return redirect()->route('soal');
    }
  }

  public function uploadGambarSoal(Request $request)
  {
    if ($request->hasFile('image')) {
      $file = $request->file('image');
      $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
      $dest = public_path('assets/img/soal');
      if (!file_exists($dest)) {
        mkdir($dest, 0777, true);
      }
      $file->move($dest, $filename);
      return url('assets/img/soal/' . $filename);
    }
    return '';
  }

  public function saveEssay(Request $request)
  {
    return $request;
  }
}
