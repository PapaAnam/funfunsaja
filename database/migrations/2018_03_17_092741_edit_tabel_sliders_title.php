<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTabelSlidersTitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            if (Schema::hasColumn('sliders', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('sliders', 'font')) {
                $table->dropColumn('font');
            }
            if (Schema::hasColumn('sliders', 'font_size')) {
                $table->dropColumn('font_size');
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
        Schema::table('sliders', function (Blueprint $table) {
            //
        });
    }
}
