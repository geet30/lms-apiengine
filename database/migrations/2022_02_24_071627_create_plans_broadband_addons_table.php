<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansBroadbandAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_broadband_addons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->foreign('plan_id')->references('id')->on('plans_broadbands')->onDelete('cascade');
            $table->unsignedInteger('addon_id')->nullable(); 
            $table->integer('category')->default(0);
            $table->integer('cost_type_id')->default(0);
            $table->decimal('price', 8, 2)->default(0);
            $table->text('script')->nullable(); 
            $table->tinyInteger('is_default')->default(0);
            $table->tinyInteger('is_mandatory')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0-disabled,1-enabled');
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
        Schema::dropIfExists('plans_broadband_addons');
    }
}
