<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditFieldContentInContentTableAndDropTableUseless extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('content');
        });
        Schema::table('contents', function (Blueprint $table) {
            $table->longText('content');
        });
        Schema::dropIfExists('artikel');
        Schema::dropIfExists('halaman');
        Schema::dropIfExists('history_saldo');
        Schema::dropIfExists('jawaban');
        Schema::dropIfExists('konfigurasi');
        Schema::dropIfExists('log');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('poin');
        Schema::dropIfExists('view_artikel');
        Schema::dropIfExists('view_jawaban');
        Schema::dropIfExists('view_jual_beli');
        Schema::dropIfExists('view_komentar');
        Schema::dropIfExists('view_komentar_jualbeli');
        Schema::dropIfExists('view_komentar_rekrutment');
        Schema::dropIfExists('view_log');
        Schema::dropIfExists('view_pelamar');
        Schema::dropIfExists('view_pertanyaan');
        Schema::dropIfExists('view_rekrutment');
        Schema::dropIfExists('view_sub_menu');
        Schema::dropIfExists('view_testimoni');
        Schema::dropIfExists('view_user');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('content');
        });
        Schema::table('contents', function (Blueprint $table) {
            $table->longText('content');
        });
    }
}
