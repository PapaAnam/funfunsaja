<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title')->unique();
            $table->string('url')->unique();
            $table->integer('feedback_kind_id')->unsigned()->nullable();
            $table->foreign('feedback_kind_id')->references('id')->on('feedback_kinds')->onDelete('set null')->onUpdate('set null');
            $table->text('content');
            $table->string('attachment')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('tags');
            $table->integer('hit')->default(0);
            $table->enum('status', range(0,3))->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
}
