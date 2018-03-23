<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPathToTabelPageKinds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_kinds', function (Blueprint $table) {
            $table->dropColumn('url');
        });
        Schema::table('page_kinds', function (Blueprint $table) {
            $table->string('path')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_kinds', function (Blueprint $table) {
            $table->string('url');
        });
        Schema::table('page_kinds', function (Blueprint $table) {
            $table->dropColumn('path');
        });
    }
}
