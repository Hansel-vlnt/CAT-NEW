<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Latihan Soal Abdi Praja | Masuk Akun</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="{{ url('/assets/img/favicon.jpg') }}" type="image/x-icon"/>
  <style>
    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
      background: #0f172a !important;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px 16px;
      -webkit-font-smoothing: antialiased;
      font-size: 16.5px !important;
    }
    .text-xs { font-size: 13.5px !important; line-height: 1.5 !important; }
    .text-sm { font-size: 15.5px !important; line-height: 1.55 !important; }
    .text-base { font-size: 17.5px !important; line-height: 1.6 !important; }
    .text-lg { font-size: 20px !important; line-height: 1.45 !important; }
    .text-xl { font-size: 24px !important; line-height: 1.35 !important; }
    .text-2xl { font-size: 28px !important; line-height: 1.3 !important; }
    .text-3xl { font-size: 34px !important; line-height: 1.25 !important; }
    .text-4xl { font-size: 40px !important; line-height: 1.2 !important; }
  </style>
</head>
<body class="bg-slate-900 text-slate-100">

<div class="w-full max-w-xl mx-auto py-6">
  <!-- Brand Header -->
  <div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-indigo-600 shadow-xl shadow-indigo-500/25 text-white mb-4 border border-indigo-400/30">
      <i class="fa fa-graduation-cap text-4xl"></i>
    </div>
    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Latihan Soal Abdi Praja</h1>
    <p class="text-base sm:text-lg text-slate-300 mt-2 max-w-md mx-auto leading-relaxed">
      Sistem Simulasi Computer Assisted Test (CAT) untuk Seleksi Kedinasan (SKD), CPNS, dan UTBK-SNBT
    </p>
  </div>

  <!-- Grand Login Card -->
  <div class="bg-white text-slate-900 rounded-3xl shadow-2xl p-8 sm:p-10 border border-slate-200">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Masuk ke Akun Anda</h2>
      <p class="text-base text-slate-500 mt-1">Gunakan alamat email dan kata sandi yang telah terdaftar.</p>
    </div>

    <form role="form" method="POST" action="{{ route('login') }}" class="space-y-6">
      {{ csrf_field() }}

      <div>
        <label for="email" class="block text-base font-bold text-slate-800 mb-2">Alamat Email</label>
        <div class="relative">
          <input id="email" type="email" class="w-full h-[54px] px-4 rounded-xl border border-slate-300 focus:outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 text-lg text-slate-900 transition" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
        </div>
        @if ($errors->has('email'))
          <p class="text-sm text-red-600 mt-1.5 font-medium flex items-center gap-1.5">
            <i class="fa fa-exclamation-circle text-sm"></i>
            {{ $errors->first('email') }}
          </p>
        @endif
      </div>

      <div>
        <div class="flex items-center justify-between mb-2">
          <label for="password" class="block text-base font-bold text-slate-800">Kata Sandi</label>
          <a href="{{ route('password.request') }}" class="text-base text-indigo-600 hover:text-indigo-800 font-bold hover:underline">Lupa Kata Sandi?</a>
        </div>
        <div class="relative">
          <input id="password" type="password" class="w-full h-[54px] px-4 rounded-xl border border-slate-300 focus:outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-100 text-lg text-slate-900 transition" name="password" placeholder="••••••••" required>
        </div>
        @if ($errors->has('password'))
          <p class="text-sm text-red-600 mt-1.5 font-medium flex items-center gap-1.5">
            <i class="fa fa-exclamation-circle text-sm"></i>
            {{ $errors->first('password') }}
          </p>
        @endif
      </div>

      <div class="pt-2">
        <button type="submit" class="w-full h-[56px] rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-bold text-lg shadow-lg shadow-indigo-500/25 transition duration-150 flex items-center justify-center gap-2 cursor-pointer">
          <span>Masuk Sekarang</span>
          <i class="fa fa-arrow-right text-base"></i>
        </button>
      </div>

      <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-base text-slate-600">
        <span>Belum memiliki akun?</span>
        <a href="/register" class="font-bold text-indigo-600 hover:text-indigo-800 hover:underline">Daftar Akun Baru</a>
      </div>
    </form>

    <!-- Demo Fast Fill Pills -->
    <div class="mt-8 pt-6 border-t border-slate-200">
      <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Akses Cepat Akun Demo (Uji Coba):</div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <button type="button" onclick="fillDemo('admin@abdipraja.co.id', 'admin123')" class="px-4 py-3 rounded-xl bg-slate-50 hover:bg-indigo-50 hover:border-indigo-300 text-left transition border border-slate-200 group">
          <div class="font-bold text-slate-900 text-base flex items-center gap-2">
            <span class="w-6 h-6 rounded-md bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs group-hover:bg-indigo-600 group-hover:text-white transition">
              <i class="fa fa-user-shield"></i>
            </span>
            <span>Admin / Guru</span>
          </div>
          <div class="text-sm text-slate-500 mt-1 font-mono">admin@abdipraja.co.id</div>
        </button>
        <button type="button" onclick="fillDemo('chrisdamayantidesi012@gmail.com', 'siswa123')" class="px-4 py-3 rounded-xl bg-slate-50 hover:bg-emerald-50 hover:border-emerald-300 text-left transition border border-slate-200 group">
          <div class="font-bold text-slate-900 text-base flex items-center gap-2">
            <span class="w-6 h-6 rounded-md bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs group-hover:bg-emerald-600 group-hover:text-white transition">
              <i class="fa fa-graduation-cap"></i>
            </span>
            <span>Siswa / Peserta</span>
          </div>
          <div class="text-sm text-slate-500 mt-1 font-mono truncate">chrisdamayantidesi012...</div>
        </button>
      </div>
    </div>
  </div>

  <div class="text-center mt-8 text-base text-slate-400">
    &copy; {{ date('Y') }} <strong>Latihan Soal Abdi Praja</strong> &bull; Bank Soal &amp; Simulasi Ujian Terpadu
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
