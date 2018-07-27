<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahJumlahDisetujuiDiDeposit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->double('jumlah_disetujui')->nullable();
        });
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropForeign('balance_transactions_receiver_foreign');
        });
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('receiver');
            $table->dropColumn('unique_code');
        });
        Schema::table('deposits', function (Blueprint $table) {
            $table->integer('receiver')->unsigned()->nullable();
            $table->integer('unique_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('jumlah_disetujui');
        });
    }
}
