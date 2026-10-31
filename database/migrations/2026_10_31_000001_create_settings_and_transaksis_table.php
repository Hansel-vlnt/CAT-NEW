<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSettingsAndTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Tabel Settings (Pengaturan Umum & Kontak)
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->increments('id');
                $table->string('key', 100)->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });

            // Seed default settings
            $now = date('Y-m-d H:i:s');
            DB::table('settings')->insert([
                ['key' => 'no_wa_admin', 'value' => '085767629211', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'nama_bank', 'value' => 'Bank BCA', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'no_rekening', 'value' => '8280912345', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'atas_nama_rekening', 'value' => 'Abdi Praja Edukasi', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'jam_layanan', 'value' => '09.00 - 21.00 WIB', 'created_at' => $now, 'updated_at' => $now],
                ['key' => 'qris_image', 'value' => '', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        // 2. Tabel Transaksis (Order Pembayaran & Deteksi Otomatis)
        if (!Schema::hasTable('transaksis')) {
            Schema::create('transaksis', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('order_id', 50)->unique();
                $table->unsignedBigInteger('id_user');
                $table->unsignedBigInteger('id_paket')->nullable();
                $table->string('nama_paket', 100);
                $table->integer('durasi_bulan')->default(1);
                $table->integer('durasi_hari')->default(30);
                $table->integer('nominal');
                $table->integer('kode_unik')->default(0);
                $table->integer('total_bayar');
                $table->string('metode', 50)->default('qris'); // 'qris', 'transfer_bank'
                $table->string('status', 20)->default('PENDING'); // 'PENDING', 'PAID', 'EXPIRED', 'CANCELLED'
                $table->string('kode_voucher', 50)->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->timestamp('expired_at')->nullable();
                $table->timestamps();

                $table->index('order_id');
                $table->index('id_user');
                $table->index('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
        Schema::dropIfExists('settings');
    }
}
