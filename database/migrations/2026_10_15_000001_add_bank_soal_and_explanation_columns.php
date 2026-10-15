<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBankSoalAndExplanationColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detailsoals', function (Blueprint $table) {
            if (!Schema::hasColumn('detailsoals', 'tipe_soal')) {
                $table->string('tipe_soal', 20)->default('single')->nullable();
            }
            if (!Schema::hasColumn('detailsoals', 'pembahasan_cepat')) {
                $table->longText('pembahasan_cepat')->nullable();
            }
            if (!Schema::hasColumn('detailsoals', 'pembahasan_konsep')) {
                $table->longText('pembahasan_konsep')->nullable();
            }
            if (!Schema::hasColumn('detailsoals', 'bobot_opsi')) {
                $table->text('bobot_opsi')->nullable();
            }
        });

        Schema::table('jawabs', function (Blueprint $table) {
            if (!Schema::hasColumn('jawabs', 'jawaban_multi')) {
                $table->text('jawaban_multi')->nullable();
            }
        });

        Schema::table('soals', function (Blueprint $table) {
            if (!Schema::hasColumn('soals', 'kategori_utama')) {
                $table->string('kategori_utama', 100)->nullable();
            }
            if (!Schema::hasColumn('soals', 'sub_kategori')) {
                $table->string('sub_kategori', 100)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detailsoals', function (Blueprint $table) {
            $table->dropColumn(['tipe_soal', 'pembahasan_cepat', 'pembahasan_konsep', 'bobot_opsi']);
        });

        Schema::table('jawabs', function (Blueprint $table) {
            $table->dropColumn(['jawaban_multi']);
        });

        Schema::table('soals', function (Blueprint $table) {
            $table->dropColumn(['kategori_utama', 'sub_kategori']);
        });
    }
}
