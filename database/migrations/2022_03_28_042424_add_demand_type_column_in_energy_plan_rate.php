<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDemandTypeColumnInEnergyPlanRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('energy_plan_rates', function (Blueprint $table) {
            $table->string("demand_charge_type")->nullable();
            $table->tinyInteger('rate_type')->nullable()->comment('1 => Normal'); 
        });

        Schema::table('solar_rates', function (Blueprint $table) {
            $table->float("charge")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('energy_plan_rates', function (Blueprint $table) {
            $table->dropColumn('demand_charge_type');
            $table->dropColumn('rate_type');
        });

        Schema::table('solar_rates', function (Blueprint $table) {
            $table->dropColumn('charge');
        });
    }
}
