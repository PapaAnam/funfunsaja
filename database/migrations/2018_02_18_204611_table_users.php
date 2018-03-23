<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if(Schema::hasColumn('users', 'is_premium')){
                $table->dropColumn(['is_premium']);
            }
            if(Schema::hasColumn('users', 'premium_until')){
                $table->dropColumn(['premium_until']);
            }
        });
        Schema::table('users', function (Blueprint $table) {
            $table->enum('is_premium', range(0,1))->default('0');
            $table->dateTime('premium_until')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_premium', 'premium_until']);
        });
    }
}
