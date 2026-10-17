<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => true, 'password.request' => true, 'password.reset' => true]);
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/register/success', 'Auth\RegisterController@registerSuccess')->name('register.success');

Route::get('vouchers', 'HomeController@vouchers')->name('vouchers');
Route::post('vouchers', 'HomeController@vouchers_save')->name('vouchers.save');
Route::delete('vouchers', 'HomeController@vouchers_delete')->name('vouchers.delete');

Route::get('/', 'HomeController@index')->name('home.index');
Route::get('/home', 'HomeController@index')->name('home');
// reute group for crud
Route::group(['prefix' => 'crud'], function () {
	Route::post('simpan-soal', 'SoalController@simpanSoal');
	Route::post('update-profil', 'CrudController@updateProfil');
	Route::post('simpan-materi', 'CrudController@simpanMateri');
	Route::post('terbit-soal', 'CrudController@terbitSoal');
	Route::post('simpan-detail-soal', 'SoalController@simpanDetailSoal');
	Route::post('simpan-detail-soal-via-excel', 'SoalController@simpanDetailSoalExcel');
	Route::post('upload-gambar-soal', 'SoalController@uploadGambarSoal');
	Route::post('simpan-gambar-materi', 'CrudController@simpanGambarMateri');
	Route::post('hapus-gambar-materi', 'CrudController@hapusGambarMateri');
	Route::post('simpan-gambar-user', 'CrudController@simpanGambarUser');
	Route::post('update-profil-sekolah', 'CrudController@updateProfilSekolah');
	Route::post('simpan-siswa', 'CrudController@simpanSiswa');
	Route::post('update-siswa', 'CrudController@updateSiswa');
	Route::post('simpan-siswa-via-excel', 'CrudController@simpanSiswaViaExcel');
	Route::post('update-img-siswa', 'CrudController@updateImgSiswa');
	Route::post('delete-siswa', 'CrudController@deleteSiswa');
	Route::post('update-guru', 'CrudController@updateGuru');
	Route::post('delete-guru', 'CrudController@deleteGuru');
	Route::post('simpan-kelas', 'CrudController@simpanKelas');
	Route::post('delete-kelas', 'CrudController@deleteKelas');
	Route::post('reset-ujian', 'CrudController@resetUjian');
	Route::post('aktivasi', 'CrudController@aktivasi')->name('aktivasi');
});

Route::group(['prefix' => 'pengaturan'], function () {
	Route::get('/', 'HomeController@pengaturan')->name('pengaturan');
});

Route::group(['prefix' => 'master'], function () {
	// Safe redirects for deprecated guru & kelas endpoints
	Route::any('guru{any?}', function () {
		return redirect()->route('siswa');
	})->where('any', '.*');
	Route::any('kelas{any?}', function () {
		return redirect()->route('siswa');
	})->where('any', '.*');
	Route::any('data-kelas', function () {
		return redirect()->route('siswa');
	});
	Route::any('detail-kelas{any?}', function () {
		return redirect()->route('siswa');
	})->where('any', '.*');

	// route master siswa
	Route::group(['prefix' => 'siswa'], function () {
		Route::get('/', 'SiswaController@index')->name('siswa');
		Route::get('data-siswa', 'SiswaController@dataSiswa')->name('master.data_siswa');
		Route::get('detail/{id}', 'SiswaController@detailSiswa');
		Route::get('edit/{id}', 'SiswaController@editSiswa');
		Route::get('delete', 'SiswaController@delete');
		Route::get('get-btn-delete/{password}', 'SiswaController@getBtnDelete');
		Route::get('delete-all', 'SiswaController@deleteAll');
	});
});

