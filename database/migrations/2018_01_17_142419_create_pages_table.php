<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('url')->unique();
            $table->integer('page_kind_id')->unsigned()->nullable();
            $table->foreign('page_kind_id')->references('id')->on('page_kinds')->onDelete('set null')->onUpdate('set null');
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('kategori')->onDelete('set null')->onUpdate('set null');
            $table->text('content');
            $table->string('attachment')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('tags');
            $table->integer('hit')->default(0);
            $table->enum('status', ['0', '1'])->default('0');
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
        Schema::dropIfExists('pages');
    }
}
