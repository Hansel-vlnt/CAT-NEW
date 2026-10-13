<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/api/user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::rzDUqcbqlRSp4oUV',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::O2TOAbtk2iO0Aw9C',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::J1eBGJMtgnaqJ4En',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tp3jLdKBczmJllDv',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password/reset' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.request',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password/email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register/success' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'register.success',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/vouchers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'vouchers',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'vouchers.save',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'vouchers.delete',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'home.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/home' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'home',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/simpan-soal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Or8tArJLndSJc1wI',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/update-profil' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jAVKFAy5NcmabPSB',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/simpan-materi' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::KFVBUKCVkwaMQoqT',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/terbit-soal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::KJCPS9Wza47Zzw3S',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/simpan-detail-soal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::x3TmWSUVgkqQCcFw',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/simpan-detail-soal-via-excel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xQVogaYn89xVNIim',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/simpan-gambar-materi' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::zWrteoJzu5NOrAbz',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/hapus-gambar-materi' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DQlIMydEFn7LGKTt',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/simpan-gambar-user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2AgvruafT0cVGnez',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/update-profil-sekolah' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5DC6ThXQAeLiezss',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/simpan-guru' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1T0pdFgTSted7DIE',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/simpan-siswa' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::IB6uychKhw6H0eGc',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/update-siswa' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::rknrFVm4UNoaAGvI',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/simpan-siswa-via-excel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::AmD2GoUTbf2o93dq',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/update-img-siswa' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::6hgGpMcyGztWUmbU',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/delete-siswa' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Xr3loWe0lVFmP8B8',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/update-guru' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Tnv7sgGYrtts0jC2',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/delete-guru' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::yHm2ew2HdSP0Cvxw',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/simpan-kelas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::O0DAtkaF2St2mC05',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/delete-kelas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GxbKCsKaZKrIBpbt',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/reset-ujian' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YMKzfFE9Cwc7zUkD',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crud/aktivasi' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'aktivasi',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/pengaturan' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pengaturan',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/guru' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.guru',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/guru/data-guru' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.data_guru',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/kelas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.kelas',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/data-kelas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.data_kelas',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/detail-kelas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.detail_kelas_siswa',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/siswa' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'siswa',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/siswa/data-siswa' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.data_siswa',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/siswa/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kLO5HYzIMvVozJ8V',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/master/siswa/delete-all' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::n0JFvNz0nQiKvb8j',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/materi' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.materi',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/materi/get-materi-guru' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.dataMateriGuru',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/laporan' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.laporan',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/laporan/data-paket-soal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.laporan.data_paket_soal',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/laporan/data-kelas-paket-soal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.laporan.data_kelas_paket_soal',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/laporan/hasil-siswa' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.hasilSiswa',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/soal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'soal',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'soal.hapus',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/soal/paket-soal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'soal.paket.hapus',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/soal/get-soal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.get-soal',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/soal/get-soal-home' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.get-soal-home',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/soal/get-detail-soal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.get-detail-soal',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/soal/essay/data' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::qeDnxrNmbuDhO6Ve',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/soal/essay/simpan-score' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::APjXioUBj6wNSklL',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/soal/essay' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'essay.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'essay.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/elearning/soal/essay/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'essay.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/activity' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vFk7QPkRzdxcgzhX',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/siswa/data-materi' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'siswa.materi',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/siswa/materi' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::IzTePdrMIwclUJgn',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/siswa/ujian' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::K7JwY1oR3PrNtc8m',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/siswa/ujian/get-detail-essay' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::c37gGl5t20nZnMrq',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/siswa/ujian/simpan-jawaban-essay' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DM7BFVbbNgT2p7cg',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/siswa/ujian/get-soal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::t9LMexpdpGUjlhPR',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/siswa/ujian/jawab' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::clVssiT7qEYwHCgc',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/siswa/ujian/kirim-jawaban' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wLdEVk9yrMK6REi6',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/siswa/ujian/hapus-jawaban' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lLIaZVezH6iyY7Gs',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/password/reset/([^/]++)(*:31)|/master/(?|guru/(?|detail/([^/]++)(*:72)|ubah/([^/]++)(*:92))|kelas/(?|detail/([^/]++)(*:124)|ubah/([^/]++)(*:145))|siswa/(?|detail/([^/]++)(*:178)|edit/([^/]++)(*:199)|get\\-btn\\-delete/([^/]++)(*:232)))|/elearning/(?|materi/(?|detail/([^/]++)(*:281)|ubah/([^/]++)(*:302))|laporan/(?|paket/([^/]++)(*:336)|detail\\-kelas/([^/]++)(?|(*:369)|/paket\\-soal/([^/]++)(*:398))|([^/]++)/([^/]++)(*:424))|soal/(?|ubah/([^/]++)(*:454)|detail/(?|([^/]++)(*:480)|ubah/([^/]++)(*:501)|data\\-soal/([^/]++)(*:528))|essay/([^/]++)(?|(*:554)|/edit(*:567)|(*:575))))|/download\\-file\\-format/([^/]++)(*:618)|/cetak/(?|excel/hasil\\-ujian\\-perkelas/([^/]++)(*:673)|pdf/hasil\\-ujian\\-persiswa/([^/]++)/([^/]++)(*:725))|/siswa/(?|materi/detail/([^/]++)(*:766)|ujian/(?|detail/([^/]++)(?|(?:/([^/]++))?(*:815)|(*:823))|finish/([^/]++)(*:847))))/?$}sDu',
    ),
    3 => 
    array (
      31 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.reset',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      72 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kCilzmGhg85q7DHi',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      92 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::QvkFRi6xkyMV4k2H',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      124 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.detail_kelas',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      145 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'master.ubah_kelas',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      178 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OPJXd0W2Y4lfUBst',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      199 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::r35ZXee6NE76cXwD',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      232 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::W5bfF5cKZt1XFXOa',
          ),
          1 => 
          array (
            0 => 'password',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      281 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.detailMateri',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      302 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.detailubahMateri',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      336 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::JYC9DfX3FasndFMG',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      369 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.laporan.detailKelas',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      398 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kQXjanCfmxREYHJR',
          ),
          1 => 
          array (
            0 => 'id_kelas',
            1 => 'id_soal',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      424 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.detailLaporanSiswa',
          ),
          1 => 
          array (
            0 => 'id_soal',
            1 => 'id_user',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      454 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'soal.ubah',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      480 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.detail-soal',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      501 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.ubah-detail-soal',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      528 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'elearning.detail-data-soal',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      554 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'essay.show',
          ),
          1 => 
          array (
            0 => 'essay',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      567 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'essay.edit',
          ),
          1 => 
          array (
            0 => 'essay',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      575 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'essay.update',
          ),
          1 => 
          array (
            0 => 'essay',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'essay.destroy',
          ),
          1 => 
          array (
            0 => 'essay',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      618 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'download',
          ),
          1 => 
          array (
            0 => 'filename',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      673 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5MYld7x1coN3mIyv',
          ),
          1 => 
          array (
            0 => 'soal',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      725 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::v4uX5YMMooILzyos',
          ),
          1 => 
          array (
            0 => 'siswa',
            1 => 'soal',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      766 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OF8lZV9gR0TJC6YF',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      815 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'siswa.ujian',
            'key' => NULL,
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'key',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      823 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::oO3q98ATZvMiNHyM',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      847 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::aZNBM5yn2qIsLo26',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'generated::rzDUqcbqlRSp4oUV' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:api',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:295:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:77:"function (\\Illuminate\\Http\\Request $request) {
    return $request->user();
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000006f20000000000000000";}";s:4:"hash";s:44:"7UaGxiqJ4BXh2WUw0zpkTnK8JwumvNdjxp8DSsyrgNU=";}}',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::rzDUqcbqlRSp4oUV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\LoginController@showLoginForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\LoginController@showLoginForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::O2TOAbtk2iO0Aw9C' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\LoginController@login',
        'controller' => 'App\\Http\\Controllers\\Auth\\LoginController@login',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::O2TOAbtk2iO0Aw9C',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\LoginController@logout',
        'controller' => 'App\\Http\\Controllers\\Auth\\LoginController@logout',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisterController@showRegistrationForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisterController@showRegistrationForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tp3jLdKBczmJllDv' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisterController@register',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisterController@register',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::tp3jLdKBczmJllDv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.request' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'password/reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showLinkRequestForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showLinkRequestForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.request',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'password/email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@sendResetLinkEmail',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@sendResetLinkEmail',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'password/reset/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@showResetForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@showResetForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'password/reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@reset',
        'controller' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@reset',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::J1eBGJMtgnaqJ4En' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\App\\Http\\Controllers\\Auth\\LoginController@logout',
        'controller' => '\\App\\Http\\Controllers\\Auth\\LoginController@logout',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::J1eBGJMtgnaqJ4En',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register.success' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'register/success',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisterController@registerSuccess',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisterController@registerSuccess',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register.success',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'vouchers' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'vouchers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@vouchers',
        'controller' => 'App\\Http\\Controllers\\HomeController@vouchers',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'vouchers',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'vouchers.save' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'vouchers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@vouchers_save',
        'controller' => 'App\\Http\\Controllers\\HomeController@vouchers_save',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'vouchers.save',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'vouchers.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'vouchers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@vouchers_delete',
        'controller' => 'App\\Http\\Controllers\\HomeController@vouchers_delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'vouchers.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'home.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@index',
        'controller' => 'App\\Http\\Controllers\\HomeController@index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'home.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'home',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@index',
        'controller' => 'App\\Http\\Controllers\\HomeController@index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'home',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Or8tArJLndSJc1wI' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/simpan-soal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@simpanSoal',
        'controller' => 'App\\Http\\Controllers\\SoalController@simpanSoal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::Or8tArJLndSJc1wI',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jAVKFAy5NcmabPSB' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/update-profil',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@updateProfil',
        'controller' => 'App\\Http\\Controllers\\CrudController@updateProfil',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::jAVKFAy5NcmabPSB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::KFVBUKCVkwaMQoqT' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/simpan-materi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@simpanMateri',
        'controller' => 'App\\Http\\Controllers\\CrudController@simpanMateri',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::KFVBUKCVkwaMQoqT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::KJCPS9Wza47Zzw3S' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/terbit-soal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@terbitSoal',
        'controller' => 'App\\Http\\Controllers\\CrudController@terbitSoal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::KJCPS9Wza47Zzw3S',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::x3TmWSUVgkqQCcFw' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/simpan-detail-soal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@simpanDetailSoal',
        'controller' => 'App\\Http\\Controllers\\SoalController@simpanDetailSoal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::x3TmWSUVgkqQCcFw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xQVogaYn89xVNIim' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/simpan-detail-soal-via-excel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@simpanDetailSoalExcel',
        'controller' => 'App\\Http\\Controllers\\SoalController@simpanDetailSoalExcel',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::xQVogaYn89xVNIim',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::zWrteoJzu5NOrAbz' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/simpan-gambar-materi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@simpanGambarMateri',
        'controller' => 'App\\Http\\Controllers\\CrudController@simpanGambarMateri',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::zWrteoJzu5NOrAbz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DQlIMydEFn7LGKTt' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/hapus-gambar-materi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@hapusGambarMateri',
        'controller' => 'App\\Http\\Controllers\\CrudController@hapusGambarMateri',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::DQlIMydEFn7LGKTt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2AgvruafT0cVGnez' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/simpan-gambar-user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@simpanGambarUser',
        'controller' => 'App\\Http\\Controllers\\CrudController@simpanGambarUser',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::2AgvruafT0cVGnez',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5DC6ThXQAeLiezss' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/update-profil-sekolah',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@updateProfilSekolah',
        'controller' => 'App\\Http\\Controllers\\CrudController@updateProfilSekolah',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::5DC6ThXQAeLiezss',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1T0pdFgTSted7DIE' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/simpan-guru',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GuruController@simpanGuru',
        'controller' => 'App\\Http\\Controllers\\GuruController@simpanGuru',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::1T0pdFgTSted7DIE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::IB6uychKhw6H0eGc' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/simpan-siswa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@simpanSiswa',
        'controller' => 'App\\Http\\Controllers\\CrudController@simpanSiswa',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::IB6uychKhw6H0eGc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::rknrFVm4UNoaAGvI' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/update-siswa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@updateSiswa',
        'controller' => 'App\\Http\\Controllers\\CrudController@updateSiswa',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::rknrFVm4UNoaAGvI',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::AmD2GoUTbf2o93dq' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/simpan-siswa-via-excel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@simpanSiswaViaExcel',
        'controller' => 'App\\Http\\Controllers\\CrudController@simpanSiswaViaExcel',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::AmD2GoUTbf2o93dq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::6hgGpMcyGztWUmbU' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/update-img-siswa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@updateImgSiswa',
        'controller' => 'App\\Http\\Controllers\\CrudController@updateImgSiswa',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::6hgGpMcyGztWUmbU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Xr3loWe0lVFmP8B8' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/delete-siswa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@deleteSiswa',
        'controller' => 'App\\Http\\Controllers\\CrudController@deleteSiswa',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::Xr3loWe0lVFmP8B8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Tnv7sgGYrtts0jC2' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/update-guru',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@updateGuru',
        'controller' => 'App\\Http\\Controllers\\CrudController@updateGuru',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::Tnv7sgGYrtts0jC2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::yHm2ew2HdSP0Cvxw' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/delete-guru',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@deleteGuru',
        'controller' => 'App\\Http\\Controllers\\CrudController@deleteGuru',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::yHm2ew2HdSP0Cvxw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::O0DAtkaF2St2mC05' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/simpan-kelas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@simpanKelas',
        'controller' => 'App\\Http\\Controllers\\CrudController@simpanKelas',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::O0DAtkaF2St2mC05',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GxbKCsKaZKrIBpbt' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/delete-kelas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@deleteKelas',
        'controller' => 'App\\Http\\Controllers\\CrudController@deleteKelas',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::GxbKCsKaZKrIBpbt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YMKzfFE9Cwc7zUkD' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/reset-ujian',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@resetUjian',
        'controller' => 'App\\Http\\Controllers\\CrudController@resetUjian',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'generated::YMKzfFE9Cwc7zUkD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'aktivasi' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'crud/aktivasi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CrudController@aktivasi',
        'controller' => 'App\\Http\\Controllers\\CrudController@aktivasi',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/crud',
        'where' => 
        array (
        ),
        'as' => 'aktivasi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pengaturan' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'pengaturan',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@pengaturan',
        'controller' => 'App\\Http\\Controllers\\HomeController@pengaturan',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/pengaturan',
        'where' => 
        array (
        ),
        'as' => 'pengaturan',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.guru' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/guru',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GuruController@index',
        'controller' => 'App\\Http\\Controllers\\GuruController@index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'master/guru',
        'where' => 
        array (
        ),
        'as' => 'master.guru',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.data_guru' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/guru/data-guru',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GuruController@dataGuru',
        'controller' => 'App\\Http\\Controllers\\GuruController@dataGuru',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'master/guru',
        'where' => 
        array (
        ),
        'as' => 'master.data_guru',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kCilzmGhg85q7DHi' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/guru/detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GuruController@detailGuru',
        'controller' => 'App\\Http\\Controllers\\GuruController@detailGuru',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'master/guru',
        'where' => 
        array (
        ),
        'as' => 'generated::kCilzmGhg85q7DHi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::QvkFRi6xkyMV4k2H' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/guru/ubah/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GuruController@ubahGuru',
        'controller' => 'App\\Http\\Controllers\\GuruController@ubahGuru',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'master/guru',
        'where' => 
        array (
        ),
        'as' => 'generated::QvkFRi6xkyMV4k2H',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.kelas' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/kelas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\KelasController@index',
        'controller' => 'App\\Http\\Controllers\\KelasController@index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.kelas',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.data_kelas' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/data-kelas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\KelasController@dataKelas',
        'controller' => 'App\\Http\\Controllers\\KelasController@dataKelas',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.data_kelas',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.detail_kelas' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/kelas/detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\KelasController@detailKelas',
        'controller' => 'App\\Http\\Controllers\\KelasController@detailKelas',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.detail_kelas',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.detail_kelas_siswa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/detail-kelas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\KelasController@detailKelasSiswa',
        'controller' => 'App\\Http\\Controllers\\KelasController@detailKelasSiswa',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.detail_kelas_siswa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.ubah_kelas' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/kelas/ubah/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\KelasController@ubahKelas',
        'controller' => 'App\\Http\\Controllers\\KelasController@ubahKelas',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/master',
        'where' => 
        array (
        ),
        'as' => 'master.ubah_kelas',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'siswa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/siswa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@index',
        'controller' => 'App\\Http\\Controllers\\SiswaController@index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'master/siswa',
        'where' => 
        array (
        ),
        'as' => 'siswa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'master.data_siswa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/siswa/data-siswa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@dataSiswa',
        'controller' => 'App\\Http\\Controllers\\SiswaController@dataSiswa',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'master/siswa',
        'where' => 
        array (
        ),
        'as' => 'master.data_siswa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OPJXd0W2Y4lfUBst' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/siswa/detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@detailSiswa',
        'controller' => 'App\\Http\\Controllers\\SiswaController@detailSiswa',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'master/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::OPJXd0W2Y4lfUBst',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::r35ZXee6NE76cXwD' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/siswa/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@editSiswa',
        'controller' => 'App\\Http\\Controllers\\SiswaController@editSiswa',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'master/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::r35ZXee6NE76cXwD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kLO5HYzIMvVozJ8V' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/siswa/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@delete',
        'controller' => 'App\\Http\\Controllers\\SiswaController@delete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'master/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::kLO5HYzIMvVozJ8V',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::W5bfF5cKZt1XFXOa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/siswa/get-btn-delete/{password}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@getBtnDelete',
        'controller' => 'App\\Http\\Controllers\\SiswaController@getBtnDelete',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'master/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::W5bfF5cKZt1XFXOa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::n0JFvNz0nQiKvb8j' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'master/siswa/delete-all',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@deleteAll',
        'controller' => 'App\\Http\\Controllers\\SiswaController@deleteAll',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'master/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::n0JFvNz0nQiKvb8j',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.materi' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/materi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\MateriController@index',
        'controller' => 'App\\Http\\Controllers\\MateriController@index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/materi',
        'where' => 
        array (
        ),
        'as' => 'elearning.materi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.dataMateriGuru' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/materi/get-materi-guru',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\MateriController@dataMateriGuru',
        'controller' => 'App\\Http\\Controllers\\MateriController@dataMateriGuru',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/materi',
        'where' => 
        array (
        ),
        'as' => 'elearning.dataMateriGuru',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.detailMateri' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/materi/detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\MateriController@detail',
        'controller' => 'App\\Http\\Controllers\\MateriController@detail',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/materi',
        'where' => 
        array (
        ),
        'as' => 'elearning.detailMateri',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.detailubahMateri' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/materi/ubah/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\MateriController@ubah',
        'controller' => 'App\\Http\\Controllers\\MateriController@ubah',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/materi',
        'where' => 
        array (
        ),
        'as' => 'elearning.detailubahMateri',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.laporan' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/laporan',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LaporanController@index',
        'controller' => 'App\\Http\\Controllers\\LaporanController@index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/laporan',
        'where' => 
        array (
        ),
        'as' => 'elearning.laporan',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::JYC9DfX3FasndFMG' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/laporan/paket/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LaporanController@laporanPerPaket',
        'controller' => 'App\\Http\\Controllers\\LaporanController@laporanPerPaket',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/laporan',
        'where' => 
        array (
        ),
        'as' => 'generated::JYC9DfX3FasndFMG',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.laporan.detailKelas' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/laporan/detail-kelas/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LaporanController@detailKelas',
        'controller' => 'App\\Http\\Controllers\\LaporanController@detailKelas',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/laporan',
        'where' => 
        array (
        ),
        'as' => 'elearning.laporan.detailKelas',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.laporan.data_paket_soal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/laporan/data-paket-soal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LaporanController@data_paket_soal',
        'controller' => 'App\\Http\\Controllers\\LaporanController@data_paket_soal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/laporan',
        'where' => 
        array (
        ),
        'as' => 'elearning.laporan.data_paket_soal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kQXjanCfmxREYHJR' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/laporan/detail-kelas/{id_kelas}/paket-soal/{id_soal}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LaporanController@detailPaketSoalPerKelas',
        'controller' => 'App\\Http\\Controllers\\LaporanController@detailPaketSoalPerKelas',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/laporan',
        'where' => 
        array (
        ),
        'as' => 'generated::kQXjanCfmxREYHJR',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.laporan.data_kelas_paket_soal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/laporan/data-kelas-paket-soal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LaporanController@dataKelasPaketSoal',
        'controller' => 'App\\Http\\Controllers\\LaporanController@dataKelasPaketSoal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/laporan',
        'where' => 
        array (
        ),
        'as' => 'elearning.laporan.data_kelas_paket_soal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.detailLaporanSiswa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/laporan/{id_soal}/{id_user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LaporanController@detailLaporanSiswa',
        'controller' => 'App\\Http\\Controllers\\LaporanController@detailLaporanSiswa',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/laporan',
        'where' => 
        array (
        ),
        'as' => 'elearning.detailLaporanSiswa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.hasilSiswa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/laporan/hasil-siswa',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LaporanController@hasilSiswa',
        'controller' => 'App\\Http\\Controllers\\LaporanController@hasilSiswa',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/laporan',
        'where' => 
        array (
        ),
        'as' => 'elearning.hasilSiswa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'soal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@index',
        'controller' => 'App\\Http\\Controllers\\SoalController@index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal',
        'where' => 
        array (
        ),
        'as' => 'soal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'soal.paket.hapus' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'elearning/soal/paket-soal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@deletePaketSoal',
        'controller' => 'App\\Http\\Controllers\\SoalController@deletePaketSoal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal',
        'where' => 
        array (
        ),
        'as' => 'soal.paket.hapus',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'soal.hapus' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'elearning/soal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@deleteSoal',
        'controller' => 'App\\Http\\Controllers\\SoalController@deleteSoal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal',
        'where' => 
        array (
        ),
        'as' => 'soal.hapus',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'soal.ubah' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/ubah/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@ubahSoal',
        'controller' => 'App\\Http\\Controllers\\SoalController@ubahSoal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal',
        'where' => 
        array (
        ),
        'as' => 'soal.ubah',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.detail-soal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@detail',
        'controller' => 'App\\Http\\Controllers\\SoalController@detail',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal',
        'where' => 
        array (
        ),
        'as' => 'elearning.detail-soal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.get-soal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/get-soal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@dataSoal',
        'controller' => 'App\\Http\\Controllers\\SoalController@dataSoal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal',
        'where' => 
        array (
        ),
        'as' => 'elearning.get-soal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.get-soal-home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/get-soal-home',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@dataSoalHome',
        'controller' => 'App\\Http\\Controllers\\SoalController@dataSoalHome',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal',
        'where' => 
        array (
        ),
        'as' => 'elearning.get-soal-home',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.get-detail-soal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/get-detail-soal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@dataDetailSoal',
        'controller' => 'App\\Http\\Controllers\\SoalController@dataDetailSoal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal',
        'where' => 
        array (
        ),
        'as' => 'elearning.get-detail-soal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.ubah-detail-soal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/detail/ubah/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@ubahDetailSoal',
        'controller' => 'App\\Http\\Controllers\\SoalController@ubahDetailSoal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal',
        'where' => 
        array (
        ),
        'as' => 'elearning.ubah-detail-soal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'elearning.detail-data-soal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/detail/data-soal/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SoalController@detailDataSoal',
        'controller' => 'App\\Http\\Controllers\\SoalController@detailDataSoal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal',
        'where' => 
        array (
        ),
        'as' => 'elearning.detail-data-soal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::qeDnxrNmbuDhO6Ve' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/essay/data',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\DetailSoalEssayController@data',
        'controller' => 'App\\Http\\Controllers\\DetailSoalEssayController@data',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal',
        'where' => 
        array (
        ),
        'as' => 'generated::qeDnxrNmbuDhO6Ve',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::APjXioUBj6wNSklL' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/essay/simpan-score',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\JawabController@simpanScore',
        'controller' => 'App\\Http\\Controllers\\JawabController@simpanScore',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal',
        'where' => 
        array (
        ),
        'as' => 'generated::APjXioUBj6wNSklL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'essay.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/essay',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'essay.index',
        'uses' => 'App\\Http\\Controllers\\DetailSoalEssayController@index',
        'controller' => 'App\\Http\\Controllers\\DetailSoalEssayController@index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'essay.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/essay/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'essay.create',
        'uses' => 'App\\Http\\Controllers\\DetailSoalEssayController@create',
        'controller' => 'App\\Http\\Controllers\\DetailSoalEssayController@create',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'essay.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'elearning/soal/essay',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'essay.store',
        'uses' => 'App\\Http\\Controllers\\DetailSoalEssayController@store',
        'controller' => 'App\\Http\\Controllers\\DetailSoalEssayController@store',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'essay.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/essay/{essay}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'essay.show',
        'uses' => 'App\\Http\\Controllers\\DetailSoalEssayController@show',
        'controller' => 'App\\Http\\Controllers\\DetailSoalEssayController@show',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'essay.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'elearning/soal/essay/{essay}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'essay.edit',
        'uses' => 'App\\Http\\Controllers\\DetailSoalEssayController@edit',
        'controller' => 'App\\Http\\Controllers\\DetailSoalEssayController@edit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'essay.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'elearning/soal/essay/{essay}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'essay.update',
        'uses' => 'App\\Http\\Controllers\\DetailSoalEssayController@update',
        'controller' => 'App\\Http\\Controllers\\DetailSoalEssayController@update',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'essay.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'elearning/soal/essay/{essay}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'essay.destroy',
        'uses' => 'App\\Http\\Controllers\\DetailSoalEssayController@destroy',
        'controller' => 'App\\Http\\Controllers\\DetailSoalEssayController@destroy',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'elearning/soal/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'download-file-format/{filename}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\DownloadController@download',
        'controller' => 'App\\Http\\Controllers\\DownloadController@download',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'download',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5MYld7x1coN3mIyv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cetak/excel/hasil-ujian-perkelas/{soal}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LaporanController@excelHasilUjianPerkelas',
        'controller' => 'App\\Http\\Controllers\\LaporanController@excelHasilUjianPerkelas',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/cetak',
        'where' => 
        array (
        ),
        'as' => 'generated::5MYld7x1coN3mIyv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::v4uX5YMMooILzyos' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'cetak/pdf/hasil-ujian-persiswa/{siswa}/{soal}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LaporanController@pdfHasilUjianPersiswa',
        'controller' => 'App\\Http\\Controllers\\LaporanController@pdfHasilUjianPersiswa',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/cetak',
        'where' => 
        array (
        ),
        'as' => 'generated::v4uX5YMMooILzyos',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vFk7QPkRzdxcgzhX' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'activity',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@activity',
        'controller' => 'App\\Http\\Controllers\\HomeController@activity',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::vFk7QPkRzdxcgzhX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'siswa.materi' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'siswa/data-materi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@dataMateri',
        'controller' => 'App\\Http\\Controllers\\SiswaController@dataMateri',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'siswa.materi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::OF8lZV9gR0TJC6YF' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'siswa/materi/detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@detailMateri',
        'controller' => 'App\\Http\\Controllers\\SiswaController@detailMateri',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::OF8lZV9gR0TJC6YF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::IzTePdrMIwclUJgn' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'siswa/materi',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@materi',
        'controller' => 'App\\Http\\Controllers\\SiswaController@materi',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::IzTePdrMIwclUJgn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::K7JwY1oR3PrNtc8m' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'siswa/ujian',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@ujian',
        'controller' => 'App\\Http\\Controllers\\SiswaController@ujian',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::K7JwY1oR3PrNtc8m',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::c37gGl5t20nZnMrq' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'siswa/ujian/get-detail-essay',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@getDetailEssay',
        'controller' => 'App\\Http\\Controllers\\SiswaController@getDetailEssay',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::c37gGl5t20nZnMrq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DM7BFVbbNgT2p7cg' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'siswa/ujian/simpan-jawaban-essay',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@simpanJawabanEssay',
        'controller' => 'App\\Http\\Controllers\\SiswaController@simpanJawabanEssay',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::DM7BFVbbNgT2p7cg',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'siswa.ujian' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'siswa/ujian/detail/{id}/{key?}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@detailUjian',
        'controller' => 'App\\Http\\Controllers\\SiswaController@detailUjian',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'siswa.ujian',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::oO3q98ATZvMiNHyM' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'siswa/ujian/detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@passwordUjian',
        'controller' => 'App\\Http\\Controllers\\SiswaController@passwordUjian',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::oO3q98ATZvMiNHyM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::aZNBM5yn2qIsLo26' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'siswa/ujian/finish/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@finishUjian',
        'controller' => 'App\\Http\\Controllers\\SiswaController@finishUjian',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::aZNBM5yn2qIsLo26',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::t9LMexpdpGUjlhPR' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'siswa/ujian/get-soal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@getSoal',
        'controller' => 'App\\Http\\Controllers\\SiswaController@getSoal',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::t9LMexpdpGUjlhPR',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::clVssiT7qEYwHCgc' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'siswa/ujian/jawab',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@jawab',
        'controller' => 'App\\Http\\Controllers\\SiswaController@jawab',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::clVssiT7qEYwHCgc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wLdEVk9yrMK6REi6' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'siswa/ujian/kirim-jawaban',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@kirimJawaban',
        'controller' => 'App\\Http\\Controllers\\SiswaController@kirimJawaban',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::wLdEVk9yrMK6REi6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lLIaZVezH6iyY7Gs' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'siswa/ujian/hapus-jawaban',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SiswaController@hapusJawaban',
        'controller' => 'App\\Http\\Controllers\\SiswaController@hapusJawaban',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/siswa',
        'where' => 
        array (
        ),
        'as' => 'generated::lLIaZVezH6iyY7Gs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
