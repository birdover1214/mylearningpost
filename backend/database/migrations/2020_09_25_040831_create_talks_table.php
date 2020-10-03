<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('host_id');
            $table->unsignedBigInteger('guest_id');
            $table->string('comment', 500);
            $table->string('image')->nullable();
            $table->timestamps();

            //外部キー制約
            $table->foreign('host_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('guest_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('talks', function (Blueprint $table) {
            $table->dropForeign('talks_host_id_foreign');
            $table->dropForeign('talks_guest_id_foreign');
        });
        Schema::dropIfExists('talks');
    }
}
