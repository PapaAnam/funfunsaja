<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditUserBiographiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_biographies', function (Blueprint $table) {
            $table->dropColumn('social_media');
            $table->dropColumn('contact');
            $table->dropColumn('education');
            $table->dropColumn('work_experience');
            $table->dropColumn('certificate');
            $table->dropColumn('appreciation');
            $table->dropColumn('organization');
            $table->dropColumn('portfolio');
        });
        Schema::table('user_biographies', function (Blueprint $table) {
            $table->text('social_media')->nullable();
            $table->text('contact')->nullable();
            $table->text('education')->nullable();
            $table->text('work_experience')->nullable();
            $table->text('certificate')->nullable();
            $table->text('appreciation')->nullable();
            $table->text('organization')->nullable();
            $table->text('portfolio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_biographies', function (Blueprint $table) {
            //
        });
    }
}
