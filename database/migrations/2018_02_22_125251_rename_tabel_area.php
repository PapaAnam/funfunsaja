<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTabelArea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('provinsi', 'area_provinces');
        Schema::rename('kabupaten', 'area_cities');
        Schema::rename('kecamatan', 'area_regions');
        Schema::rename('kelurahan', 'area_villages');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('area_provinces', 'provinsi');
        Schema::rename('area_cities', 'kabupaten');
        Schema::rename('area_regions', 'kecamatan');
        Schema::rename('area_villages', 'kelurahan');
    }
}
