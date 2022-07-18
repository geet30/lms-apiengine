<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansBroadbandContentCheckboxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_broadband_content_checkboxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->foreign('plan_id')->references('id')->on('plans_broadbands')->onDelete('cascade');
            $table->tinyInteger('type');
            $table->tinyInteger('required');
            $table->tinyInteger('status');
            $table->text('validation_message')->nullable();
            $table->text('content');
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
        Schema::dropIfExists('plans_broadband_content_checkboxes');
    }
}
