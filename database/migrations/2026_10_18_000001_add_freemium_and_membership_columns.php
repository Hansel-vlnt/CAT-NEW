<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFreemiumAndMembershipColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('soals', function (Blueprint $table) {
            if (!Schema::hasColumn('soals', 'tipe_akses')) {
                $table->string('tipe_akses', 20)->default('gratis');
            }
            if (!Schema::hasColumn('soals', 'harga')) {
                $table->integer('harga')->nullable()->default(0);
            }
        });

        Schema::table('materis', function (Blueprint $table) {
            if (!Schema::hasColumn('materis', 'tipe_akses')) {
                $table->string('tipe_akses', 20)->default('gratis');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'status_langganan')) {
                $table->string('status_langganan', 20)->default('gratis');
            }
            if (!Schema::hasColumn('users', 'tgl_berakhir_les')) {
                $table->date('tgl_berakhir_les')->nullable();
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
        Schema::table('soals', function (Blueprint $table) {
            if (Schema::hasColumn('soals', 'tipe_akses')) {
                $table->dropColumn('tipe_akses');
            }
            if (Schema::hasColumn('soals', 'harga')) {
                $table->dropColumn('harga');
            }
        });

        Schema::table('materis', function (Blueprint $table) {
            if (Schema::hasColumn('materis', 'tipe_akses')) {
                $table->dropColumn('tipe_akses');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'status_langganan')) {
                $table->dropColumn('status_langganan');
            }
            if (Schema::hasColumn('users', 'tgl_berakhir_les')) {
                $table->dropColumn('tgl_berakhir_les');
            }
        });
    }
}
