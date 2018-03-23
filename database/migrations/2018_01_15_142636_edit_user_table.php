<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Schema::disableForeignKeyConstraints();
        Schema::table('comments', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('contents', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn('id');
        });
        Schema::table('user', function (Blueprint $table) {
            $table->increments('id')->before('nama');
            $table->string('token_number')->nullable();
            $table->string('verification_url')->nullable();
            $table->datetime('last_time_to_verify')->nullable();
        });
        Schema::table('comments', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('contents', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn(['token_number', 'verification_url', 'last_time_to_verify']);
        });
    }
}
