<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->foreign('lead_id')->references('lead_id')->on('leads');
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->string('device')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('screen_resolution')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('system_info');
    }
}
