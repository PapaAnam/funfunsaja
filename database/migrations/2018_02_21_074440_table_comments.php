<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            if(Schema::hasColumn('comments', 'like')){
                $table->dropColumn('like');
            }
            if(Schema::hasColumn('comments', 'dislike')){
                $table->dropColumn('dislike');
            }
            if(Schema::hasColumn('comments', 'status')){
                $table->dropColumn('status');
            }
            $table->string('file_path')->nullable();
            $table->enum('is_best', range(0,1))->default('0');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->enum('status', range(0,2))->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'is_best']);
            $table->string('like');
            $table->string('dislike');
        });
    }
}
