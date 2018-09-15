<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinPointToPointClaims extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('point_claims', function (Blueprint $table) {
            $table->integer('min_point_ditukar');
            $table->integer('point_yang_dipunya');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('point_claims', function (Blueprint $table) {
            $table->dropColumn('min_point_ditukar');
            $table->dropColumn('point_yang_dipunya');
        });
    }
}
