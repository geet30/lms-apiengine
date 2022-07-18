<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTelcoContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_telco_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->foreign('plan_id')->references('id')->on('plans_broadbands')->onDelete('cascade');
            $table->tinyInteger('service_id');
            $table->string('title');
            $table->tinyInteger('status');
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('plans_telco_contents');
    }
}
