<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditStrukturTblContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('kategori', function (Blueprint $table) {
        //     $table->dropColumn('id');
        // });
        // Schema::table('kategori', function (Blueprint $table) {
        //     $table->increments('id');
        // });
        // Schema::table('user', function (Blueprint $table) {
        //     $table->dropColumn(['tanggal_lahir', 'id']);
        // });
        // Schema::table('user', function (Blueprint $table) {
        //     $table->increments('id')->before('nama');
        //     $table->date('tanggal_lahir')->nullable()->after('nama');
        // });
        // Schema::table('contents', function (Blueprint $table) {
        //     $table->dropColumn(['user_id']);
        // });
        Schema::table('contents', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('kategori')->onUpdate('set null')->onDelete('set null');
            $table->foreign('content_kind_id')->references('id')->on('content_kinds')->onUpdate('set null')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['content_kind_id']);
            $table->dropColumn(['user_id']);
        });
    }
}
