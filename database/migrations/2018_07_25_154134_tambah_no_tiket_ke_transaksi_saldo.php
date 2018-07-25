<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TambahNoTiketKeTransaksiSaldo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('sender_name');
            $table->dropColumn('sender_bill');
            $table->dropColumn('send_time');
            $table->dropColumn('proof');
            $table->dropColumn('status');
        });
        Schema::table('deposits', function (Blueprint $table) {
            $table->string('sender_name')->nullable();
            $table->string('sender_bill')->nullable();
            $table->dateTime('send_time')->nullable();
            $table->double('jumlah_transfer')->nullable();
            $table->string('no_tiket');
            $table->string('proof')->nullable();
            $table->enum('jenis_transaksi', [
                'Pesan Saldo', 'Ambil Saldo'
            ]);
            $table->date('tanggal_approve')->nullable();
            $table->enum('status',[
                'Order',
                'Konfirm',
                'Approve',
                'Gagal',
            ])->default('Order');
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
            $table->dropColumn('jumlah_transfer');
            $table->dropColumn('no_tiket');
            $table->dropColumn('jenis_transaksi');
            $table->dropColumn('tanggal_approve');
        });
    }
}
