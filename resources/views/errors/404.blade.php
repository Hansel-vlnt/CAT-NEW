<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Halaman Tidak Ditemukan | Latihan Soal Abdi Praja</title>
  <link rel="icon" href="{{ url('/assets/dist/img/logo.jpg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('assets/font-awesome/css/font-awesome.min.css') }}">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
      background-color: #f8fafc;
      color: #0f172a;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
    }
    .card-404 {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 28px;
      box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.07);
      padding: 48px 36px;
      max-width: 540px;
      width: 100%;
      text-align: center;
    }
    .badge-code {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 88px;
      height: 88px;
      border-radius: 24px;
      background: #fffbeb;
      border: 1px solid #fde68a;
      color: #d97706;
      font-size: 32px;
      font-weight: 800;
      margin-bottom: 24px;
      box-shadow: 0 4px 6px -1px rgba(217, 119, 6, 0.08);
    }
    h1 {
      font-size: 24px;
      font-weight: 800;
      color: #0f172a;
      margin-bottom: 10px;
      letter-spacing: -0.5px;
    }
    p {
      font-size: 14.5px;
      line-height: 1.65;
      color: #64748b;
      margin-bottom: 32px;
    }
    .actions {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      justify-content: center;
    }
    .btn-main {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #2563eb;
      color: #ffffff !important;
      font-weight: 700;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 14px 28px;
      border-radius: 14px;
      text-decoration: none !important;
      transition: all 0.2s ease;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
    .btn-main:hover {
      background: #1d4ed8;
      transform: translateY(-1px);
    }
    .btn-secondary {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #f1f5f9;
      color: #334155 !important;
      font-weight: 700;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 14px 24px;
      border-radius: 14px;
      border: none;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .btn-secondary:hover {
      background: #e2e8f0;
      color: #0f172a !important;
    }
    .footer-brand {
      margin-top: 32px;
      font-size: 12px;
      color: #94a3b8;
    }
  </style>
</head>
<body>
  <div class="card-404">
    <div class="badge-code">
      404
    </div>
    <h1>Halaman Tidak Ditemukan</h1>
    <p>
      Halaman atau materi ujian yang Anda tuju mungkin telah dipindahkan, sedang dalam penyusunan, atau alamat URL yang Anda masukkan keliru.
    </p>
    <div class="actions">
      <a href="{{ url('/') }}" class="btn-main">
        <i class="fa fa-home"></i> Kembali ke Beranda
      </a>
      <button onclick="window.history.back()" class="btn-secondary">
        <i class="fa fa-arrow-left"></i> Halaman Sebelumnya
      </button>
    </div>
    <div class="footer-brand">
      &copy; {{ date('Y') }} Abdi Praja Edukasi &bull; Platform CBT Terpadu
    </div>
  </div>
</body>
</html>
