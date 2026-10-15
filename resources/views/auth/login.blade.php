<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bank Soal &amp; Latihan CBT | Masuk Akun</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/dist/css/AdminLTE.min.css') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif !important;
      background: #0f172a !important;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
  </style>
</head>
<body class="bg-slate-900 text-slate-100">

<div class="w-full max-w-md mx-auto">
  <!-- Brand Header -->
  <div class="text-center mb-6">
    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-600 shadow-lg shadow-blue-500/20 text-white mb-3">
      <i class="fa fa-graduation-cap text-2xl"></i>
    </div>
    <h1 class="text-2xl font-black text-white tracking-tight">Portal Latihan &amp; Bank Soal</h1>
    <p class="text-sm text-slate-400 mt-1">Platform Evaluasi Belajar Kedinasan (SKD) &amp; UTBK-SNBT</p>
  </div>

  <!-- Login Card -->
  <div class="bg-white text-slate-900 rounded-3xl shadow-2xl p-7 sm:p-8 border border-slate-100">
    <h2 class="text-lg font-bold text-slate-900 mb-1">Masuk ke Akun</h2>
    <p class="text-xs text-slate-500 mb-5">Silakan masukkan email dan kata sandi Anda.</p>

    <form role="form" method="POST" action="{{ route('login') }}">
      {{ csrf_field() }}

      <div class="mb-4">
        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Alamat Email</label>
        <div class="relative">
          <input id="email" type="email" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-800 transition" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
        </div>
        @if ($errors->has('email'))
          <p class="text-xs text-red-600 mt-1 font-medium">{{ $errors->first('email') }}</p>
        @endif
      </div>

      <div class="mb-5">
        <div class="flex items-center justify-between mb-1.5">
          <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600">Kata Sandi</label>
          <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:underline font-semibold">Lupa Kata Sandi?</a>
        </div>
        <div class="relative">
          <input id="password" type="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-slate-800 transition" name="password" placeholder="••••••••" required>
        </div>
        @if ($errors->has('password'))
          <p class="text-xs text-red-600 mt-1 font-medium">{{ $errors->first('password') }}</p>
        @endif
      </div>

      <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-500/25 transition duration-150 flex items-center justify-center gap-2">
        <span>Masuk Sekarang</span>
        <i class="fa fa-arrow-right text-xs"></i>
      </button>

      <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
        <span>Belum memiliki akun?</span>
        <a href="/register" class="font-bold text-blue-600 hover:underline">Daftar Akun Baru</a>
      </div>
    </form>

    <!-- Demo Fast Fill Pills -->
    <div class="mt-6 pt-5 border-t border-slate-100">
      <div class="text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-2">Akun Demo Pengujian:</div>
      <div class="grid grid-cols-2 gap-2">
        <button type="button" onclick="fillDemo('admin@abdipraja.co.id', 'admin123')" class="px-3 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold text-left transition border border-slate-200">
          <div class="font-bold text-slate-900 flex items-center gap-1.5"><i class="fa fa-user-circle text-blue-600"></i> Admin / Guru</div>
          <div class="text-[10px] text-slate-600">admin@abdipraja.co.id</div>
        </button>
        <button type="button" onclick="fillDemo('chrisdamayantidesi012@gmail.com', 'siswa123')" class="px-3 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold text-left transition border border-slate-200">
          <div class="font-bold text-slate-900 flex items-center gap-1.5"><i class="fa fa-graduation-cap text-emerald-600"></i> Siswa / Peserta</div>
          <div class="text-[10px] text-slate-600">chrisdamayanti...</div>
        </button>
      </div>
    </div>
  </div>

  <div class="text-center mt-6 text-xs text-slate-400">
    &copy; {{ date('Y') }} Abdi Praja Edukasi &bull; Modul CBT &amp; Bank Soal Interaktif
  </div>
</div>

<script>
  function fillDemo(email, pass) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = pass;
  }
</script>
</body>
</html>
