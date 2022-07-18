<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnergyPlanRateLimits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('energy_plan_rate_limits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_rate_id');
            $table->foreign('plan_rate_id')->references('id')->on('energy_plan_rates')->onDelete('cascade');
            $table->string('limit_type');
            $table->string('limit_level');
            $table->string('limit_desc')->nullable();
            $table->float('limit_daily')->default(0);
            $table->float('limit_year')->default(0);
            $table->float('limit_charges');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('energy_plan_rate_limits');
    }
}



