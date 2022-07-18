<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSaleProductsMobileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_products_mobile', function (Blueprint $table) {
            $table->integer('plan_data_per_month')->nullable()->after('cost');
            $table->integer('plan_duration')->nullable()->after('plan_data_per_month');
            $table->timestamp('plan_activation_date')->nullable()->after('plan_duration');
            $table->timestamp('plan_deactivation_date')->nullable()->after('plan_activation_date');
            $table->string('plan_network_type')->nullable()->after('plan_deactivation_date');
            $table->integer('plan_special_offer')->nullable()->after('plan_network_type');
            $table->tinyInteger('plan_data_unit')->nullable()->after('plan_special_offer');
            $table->integer('plan_minimum_cost')->nullable()->after('plan_data_unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_products_mobile', function (Blueprint $table) {
            //
        });
    }
}
