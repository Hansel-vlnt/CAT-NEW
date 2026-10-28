<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketLangganansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_langganans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket', 100);
            $table->integer('durasi_bulan')->default(1);
            $table->integer('durasi_hari')->default(30);
            $table->integer('harga')->default(0);
            $table->integer('harga_coret')->nullable();
            $table->string('badge', 50)->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('fitur')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_aktif')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_langganans');
    }
}
