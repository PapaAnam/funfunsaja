<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPathToTabelContentKinds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_kinds', function (Blueprint $table) {
            $table->dropColumn('url');
        });
        Schema::table('content_kinds', function (Blueprint $table) {
            $table->string('path')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content_kinds', function (Blueprint $table) {
            $table->dropColumn('path');
        });
        Schema::table('content_kinds', function (Blueprint $table) {
            $table->string('url');
        });
    }
}
