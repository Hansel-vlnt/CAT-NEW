<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Latihan Soal Abdi Praja | Pendaftaran Akun</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
      background-color: #0f172a !important;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 16px;
    }
  </style>
</head>
<body class="bg-slate-900 text-slate-100">

<div class="w-full max-w-xl mx-auto my-auto">
  <!-- Brand Header -->
  <div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white shadow-xl p-2 mb-3 border border-slate-700/50">
      <img src="{{ url('/assets/dist/img/logo.jpg') }}" alt="Logo Abdi Praja Edukasi" class="w-full h-full object-contain rounded-xl">
    </div>
    <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">Latihan Soal Abdi Praja</h1>
    <p class="text-sm sm:text-base text-slate-400 mt-2">Daftar Akun Baru untuk Memulai Simulasi Ujian CAT &amp; Latihan Soal</p>
  </div>

  <!-- Register Card -->
  <div class="bg-white text-slate-900 rounded-3xl shadow-2xl p-8 sm:p-10 border border-slate-100">
    <h2 class="text-2xl font-black text-slate-900 mb-1">Pendaftaran Peserta</h2>
    <p class="text-sm text-slate-500 mb-6">Lengkapi data diri Anda di bawah ini untuk membuat akun baru.</p>

    <form role="form" method="POST" action="{{ route('register') }}">
      {{ csrf_field() }}

      <div class="mb-4">
        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Nama Lengkap</label>
        <input id="name" type="text" class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 text-base text-slate-900 transition font-medium" name="name" placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required autofocus>
        @if ($errors->has('name'))
          <p class="text-xs text-red-600 mt-1 font-semibold">{{ $errors->first('name') }}</p>
        @endif
      </div>

      <div class="mb-4">
        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Alamat Email</label>
        <input id="email" type="email" class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 text-base text-slate-900 transition font-medium" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
          <p class="text-xs text-red-600 mt-1 font-semibold">{{ $errors->first('email') }}</p>
        @endif
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div>
          <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Kata Sandi</label>
          <input id="password" type="password" class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 text-base text-slate-900 transition font-medium" name="password" placeholder="Minimal 6 karakter" required>
          @if ($errors->has('password'))
            <p class="text-xs text-red-600 mt-1 font-semibold">{{ $errors->first('password') }}</p>
          @endif
        </div>

        <div>
          <label for="password-confirm" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Ulangi Kata Sandi</label>
          <input id="password-confirm" type="password" class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 text-base text-slate-900 transition font-medium" name="password_confirmation" placeholder="Ulangi kata sandi" required>
        </div>
      </div>

      <button type="submit" class="w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base shadow-lg shadow-indigo-600/30 transition duration-150 flex items-center justify-center gap-2">
        <span>Daftar Akun Sekarang</span>
        <i class="fa fa-arrow-right"></i>
      </button>

      <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between text-sm text-slate-500">
        <span>Sudah memiliki akun?</span>
        <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:underline">Masuk ke Akun</a>
      </div>
    </form>
  </div>

  <div class="text-center mt-6 text-xs text-slate-400">
    &copy; 2026 Latihan Soal Abdi Praja &bull; Hak cipta dilindungi undang-undang.
  </div>
</div>

</body>
</html>
