<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('skill_id');
            $table->integer('total_time')->default(0);
            //total_timeが100時間毎にrankを1づつ上げる。最大4
            $table->integer('skill_rank')->default(1);
            $table->timestamps();

            //外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skill_user', function (Blueprint $table) {
            $table->dropForeign('skill_user_user_id_foreign');
            $table->dropForeign('skill_user_skill_id_foreign');
        });
        Schema::dropIfExists('skill_user');
    }
}
