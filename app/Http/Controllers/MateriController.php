<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DataTables;
use DB;

use App\User;
use App\Models\Materi;

class MateriController extends Controller
{
  public function __construct()
  {
  	$this->middleware('auth');
  }
  public function index() {
  	if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
	  	$user = User::where('id', Auth::user()->id)->first();
	  	return view('materi.index', compact('user'));
	  }else{
	  	return redirect()->route('home.index');
	  }
  }
  public function dataMateriGuru ()
  {
  	if(Auth::user()->status == 'G'){
	  	$materis = Materi::where('id_user', Auth::user()->id)->get();
	  }else{
	  	$materis = Materi::get();
	  }
	  return Datatables::of($materis)
	  										->editColumn('status', function($materis) {
	  											if ($materis->status == 'Y') {
	  												return 'Tampil';
	  											}else{
	  												return 'Tidak tampil';
	  											}
	  										})
	  										->editColumn('tipe_akses', function($materis) {
	  											if ($materis->tipe_akses == 'berbayar') {
	  												return '<center><span class="label label-warning" style="background-color:#f59e0b; color:#fff; font-weight:bold; padding:4px 8px; border-radius:6px;">Khusus Les</span></center>';
	  											}
	  											return '<center><span class="label label-success" style="background-color:#10b981; color:#fff; font-weight:bold; padding:4px 8px; border-radius:6px;">Gratis</span></center>';
	  										})
	  										->editColumn('hits', function($materis) {
	  											return $materis->hits.' kali';
	  										})
	  										->addColumn('action', function($materis) {
	  											return '<div style="text-align:center"><a href="' . url('/elearning/materi/detail/'.$materis->id) . '" class="btn btn-primary btn-xs">Detail</a> <a href="' . url('/elearning/materi/ubah/'.$materis->id) . '" class="btn btn-success btn-xs">Ubah</a></div>';
	  										})
	  										->rawColumns(['action', 'status', 'tipe_akses'])
	  										->make(true);
  }
  public function detail(Request $request)
  {
  	if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
	  	$user = User::where('id', Auth::user()->id)->first();
	  	$materi = Materi::where('id', $request->id)->first();
	  	return view('materi.detail', compact('user', 'materi'));
	  }else{
	  	return redirect()->route('home.index');
	  }
  }
  public function ubah(Request $request)
  {
  	if(Auth::user()->status == 'G' or Auth::user()->status == 'A'){
	  	$user = User::where('id', Auth::user()->id)->first();
	  	$materi = Materi::where('id', $request->id)->first();
	  	return view('materi.form.ubah', compact('user', 'materi'));
	  }else{
	  	return redirect()->route('home.index');
	  }
  }
}
