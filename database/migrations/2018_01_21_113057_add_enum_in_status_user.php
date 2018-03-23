<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnumInStatusUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->dropColumn(['status']);
            $table->dropColumn(['username']);
            // $table->dropColumn(['no_hp', 'profil']);
            // $table->dropColumn(['tanggal_lahir', 'nama', 'nik', 'alamat', 'id_kel', 'id_kec', 'id_kabkota', 'id_prov', 'kode_pos', 'passion', 'skill']);
        });

        Schema::table('user', function (Blueprint $table) {
            $table->enum('status', range(0, 2))->default('0');
            $table->string('username')->unique()->nullable();
            // $table->string('phone_number')->unique();
            // $table->text('description');
            // $table->timestamps();
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
            //
        });
    }
}
