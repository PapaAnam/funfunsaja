<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraintArea extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_bios', function (Blueprint $table) {
            $table->dropColumn([
                'province_id', 'city_id', 'region_id', 'village_id',
            ]);
        });

        Schema::table('user_bios', function (Blueprint $table) {
            $table->string('province_id', 5)->nullable();
            $table->string('city_id', 5)->nullable();
            $table->string('region_id', 5)->nullable();
            $table->string('village_id', 6)->nullable();
        });

        Schema::table('user_bios', function (Blueprint $table) {
            $table->foreign('province_id')->references('IDProvinsi')->on('provinsi')
            ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('city_id')->references('IDKabupaten')->on('kabupaten')
            ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('region_id')->references('IDKecamatan')->on('kecamatan')
            ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('village_id')->references('IDKelurahan')->on('kelurahan')
            ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_bios', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
            $table->dropForeign(['city_id']);
            $table->dropForeign(['region_id']);
            $table->dropForeign(['village_id']);
            $table->dropColumn([
                'province_id', 'city_id', 'region_id', 'village_id',
            ]);
        });
        Schema::table('user_bios', function (Blueprint $table) {
            $table->string('province_id', 5)->nullable();
            $table->string('city_id', 5)->nullable();
            $table->string('region_id', 5)->nullable();
            $table->string('village_id', 6)->nullable();
        });
    }
}
