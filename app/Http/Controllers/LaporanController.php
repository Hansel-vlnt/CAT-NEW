<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use Datatables;
use DB;
use Excel;
use PDF;

use App\User;
use App\Models\Jawab;
use App\Models\Soal;
use App\Models\Detailsoal;
use App\Models\DetailSoalEssay;
use App\Models\JawabEsay;
// use Barryvdh\DomPDF\PDF;
// use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class LaporanController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(Request $request)
  {
    if (auth()->user()->status == 'G' or auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->get();
      $soal = Soal::select("*")->get();
      return view('laporan.index', compact('user', 'soal'));
    } else {
      return redirect()->route('home.index');
    }
  }

  public function laporanPerPaket(Request $req)
  {
    if (auth()->user()->status == 'G' or auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->get();
      $soal = Soal::where('id', $req->id)->first();
      if(!empty($soal)){
        return view('laporan.laporan', compact('user', 'soal'));
      } else {
        return redirect()->route('home.index');
      }
    } else {
      return redirect()->route('home.index');
    }
  }

  public function data_paket_soal(Request $request)
  {
    $hasils = Jawab::join('soals', 'jawabs.id_soal', '=', 'soals.id')
      ->select('soals.paket', 'jawabs.*')
      ->where('jawabs.id_soal', $request->id_kelas)->groupBy('jawabs.id_soal')->get();
    return Datatables::of($hasils)
      ->addColumn('action', function ($hasils) {
        return '<div style="text-align:center"><a href="' . $hasils->id_kelas . '/paket-soal/' . $hasils->id_soal . '" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->make(true);
  }
  
  public function dataKelasPaketSoal(Request $request)
  {
 
    $jawabs = Jawab::select('jawabs.*', DB::raw('sum(score) as jumlah_nilai'))
      ->where('id_soal', $request->id_soal)->groupBy('id_user');
    return Datatables::of($jawabs)
      ->addColumn('nama', function ($jawabs) {
        if ($jawabs->user) {
          return $jawabs->user->nama;
        } else {
          return 'no name';
        }
      })
      ->addColumn('jumlah_nilai', function ($jawabs) {
        return $jawabs->jumlah_nilai;
      })
      ->addColumn('action', function ($jawabs) {
        return '<div style="text-align:center"><a href="/elearning/laporan/'.$jawabs->id_soal.'/'.$jawabs->id_user.'" class="btn btn-primary btn-xs">Detail</a></div>';
      })
      ->make(true);
  }

  public function detailLaporanSiswa(Request $request)
  {
    if (auth()->user()->status == 'G' or auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      $siswa = User::where('id', $request->id_user)->first();
      $soal = Soal::select('paket', 'id')->where('id', $request->id_soal)->first();
      $hasil_ujian = Jawab::select(DB::raw('SUM(jawabs.score) as jumlah_nilai'), 'jawabs.created_at', 'jawabs.status')
        ->where([['jawabs.id_user', $request->id_user], ['jawabs.id_soal', $request->id_soal]])
        ->first();
      $soal_essay = DetailSoalEssay::where('id_soal', $request->id_soal)->get();
      $nilai_essay = 0;
      if ($soal_essay->count() > 0) {
        foreach ($soal_essay as $essay) {
          $nilai_essay = $nilai_essay + ($essay->getJawab->score ?? 0);
        }
      }

      return view('laporan.detailSiswa', compact('user', 'siswa', 'hasil_ujian', 'soal', 'nilai_essay'));
    } else {
      return redirect()->route('home.index');
    }
  }
  public function hasilSiswa(Request $request)
  {
    $jawabs = Jawab::where([['jawabs.id_user', $request->id_user], ['jawabs.id_soal', $request->id_soal]]);
    return Datatables::of($jawabs)
      ->addColumn('empty_space', function () {
        return '&nbsp;';
      })
      ->addColumn('dataSoal', function ($jawabs) {
        if ($jawabs->detailSoal) {
          return $jawabs->detailSoal->soal;
        } else {
          return 'No have question';
        }
      })
      ->addColumn('kunci', function ($jawabs) {
        if ($jawabs->detailSoal) {
          return $jawabs->detailSoal->kunci;
        } else {
          return 'No have question';
        }
      })
      ->rawColumns(['dataSoal'])
      ->make(true);
  }
  public function excelHasilUjianPerkelas(Request $request)
  {
    $soal = Soal::where('id', $request->soal)->first();
    $detailSoal = Detailsoal::where('id_soal', $request->soal)->get();
    $jawabs = Jawab::where('id_soal', $request->soal)->groupBy('id_user')->get();
    $soal_essay = DetailSoalEssay::where('id_soal', $request->soal)->get();
    // return view('laporan.excel.excel_hasil_ujian_perkelas', compact('jawabs', 'soal', 'kelas', 'detailSoal'));

    Excel::create('Laporan Nilai', function ($excel) use ($jawabs, $soal, $detailSoal, $soal_essay) {
      $excel->sheet('New sheet', function ($sheet) use ($jawabs, $soal, $detailSoal, $soal_essay) {
        $sheet->setStyle(array(
          'font' => array(
            'size' =>  12,
          )
        ));
        $sheet->loadView('laporan.excel.excel_hasil_ujian_perkelas', compact('jawabs', 'soal', 'detailSoal', 'soal_essay'));
      });
    })->download('xlsx');
  }
  public function pdfHasilUjianPersiswa(Request $request)
  {
    $siswa = User::where('id', $request->siswa)->first();
    $jumlah_soal = Detailsoal::where('id_soal', $request->soal)->count();
    $soals = Detailsoal::where('id_soal', $request->soal)->where('status', 1)->get();
    $jawabs = Jawab::where('id_soal', $request->soal)->where('id_user', $request->siswa)->where('status', 1)->get();
    $jawabBenar = Jawab::where('id_soal', $request->soal)->where('id_user', $request->siswa)->where('status', 1)->where('score', '!=', '0')->get();
    $jawab_first = Jawab::where('id_soal', $request->soal)
      ->where('id_user', $request->siswa)
      ->where('status', 1)->first();
    $jumlah_jawaban_benar = Jawab::where('id_soal', $request->soal)
      ->where('id_user', $request->siswa)
      ->where('status', 1)
      ->select(DB::raw('sum(jawabs.score) as jumlahNilai'))
      ->first();
    $pdf = PDF::loadView('laporan.pdf.hasil_ujian', compact('jawabs', 'siswa', 'soals', 'jawabBenar', 'jumlah_jawaban_benar', 'jawab_first', 'jumlah_soal'));
    return $pdf->setPaper('legal')->stream('hasil_ujian.pdf');
    //return view('laporan.pdf.hasil_ujian', compact('jawabs', 'siswa', 'soals', 'jawabBenar', 'jumlah_jawaban_benar', 'jawab_first', 'jumlah_soal'));
  }
}
