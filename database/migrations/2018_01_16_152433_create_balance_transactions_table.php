<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->string('sender_name');
            $table->string('sender_bill');
            $table->integer('deposit')->unsigned()->default(50000);
            $table->integer('receiver')->unsigned();
            $table->foreign('receiver')->references('id')->on('bank_accounts')->onDelete('cascade')->onUpdate('cascade');
            $table->datetime('send_time');
            $table->string('proof');
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->text('reason')->nullable();
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
        Schema::dropIfExists('balance_transactions');
    }
}