Route::group(['prefix' => 'elearning'], function () {
	Route::group(['prefix' => 'materi'], function () {
		Route::get('/', 'MateriController@index')->name('elearning.materi');
		Route::get('/get-materi-guru', 'MateriController@dataMateriGuru')->name('elearning.dataMateriGuru');
		Route::get('/detail/{id}', 'MateriController@detail')->name('elearning.detailMateri');
		Route::get('/ubah/{id}', 'MateriController@ubah')->name('elearning.detailubahMateri');
	});
	Route::group(['prefix' => 'laporan'], function () {
		Route::get('/', 'LaporanController@index')->name('elearning.laporan');
		Route::get('/paket/{id}', 'LaporanController@laporanPerPaket');
		Route::get('/detail-kelas/{id}', 'LaporanController@detailKelas')->name('elearning.laporan.detailKelas');
		Route::get('data-paket-soal', 'LaporanController@data_paket_soal')->name('elearning.laporan.data_paket_soal');
		Route::get('detail-kelas/{id_kelas}/paket-soal/{id_soal}', 'LaporanController@detailPaketSoalPerKelas');
		Route::get('data-kelas-paket-soal', 'LaporanController@dataKelasPaketSoal')->name('elearning.laporan.data_kelas_paket_soal');
		Route::get('{id_soal}/{id_user}', 'LaporanController@detailLaporanSiswa')->name('elearning.detailLaporanSiswa');
		Route::get('hasil-siswa', 'LaporanController@hasilSiswa')->name('elearning.hasilSiswa');
	});
	Route::group(['prefix' => 'soal'], function () {
		Route::get('/', 'SoalController@index')->name('soal');
		Route::delete('/paket-soal', 'SoalController@deletePaketSoal')->name('soal.paket.hapus');
		Route::delete('/', 'SoalController@deleteSoal')->name('soal.hapus');
		Route::get('/ubah/{id}', 'SoalController@ubahSoal')->name('soal.ubah');
		Route::get('/detail/{id}', 'SoalController@detail')->name('elearning.detail-soal');
		Route::get('/get-soal', 'SoalController@dataSoal')->name('elearning.get-soal');
		Route::get('/get-soal-home', 'SoalController@dataSoalHome')->name('elearning.get-soal-home');
		Route::get('/get-detail-soal', 'SoalController@dataDetailSoal')->name('elearning.get-detail-soal');
		Route::get('/detail/ubah/{id}', 'SoalController@ubahDetailSoal')->name('elearning.ubah-detail-soal');
		Route::get('/detail/data-soal/{id}', 'SoalController@detailDataSoal')->name('elearning.detail-data-soal');
		Route::get('/essay/data', 'DetailSoalEssayController@data');
		Route::get('/essay/simpan-score', 'JawabController@simpanScore');
		Route::resource('/essay', 'DetailSoalEssayController');
	});
});
Route::get('/download-file-format/{filename}', 'DownloadController@download')->name('download');
Route::group(['prefix' => 'cetak'], function () {
	Route::get('/excel/hasil-ujian-perkelas/{soal}', 'LaporanController@excelHasilUjianPerkelas');
	Route::get('/pdf/hasil-ujian-persiswa/{siswa}/{soal}', 'LaporanController@pdfHasilUjianPersiswa');
});
Route::get('/activity', 'HomeController@activity');

Route::group(['prefix' => 'siswa'], function () {
	Route::get('data-materi', 'SiswaController@dataMateri')->name('siswa.materi');
	Route::get('materi/detail/{id}', 'SiswaController@detailMateri');
	Route::get('materi', 'SiswaController@materi');
	Route::get('ujian', 'SiswaController@ujian');
	Route::get('ujian/get-detail-essay', 'SiswaController@getDetailEssay');
	Route::get('ujian/simpan-jawaban-essay', 'SiswaController@simpanJawabanEssay');
	Route::get('ujian/detail/{id}/{key?}', 'SiswaController@detailUjian')->name('siswa.ujian');
	Route::post('ujian/detail/{id}', 'SiswaController@passwordUjian');
	Route::get('ujian/finish/{id}', 'SiswaController@finishUjian');
	Route::post('ujian/get-soal', 'SiswaController@getSoal');
	Route::post('ujian/jawab', 'SiswaController@jawab');
	Route::post('ujian/kirim-jawaban', 'SiswaController@kirimJawaban');
	Route::post('ujian/hapus-jawaban', 'SiswaController@hapusJawaban');
});
