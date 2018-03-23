<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('point');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('foto');
            $table->dropColumn('saldo');
            $table->dropColumn('role');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar');
            $table->integer('balance')->unsigned();
            $table->integer('point')->unsigned();
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
            if(!Schema::hasColumn('contents', 'point')){
                $table->string('point');
            }
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto');
            $table->string('saldo');
            $table->string('role');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('balance');
            if(Schema::hasColumn('users', 'point')){
                $table->dropColumn('point');
            }
        });
    }
}
