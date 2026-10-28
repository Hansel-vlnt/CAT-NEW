<?php

namespace App\Http\Controllers;

use App\Models\PaketLangganan;
use App\Models\Aktifitas;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PaketLanggananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan halaman manajemen paket langganan untuk admin
     */
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($user->status !== 'A') {
            abort(403, 'Akses terbatas untuk Administrator.');
        }

        $pakets = PaketLangganan::orderBy('urutan', 'asc')->orderBy('id', 'asc')->get();
        return view('paket-langganan.index', compact('pakets', 'user'));
    }

    /**
     * Simpan paket langganan baru (Custom bulan & harga)
     */
    public function store(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($user->status !== 'A') {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'nama_paket'   => 'required|string|max:100',
            'durasi_bulan' => 'required|integer|min:1',
            'durasi_hari'  => 'nullable|integer|min:1',
            'harga'        => 'required|numeric|min:0',
            'harga_coret'  => 'nullable|numeric|min:0',
            'badge'        => 'nullable|string|max:50',
            'deskripsi'    => 'nullable|string',
            'fitur'        => 'nullable|string',
            'urutan'       => 'nullable|integer',
        ], [
            'nama_paket.required'   => 'Nama Paket wajib diisi.',
            'durasi_bulan.required' => 'Durasi Bulan wajib diisi (minimal 1 bulan).',
            'durasi_bulan.min'      => 'Durasi minimal 1 bulan.',
            'harga.required'        => 'Harga wajib diisi.',
            'harga.numeric'         => 'Harga harus berupa angka.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->first());
        }

        $durasiBulan = intval($request->durasi_bulan);
        $durasiHari = $request->durasi_hari ? intval($request->durasi_hari) : ($durasiBulan * 30);

        $paket = PaketLangganan::create([
            'nama_paket'   => trim($request->nama_paket),
            'durasi_bulan' => $durasiBulan,
            'durasi_hari'  => $durasiHari,
            'harga'        => intval($request->harga),
            'harga_coret'  => $request->harga_coret ? intval($request->harga_coret) : null,
            'badge'        => $request->badge ? trim($request->badge) : null,
            'deskripsi'    => $request->deskripsi ? trim($request->deskripsi) : null,
            'fitur'        => $request->fitur ? trim($request->fitur) : null,
            'urutan'       => $request->urutan ? intval($request->urutan) : 0,
            'is_aktif'     => 1,
        ]);

        $aktifitas = new Aktifitas;
        $aktifitas->id_user = $user->id;
        $aktifitas->nama = 'Menambahkan paket langganan custom: ' . $paket->nama_paket . ' (' . $durasiBulan . ' Bulan, Rp ' . number_format($paket->harga, 0, ',', '.') . ')';
        $aktifitas->save();

        Session::flash('success', 'Paket Langganan "' . $paket->nama_paket . '" berhasil dibuat!');
        return redirect()->route('paket-langganan.index');
    }

    /**
     * Perbarui data paket langganan
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($user->status !== 'A') {
            abort(403);
        }

        $paket = PaketLangganan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_paket'   => 'required|string|max:100',
            'durasi_bulan' => 'required|integer|min:1',
            'durasi_hari'  => 'nullable|integer|min:1',
            'harga'        => 'required|numeric|min:0',
            'harga_coret'  => 'nullable|numeric|min:0',
            'badge'        => 'nullable|string|max:50',
            'deskripsi'    => 'nullable|string',
            'fitur'        => 'nullable|string',
            'urutan'       => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->first());
        }

        $durasiBulan = intval($request->durasi_bulan);
        $durasiHari = $request->durasi_hari ? intval($request->durasi_hari) : ($durasiBulan * 30);

        $paket->update([
            'nama_paket'   => trim($request->nama_paket),
            'durasi_bulan' => $durasiBulan,
            'durasi_hari'  => $durasiHari,
            'harga'        => intval($request->harga),
            'harga_coret'  => $request->harga_coret ? intval($request->harga_coret) : null,
            'badge'        => $request->badge ? trim($request->badge) : null,
            'deskripsi'    => $request->deskripsi ? trim($request->deskripsi) : null,
            'fitur'        => $request->fitur ? trim($request->fitur) : null,
            'urutan'       => $request->urutan ? intval($request->urutan) : 0,
        ]);

        $aktifitas = new Aktifitas;
        $aktifitas->id_user = $user->id;
        $aktifitas->nama = 'Memperbarui paket langganan: ' . $paket->nama_paket;
        $aktifitas->save();

        Session::flash('success', 'Paket Langganan "' . $paket->nama_paket . '" berhasil diperbarui!');
        return redirect()->route('paket-langganan.index');
    }

    /**
     * Hapus paket langganan
     */
    public function destroy($id)
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($user->status !== 'A') {
            abort(403);
        }

        $paket = PaketLangganan::findOrFail($id);
        $nama = $paket->nama_paket;
        $paket->delete();

        $aktifitas = new Aktifitas;
        $aktifitas->id_user = $user->id;
        $aktifitas->nama = 'Menghapus paket langganan: ' . $nama;
        $aktifitas->save();

        Session::flash('success', 'Paket Langganan "' . $nama . '" berhasil dihapus.');
        return redirect()->route('paket-langganan.index');
    }

    /**
     * Toggle status aktif paket (Aktif / Nonaktif)
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($user->status !== 'A') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $paket = PaketLangganan::findOrFail($id);
        $paket->is_aktif = !$paket->is_aktif;
        $paket->save();

        return response()->json([
            'success' => true,
            'is_aktif' => $paket->is_aktif,
            'message' => 'Status paket "' . $paket->nama_paket . '" berhasil diubah menjadi ' . ($paket->is_aktif ? 'Aktif' : 'Nonaktif') . '.'
        ]);
    }

    /**
     * Generate Voucher Langsung untuk Paket Tertentu
     */
    public function generateVouchers(Request $request, $id)
    {
        $user = User::findOrFail(Auth::user()->id);
        if ($user->status !== 'A') {
            abort(403);
        }

        $paket = PaketLangganan::findOrFail($id);
        $jumlah = min(max(intval($request->jumlah ?: 1), 1), 50);

        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $createdCodes = [];

        for ($i = 0; $i < $jumlah; $i++) {
            $randomStr = '';
            for ($c = 0; $c < 6; $c++) {
                $randomStr .= $characters[rand(0, strlen($characters) - 1)];
            }
            $code = 'ABDI-' . $paket->durasi_bulan . 'B-' . $randomStr;

            DB::table('vouchers')->insert([
                'kode_voucher' => $code,
                'masa_berlaku' => $paket->durasi_hari,
            ]);
            $createdCodes[] = $code;
        }

        Session::flash('success', 'Berhasil membuat ' . $jumlah . ' Kode Voucher untuk ' . $paket->nama_paket . ' (' . $paket->durasi_hari . ' Hari).');
        return redirect()->route('vouchers');
    }
}
