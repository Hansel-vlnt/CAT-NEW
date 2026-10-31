<?php

namespace App\Http\Controllers;

use App\Models\PaketLangganan;
use App\Models\Setting;
use App\Models\Transaksi;
use App\Models\Aktifitas;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class PembayaranController extends Controller
{
    /**
     * Buat pesanan pembayaran baru (QRIS atau Transfer Bank)
     */
    public function buatPesanan(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
        }

        $request->validate([
            'id_paket' => 'required|integer',
            'metode'   => 'nullable|string|in:qris,transfer_bank',
        ]);

        $paket = PaketLangganan::where('id', $request->id_paket)->where('is_aktif', 1)->first();
        if (!$paket) {
            return response()->json(['success' => false, 'message' => 'Paket langganan tidak ditemukan atau sudah tidak aktif.'], 404);
        }

        $metode = $request->metode ?: 'qris';
        $orderId = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));
        
        // Untuk transfer bank dapat diberikan 3 digit kode unik agar mudah verifikasi, sedangkan QRIS nominal pas
        $kodeUnik = ($metode === 'transfer_bank') ? rand(100, 999) : 0;
        $totalBayar = $paket->harga + $kodeUnik;

        $transaksi = Transaksi::create([
            'order_id'     => $orderId,
            'id_user'      => Auth::id(),
            'id_paket'     => $paket->id,
            'nama_paket'   => $paket->nama_paket,
            'durasi_bulan' => $paket->durasi_bulan,
            'durasi_hari'  => $paket->durasi_hari,
            'nominal'      => $paket->harga,
            'kode_unik'    => $kodeUnik,
            'total_bayar'  => $totalBayar,
            'metode'       => $metode,
            'status'       => 'PENDING',
            'expired_at'   => now()->addHours(2),
        ]);

        // QRIS Code URL
        $customQris = Setting::get('qris_image');
        $qrisData = "00020101021226600016ID.CO.ABDIPRAJA.WWW011893600998" . $transaksi->order_id . "520458125303360540" . $transaksi->total_bayar . "5802ID5918ABDI PRAJA EDUKASI6005MEDAN6304";
        $qrisQrUrl = $customQris ?: "https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=10&data=" . urlencode($qrisData);

        return response()->json([
            'success'         => true,
            'order_id'        => $transaksi->order_id,
            'id_transaksi'    => $transaksi->id,
            'nama_paket'      => $transaksi->nama_paket,
            'durasi_bulan'    => $transaksi->durasi_bulan,
            'durasi_hari'     => $transaksi->durasi_hari,
            'nominal'         => $transaksi->nominal,
            'kode_unik'       => $transaksi->kode_unik,
            'total_bayar'     => $transaksi->total_bayar,
            'formatted_total' => $transaksi->formatted_total,
            'metode'          => $transaksi->metode,
            'bank_info'       => Setting::getBankInfo(),
            'admin_wa'        => Setting::getAdminWa(),
            'qris_url'        => $qrisQrUrl,
            'status'          => $transaksi->status,
            'expired_at'      => $transaksi->expired_at ? $transaksi->expired_at->format('d-m-Y H:i') : null,
        ]);
    }

    /**
     * Cek status pembayaran secara berkala (AJAX Polling dari Frontend Siswa)
     */
    public function cekStatus($orderId)
    {
        $transaksi = Transaksi::where('order_id', $orderId)->first();
        if (!$transaksi) {
            return response()->json(['status' => 'NOT_FOUND', 'message' => 'Pesanan tidak ditemukan.'], 404);
        }

        // Pastikan hanya pemilik order atau admin yang bisa cek
        if (Auth::check() && Auth::id() !== $transaksi->id_user && Auth::user()->status !== 'A') {
            return response()->json(['status' => 'FORBIDDEN', 'message' => 'Akses ditolak.'], 403);
        }

        $user = User::find($transaksi->id_user);

        return response()->json([
            'status'           => $transaksi->status,
            'order_id'         => $transaksi->order_id,
            'kode_voucher'     => $transaksi->kode_voucher,
            'nama_paket'       => $transaksi->nama_paket,
            'durasi_hari'      => $transaksi->durasi_hari,
            'tgl_berakhir_les' => ($user && $user->tgl_berakhir_les) ? date('d-m-Y', strtotime($user->tgl_berakhir_les)) : null,
            'message'          => ($transaksi->status === 'PAID') ? 'Pembayaran terdeteksi! Akun Anda telah aktif.' : 'Menunggu pembayaran...',
        ]);
    }

    /**
     * Simulasi deteksi dana masuk (Instant Demo / Trigger untuk testing)
     */
    public function simulasiBayar(Request $request, $orderId)
    {
        $transaksi = Transaksi::where('order_id', $orderId)->first();
        if (!$transaksi) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan.'], 404);
        }

        if ($transaksi->status === 'PAID') {
            return response()->json([
                'success'      => true,
                'status'       => 'PAID',
                'kode_voucher' => $transaksi->kode_voucher,
                'message'      => 'Pembayaran sudah lunas sebelumnya.',
            ]);
        }

        $this->selesaikanPembayaranInternal($transaksi);

        $user = User::find($transaksi->id_user);

        return response()->json([
            'success'          => true,
            'status'           => 'PAID',
            'order_id'         => $transaksi->order_id,
            'kode_voucher'     => $transaksi->kode_voucher,
            'tgl_berakhir_les' => ($user && $user->tgl_berakhir_les) ? date('d-m-Y', strtotime($user->tgl_berakhir_les)) : null,
            'message'          => 'Dana berhasil dideteksi masuk! Token langganan telah aktif.',
        ]);
    }

    /**
     * Public Webhook Endpoint (Untuk Midtrans / Tripay / Sistem Bank Callback)
     */
    public function webhook(Request $request)
    {
        // Mendukung berbagai format payload: order_id, merchant_order_id, external_id
        $orderId = $request->order_id ?: ($request->merchant_order_id ?: $request->external_id);
        $status = strtolower($request->transaction_status ?: ($request->status ?: ''));

        if (!$orderId) {
            return response()->json(['status' => 'error', 'message' => 'Order ID tidak ditemukan dalam payload.'], 400);
        }

        $transaksi = Transaksi::where('order_id', $orderId)->first();
        if (!$transaksi) {
            return response()->json(['status' => 'error', 'message' => 'Transaksi tidak ditemukan.'], 404);
        }

        // Indikasi sukses pembayaran standar
        $successKeywords = ['settlement', 'capture', 'paid', 'success', 'berhasil'];
        if (in_array($status, $successKeywords) || empty($status)) {
            $this->selesaikanPembayaranInternal($transaksi);
            return response()->json(['status' => 'ok', 'message' => 'Transaksi berhasil diverifikasi dan diselesaikan.']);
        }

        return response()->json(['status' => 'ignored', 'message' => 'Status pembayaran bukan keberhasilan.']);
    }

    /**
     * Konfirmasi Manual 1-Klik oleh Administrator
     */
    public function konfirmasiAdmin(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->status !== 'A') {
            abort(403, 'Akses terbatas untuk Administrator.');
        }

        $transaksi = Transaksi::findOrFail($id);
        if ($transaksi->status !== 'PAID') {
            $this->selesaikanPembayaranInternal($transaksi);
            Session::flash('success', "Pembayaran untuk transaksi #{$transaksi->order_id} berhasil dikonfirmasi! Token langganan {$transaksi->kode_voucher} telah terbit.");
        } else {
            Session::flash('info', "Transaksi #{$transaksi->order_id} sudah dalam status lunas.");
        }

        return redirect()->back();
    }

    /**
     * Tampilkan Daftar Riwayat Transaksi di Panel Admin
     */
    public function riwayatAdmin(Request $request)
    {
        if (!Auth::check() || Auth::user()->status !== 'A') {
            abort(403, 'Akses terbatas untuk Administrator.');
        }

        $user = Auth::user();
        $query = Transaksi::with(['user', 'paket'])->orderBy('id', 'desc');

        if ($request->status && $request->status !== 'all') {
            $query->where('status', strtoupper($request->status));
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('kode_voucher', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('nama', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $transaksis = $query->paginate(15);
        $totalPending = Transaksi::where('status', 'PENDING')->count();
        $totalPaid = Transaksi::where('status', 'PAID')->count();
        $totalNominalPaid = Transaksi::where('status', 'PAID')->sum('total_bayar');

        return view('transaksi.index', compact('transaksis', 'user', 'totalPending', 'totalPaid', 'totalNominalPaid'));
    }

    /**
     * Logika Inti: Penerbitan Token & Aktivasi Akun Langganan
     */
    protected function selesaikanPembayaranInternal(Transaksi $transaksi)
    {
        if ($transaksi->status === 'PAID') {
            return $transaksi;
        }

        // 1. Generate Kode Voucher Eksklusif
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $randomStr = '';
        for ($c = 0; $c < 6; $c++) {
            $randomStr .= $characters[rand(0, strlen($characters) - 1)];
        }
        $voucherCode = 'ABDI-' . $transaksi->durasi_bulan . 'B-' . $randomStr;

        // 2. Simpan ke tabel vouchers
        $voucherId = DB::table('vouchers')->insertGetId([
            'kode_voucher' => $voucherCode,
            'masa_berlaku' => $transaksi->durasi_hari,
            'used_by'      => $transaksi->id_user,
            'used_date'    => date('Y-m-d'),
        ]);

        // 3. Aktivasi Otomatis Akun Siswa (Smart Extension)
        $user = User::find($transaksi->id_user);
        if ($user) {
            $baseDate = date('Y-m-d');
            if ($user->status_langganan === 'les' && !empty($user->tgl_berakhir_les) && $user->tgl_berakhir_les >= $baseDate) {
                $baseDate = $user->tgl_berakhir_les;
            }
            $expiry = date('Y-m-d', strtotime($baseDate . ' + ' . $transaksi->durasi_hari . ' days'));

            $user->status_langganan = 'les';
            $user->tgl_berakhir_les = $expiry;
            $user->voucher = $voucherId;
            $user->save();
        }

        // 4. Update status transaksi
        $transaksi->status = 'PAID';
        $transaksi->kode_voucher = $voucherCode;
        $transaksi->paid_at = now();
        $transaksi->save();

        // 5. Catat log aktifitas
        $aktifitas = new Aktifitas;
        $aktifitas->id_user = $transaksi->id_user;
        $aktifitas->nama = 'Pembayaran transaksi #' . $transaksi->order_id . ' lunas. Token langganan ' . $voucherCode . ' aktif otomatis.';
        $aktifitas->save();

        return $transaksi;
    }
}
