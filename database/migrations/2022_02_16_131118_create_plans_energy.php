<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansEnergy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_energy', function (Blueprint $table) {
            $table->id();
            $table->integer('provider_id');
            $table->string('name');
            $table->text('plan_desc')->nullable();
            $table->tinyInteger('plan_type');
            $table->tinyInteger('energy_type');
            $table->tinyInteger('generate_token');
            $table->tinyInteger('show_price_fact');
            $table->tinyInteger('dual_only');
            $table->tinyInteger('green_options');
            $table->text('green_options_desc')->nullable();
            $table->tinyInteger('solar_compatible');
            $table->tinyInteger('show_solar_plan');
            $table->tinyInteger('is_bundle_dual_plan');
            $table->string('offer_code')->nullable();
            $table->string('bundle_code')->nullable();
            $table->string('contract_length')->nullable();
            $table->integer('recurring_meter_charges')->nullable();
            $table->integer('credit_bonus')->nullable();
            $table->string('plan_campaign_code')->nullable();
            $table->string('eligibility')->nullable();
            $table->string('offer_details')->nullable();
            $table->string('offer_type')->nullable();
            $table->string('product_code')->nullable();
            $table->string('campaign_code')->nullable();
            $table->string('promotion_code')->nullable();
            $table->text('paper_bill_fee')->nullable();
            $table->text('counter_fee')->nullable();
            $table->text('credit_card_service_fee')->nullable();
            $table->text('cooling_off_period')->nullable();
            $table->text('other_fee_section')->nullable();
            $table->string('plan_bonus')->nullable();
            $table->text('plan_bonus_desc')->nullable();
            $table->string('billing_options')->nullable();
            $table->string('benefit_term')->nullable();
            $table->text('payment_options')->nullable();
            $table->longText('plan_features')->nullable();
            $table->longText('terms_condition')->nullable();
            $table->tinyInteger('demand_usage_check')->nullable();
            $table->text('view_discount')->nullable();
            $table->text('view_bonus')->nullable();
            $table->text('view_contract')->nullable();
            $table->text('view_exit_fee')->nullable();
            $table->text('view_benefit')->nullable();
            $table->tinyInteger('apply_now_status')->nullable();
            $table->text('apply_now_content')->nullable();
            $table->timestamp('active_on')->nullable();
            $table->timestamp('upload_on')->nullable();
            $table->tinyInteger('status')->nullable();

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
        Schema::dropIfExists('plans_energy');
    }
}
