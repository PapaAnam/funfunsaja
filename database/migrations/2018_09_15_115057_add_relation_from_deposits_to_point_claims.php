<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationFromDepositsToPointClaims extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->integer('point_claim_id')->unsigned()->nullable();
            $table->foreign('point_claim_id')->references('id')->on('point_claims')->onUpdate('set null')->onDelete('set null');
            $table->integer('premium_log_id')->unsigned()->nullable();
            $table->foreign('premium_log_id')->references('id')->on('premium_logs')->onUpdate('set null')->onDelete('set null');
            $table->integer('premium_content_id')->unsigned()->nullable();
            $table->foreign('premium_content_id')->references('id')->on('bought_contents')->onUpdate('set null')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropForeign(['point_claim_id']);
            $table->dropForeign(['premium_log_id']);
            $table->dropForeign(['premium_content_id']);
        });
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn('point_claim_id');
            $table->dropColumn('premium_log_id');
            $table->dropColumn('premium_content_id');
        });
    }
}
