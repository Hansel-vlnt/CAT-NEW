<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Models\Soal;
use App\Models\Materi;
use App\Models\Aktifitas;
use App\Models\Detailsoal;
use App\Models\School;
use Carbon\Carbon;

Carbon::setLocale('id');

class HomeController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $siswas = User::where('status', 'S')->count();
    $pakets = Soal::count();
    $soals = Detailsoal::count();
    $aktifitas = Aktifitas::orderBy('id', 'DESC')->paginate(5);
    $userInfo = User::where('id', Auth::user()->id)->first();
    $voucher = ["status" => 0, "message" => "Anda tidak memiliki kode voucher yang aktif!", "expiry_date" => null];
    $expiryFromVoucher = null;

    if(!empty($userInfo->voucher)){
      $checkVoucher   = DB::table('vouchers')->where('id_voucher', $userInfo->voucher)->whereNotNull("used_by")->first();
      if ($checkVoucher && !empty($checkVoucher->used_date)) {
        $expiry         = date('Y-m-d', strtotime(date($checkVoucher->used_date). ' + '.$checkVoucher->masa_berlaku.' days'));
        $expiryFromVoucher = $expiry;
        $now            = date("Y-m-d");
        if($now > $expiry){
          $voucher = ["status" => 0, "message" => "Masa berlaku kode voucher Anda telah habis pada ".date("d-m-Y", strtotime($expiry)).". Silahkan gunakan kode voucher yang baru.", "expiry_date" => $expiry];
        } else {
          $voucher = ["status" => 1, "message" => "", "expiry_date" => $expiry];
        }
      }
    }

    if ($userInfo && $userInfo->isLanggananLes()) {
      $voucher = [
        "status" => 1,
        "message" => "",
        "expiry_date" => $userInfo->tgl_berakhir_les ?: $expiryFromVoucher
      ];
    }
    
    return view('home', compact('siswas', 'pakets', 'soals', 'voucher'));
    // if (Auth::user()->status == 'A' || Auth::user()->status == 'S') {
    // }else{
    //   return view('home', compact('siswas', 'gurus', 'pakets', 'materis', 'aktifitas'));
    // }
  }

  public function vouchers(){
    $user = User::findorfail(Auth::user()->id);
    $vouchers = DB::table('vouchers')->whereNull("used_by")->orderBy("id_voucher", "asc")->paginate(20);
    return View::make('vouchers')->with(compact("vouchers", "user"));
  }

  public function generateVoucher($len){
      $pass = array();
      $string = "0ABC1DEF2GHI3JKL4MNO5PQR6STU7VWX8YZ9";
      $i=0;
      while($i<$len){
          $int = rand(0, 35);
          $pass[] = $string[$int];
          $i++;
      }
      return implode('', $pass);
  }

  public function vouchers_save(Request $req){
      $kode_voucher   = $req->kode_voucher;
      $masa_berlaku   = $req->masa_berlaku;
      $masa_berlaku2  = $req->masa_berlaku2;

      $validator = Validator::make($req->all(), [
          'kode_voucher'  => ['required', 'min:6', 'max:50', 'unique:vouchers'],
          'masa_berlaku'  => ['required', 'numeric', 'min:1'],
          'masa_berlaku2' => ['required']
          
      ],
      [
          'kode_voucher.required'       => 'Kode Voucher belum diisi!',
          'kode_voucher.min'            => 'Kode Voucher minimal 6 karakter!',
          'kode_voucher.max'            => 'Kode Voucher maksimal 50 karakter!',
          'kode_voucher.unique'         => 'Kode Voucher sudah pernah digunakan!',
          'masa_berlaku.min'            => 'Masa berlaku voucher tidak boleh 0!',
          'masa_berlaku.required'       => 'Masa berlaku voucher belum diisi!',
          'masa_berlaku.numeric'        => 'Masa berlaku voucher harus angka!',
          'masa_berlaku2.required'      => 'Masa berlaku voucher belum pilih!',
      ]);

      if($masa_berlaku2 == 0){
          $mb = $masa_berlaku;
      } else if($masa_berlaku2 == 1){
          $mb = $masa_berlaku * 7;
      } else if($masa_berlaku2 == 2){
          $mb = $masa_berlaku * 30;
      } else {
          $mb = $masa_berlaku * 365;
      }

    $data = [
        "kode_voucher"      => $kode_voucher,
        "masa_berlaku"      => $mb,
    ];

    if ($validator->fails()) {
        Session::flash('error', $validator->messages()->first());
    } else {
        $add = DB::table('vouchers')->insertGetId($data);

        if($add){
            Session::flash('success', "Kode Vucher berhasil dibuat!");
        } else {
            Session::flash('error', "Kode Voucher yang berhasil dibuat!");
        }
    }
    
    return redirect()->back();
  }

  public function vouchers_delete(Request $req)
  {
      $del = DB::table('vouchers')->where("id_voucher", $req->delete_id)->delete();

      if ($del) {
          $req->session()->flash('success', "Voucher berhasil dihapus!");
      } else {
          $req->session()->flash('error', "Voucher gagal dihapus!");
      }

      return redirect()->back();
  }


  public function pengaturan()
  {
    $user = User::findorfail(Auth::user()->id);
    return view('pengaturan.index', compact('user'));
  }

  public function activity()
  {
    return view('errors.404');
  }
}
