<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // foreach(['provinsi','kabupaten','kecamatan','kelurahan'] as $s){
        //     Schema::table($s, function (Blueprint $table) {    
        //         $table->
        //     });
        // }
        Schema::create('user_bios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nin');
            $table->string('name');
            $table->string('city_born');
            $table->date('birthdate');
            $table->enum('gender', ['0', '1']);
            $table->text('address');
            $table->integer('province_id');
            $table->integer('city_id');
            $table->integer('region_id');
            $table->integer('village_id');
            $table->string('post_code', 5);
            $table->enum('married', range(0,1));
            $table->string('nin_upload');
            $table->enum('status', range(0,1));
            $table->enum('verified', range(0,1))->default('0');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            // $table->foreign('province_id')->references('IDProvinsi')->on('provinsi')->onDelete('set null')->onUpdate('set null');
            // $table->foreign('city_id')->references('IDKabaputen')->on('kabupaten')->onDelete('set null')->onUpdate('set null');
            // $table->foreign('region_id')->references('IDKecamatan')->on('kecamatan')->onDelete('set null')->onUpdate('set null');
            // $table->foreign('village_id')->references('IDKelurahan')->on('kelurahan')->onDelete('set null')->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bios');
    }
}
