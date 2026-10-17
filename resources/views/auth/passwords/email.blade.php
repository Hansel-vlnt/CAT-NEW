<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Latihan Soal Abdi Praja | Reset Kata Sandi</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/assets/plugins/sweetalert2-1.0.5/dist/sweetalert2.min.css') }}">
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

<div class="w-full max-w-lg mx-auto my-auto">
  <!-- Brand Header -->
  <div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white shadow-xl p-2 mb-3 border border-slate-700/50">
      <img src="{{ url('/assets/dist/img/logo.jpg') }}" alt="Logo Abdi Praja Edukasi" class="w-full h-full object-contain rounded-xl">
    </div>
    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Latihan Soal Abdi Praja</h1>
    <p class="text-sm text-slate-400 mt-1">Pemulihan Akses Akun &amp; Kata Sandi</p>
  </div>

  <!-- Card -->
  <div class="bg-white text-slate-900 rounded-3xl shadow-2xl p-8 sm:p-10 border border-slate-100">
    <h2 class="text-xl font-black text-slate-900 mb-1">Lupa Kata Sandi?</h2>
    <p class="text-sm text-slate-500 mb-6">Masukkan email yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>

    <form role="form" method="POST" action="{{ route('password.email') }}">
      {{ csrf_field() }}

      <div class="mb-5">
        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Alamat Email Terdaftar</label>
        <input id="email" type="email" class="w-full px-4 py-3.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 text-base text-slate-900 transition font-medium" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
        @if ($errors->has('email'))
          <p class="text-xs text-red-600 mt-1.5 font-semibold">{{ $errors->first('email') }}</p>
        @endif
      </div>

      <button type="submit" class="w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base shadow-lg shadow-indigo-600/30 transition duration-150 flex items-center justify-center gap-2">
        <span>Kirim Tautan Reset Password</span>
        <i class="fa fa-paper-plane text-sm"></i>
      </button>

      <div class="mt-6 pt-5 border-t border-slate-100 text-center">
        <a href="{{ route('login') }}" class="text-sm font-bold text-indigo-600 hover:underline inline-flex items-center gap-1.5">
          <i class="fa fa-arrow-left text-xs"></i>
          <span>Kembali ke Halaman Masuk</span>
        </a>
      </div>
    </form>
  </div>

  <div class="text-center mt-6 text-xs text-slate-400">
    &copy; 2026 Latihan Soal Abdi Praja &bull; Hak cipta dilindungi undang-undang.
  </div>
</div>

<script src="{{ url('/assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script src="{{ url('/assets/plugins/sweetalert2-1.0.5/dist/sweetalert2.min.js') }}"></script>
@if(Session::has('status'))
<script>
    swal("", '{!! Session::get("status") !!}', "success");
</script>
@endif
</body>
</html>