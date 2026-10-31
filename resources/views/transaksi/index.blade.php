@extends('layouts.app')
@section('title', 'Riwayat Transaksi & Pembayaran - Abdi Praja Edukasi')
@section('breadcrumb')
  <div class="w-full">
    <div class="flex items-center gap-2 text-sm font-semibold text-slate-500 mb-1.5">
      <a href="{{ url('/home') }}" class="hover:text-indigo-600 transition">Dashboard</a>
      <span>/</span>
      <span class="text-slate-800">Transaksi &amp; Pembayaran</span>
    </div>
    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Pembayaran &amp; Langganan</h1>
  </div>
@endsection

@section('content')
<div class="col-xs-12">
  <div class="max-w-7xl mx-auto space-y-6">

    @if(Session::has('success'))
      <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-semibold text-sm flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2.5">
          <i class="fa fa-check-circle text-emerald-600 text-lg"></i>
          <span>{{ Session::get('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold text-sm">✕</button>
      </div>
    @endif

    @if(Session::has('info'))
      <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-800 font-semibold text-sm flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2.5">
          <i class="fa fa-info-circle text-blue-600 text-lg"></i>
          <span>{{ Session::get('info') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-blue-600 hover:text-blue-900 font-bold text-sm">✕</button>
      </div>
    @endif

    <!-- KPI STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
      <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
          <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Lunas (Paid)</span>
          <div class="text-3xl font-black text-emerald-600 mt-1">{{ $totalPaid }}</div>
          <span class="text-xs text-slate-400 font-medium">Transaksi berhasil</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold">
          <i class="fa fa-check"></i>
        </div>
      </div>

      <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
          <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Menunggu Bayar</span>
          <div class="text-3xl font-black text-amber-500 mt-1">{{ $totalPending }}</div>
          <span class="text-xs text-slate-400 font-medium">Perlu konfirmasi / menunggu</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl font-bold">
          <i class="fa fa-clock-o"></i>
        </div>
      </div>

      <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
          <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Omzet Lunas</span>
          <div class="text-2xl font-black text-indigo-600 mt-1">Rp {{ number_format($totalNominalPaid, 0, ',', '.') }}</div>
          <span class="text-xs text-slate-400 font-medium">Dana masuk terverifikasi</span>
        </div>
        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl font-bold">
          <i class="fa fa-money"></i>
        </div>
      </div>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
        <div>
          <h3 class="text-xl font-bold text-slate-900">Daftar Transaksi Masuk</h3>
          <p class="text-xs text-slate-500 mt-0.5">Siswa yang melakukan pembayaran via QRIS atau Transfer Bank akan muncul di sini secara realtime.</p>
        </div>

        <form action="{{ url('/pembayaran/riwayat') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
          <select name="status" onchange="this.form.submit()" class="px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-xs font-bold text-slate-700 outline-none">
            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid (Lunas)</option>
          </select>

          <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID / Nama / Email..." class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs text-slate-800 placeholder-slate-400 outline-none w-52 sm:w-64">
          </div>
          <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs uppercase tracking-wider hover:bg-slate-800 transition">Cari</button>
        </form>
      </div>

      <div class="table-responsive mt-4">
        <table class="table table-hover align-middle" style="width: 100%;">
          <thead>
            <tr class="text-slate-500 text-xs font-bold uppercase tracking-wider bg-slate-50">
              <th style="padding: 14px 16px;">Order ID &amp; Waktu</th>
              <th style="padding: 14px 16px;">Siswa</th>
              <th style="padding: 14px 16px;">Paket</th>
              <th style="padding: 14px 16px;">Metode &amp; Total</th>
              <th style="padding: 14px 16px; text-align: center;">Status</th>
              <th style="padding: 14px 16px; text-align: center;">Token Terbit</th>
              <th style="padding: 14px 16px; text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-sm font-medium text-slate-800">
            @forelse($transaksis as $t)
              <tr class="hover:bg-slate-50/70 transition">
                <td style="padding: 14px 16px;">
                  <div class="font-mono font-bold text-slate-900 text-xs">{{ $t->order_id }}</div>
                  <div class="text-[11px] text-slate-400 mt-0.5">{{ $t->created_at->format('d M Y H:i') }}</div>
                </td>
                <td style="padding: 14px 16px;">
                  <div class="font-bold text-slate-900">{{ $t->user ? $t->user->nama : 'User #' . $t->id_user }}</div>
                  <div class="text-xs text-slate-500">{{ $t->user ? $t->user->email : '-' }}</div>
                </td>
                <td style="padding: 14px 16px;">
                  <div class="font-bold text-slate-800">{{ $t->nama_paket }}</div>
                  <div class="text-xs text-slate-400">{{ $t->durasi_bulan }} Bulan ({{ $t->durasi_hari }} Hari)</div>
                </td>
                <td style="padding: 14px 16px;">
                  <div class="font-black text-slate-900">{{ $t->formatted_total }}</div>
                  <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $t->metode == 'qris' ? 'bg-indigo-50 text-indigo-700 border border-indigo-200' : 'bg-slate-100 text-slate-700' }}">
                    {{ strtoupper($t->metode) }}
                  </span>
                </td>
                <td style="padding: 14px 16px; text-align: center;">
                  @if($t->status === 'PAID')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                      <i class="fa fa-check-circle"></i> Lunas
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                      <i class="fa fa-clock-o"></i> Menunggu
                    </span>
                  @endif
                </td>
                <td style="padding: 14px 16px; text-align: center;">
                  @if($t->kode_voucher)
                    <span class="font-mono font-bold text-xs bg-slate-100 text-indigo-700 px-2.5 py-1 rounded-lg border border-slate-200">
                      {{ $t->kode_voucher }}
                    </span>
                  @else
                    <span class="text-slate-400 text-xs italic">Belum terbit</span>
                  @endif
                </td>
                <td style="padding: 14px 16px; text-align: center;">
                  @if($t->status === 'PENDING')
                    <form action="{{ url('/pembayaran/konfirmasi-admin/' . $t->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa pembayaran dana sebesar {{ $t->formatted_total }} dari siswa ini sudah masuk? Token langganan akan otomatis aktif.');">
                      {{ csrf_field() }}
                      <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider shadow-sm transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fa fa-check"></i> Konfirmasi Lunas
                      </button>
                    </form>
                  @else
                    <span class="text-xs text-emerald-600 font-semibold flex items-center justify-center gap-1">
                      <i class="fa fa-check"></i> Terverifikasi
                    </span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-12 text-slate-400">
                  <i class="fa fa-inbox text-4xl mb-2 text-slate-300 block"></i>
                  <span>Belum ada transaksi pembayaran yang tercatat.</span>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="pt-4 border-t border-slate-100 flex justify-end">
        {{ $transaksis->links() }}
      </div>
    </div>

  </div>
</div>
@endsection
