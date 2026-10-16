<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Latihan Soal Abdi Praja | Pendaftaran Berhasil</title>
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

<div class="w-full max-w-md mx-auto my-auto text-center">
  <div class="bg-white text-slate-900 rounded-3xl shadow-2xl p-8 sm:p-10 border border-slate-100">
    <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-5 text-3xl font-black">
      <i class="fa fa-check"></i>
    </div>

    <h2 class="text-2xl font-black text-slate-900 mb-2">Pendaftaran Berhasil!</h2>
    <p class="text-sm text-slate-600 leading-relaxed mb-8">
      Akun Anda telah berhasil dibuat di platform <b>Latihan Soal Abdi Praja</b>. Silakan masuk untuk memulai latihan soal dan simulasi CBT.
    </p>

    <a href="{{ route('login') }}" class="w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base shadow-lg shadow-indigo-600/30 transition duration-150 flex items-center justify-center gap-2">
      <span>Masuk ke Akun Sekarang</span>
      <i class="fa fa-arrow-right"></i>
    </a>
  </div>

  <div class="mt-6 text-xs text-slate-400">
    &copy; 2026 Latihan Soal Abdi Praja
  </div>
</div>

</body>
</html>
