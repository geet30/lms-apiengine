<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadJouneryDataEnergyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_jounery_data_energy', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->index()->nullable();
            $table->foreign('lead_id')->references('lead_id')->on('leads');
            $table->unsignedBigInteger('distributor_id')->index()->nullable();
            $table->foreign('distributor_id')->references('id')->on('distributors');

            $table->unsignedInteger('previous_provider_id')->nullable();
            $table->foreign('previous_provider_id')->references('id')->on('providers');

            $table->unsignedInteger('current_provider_id')->index()->nullable();
            $table->foreign('current_provider_id')->references('id')->on('providers');

            $table->boolean('bill_available')->nullable()->comment('0: No, 1: Yes');
            

            $table->boolean('is_dual')->nullable()->comment('0: No, 1: Yes');
            $table->string('plan_bundle_code')->nullable();
            $table->boolean('property_type')->nullable()->comment('0: residential, 1: business');
            $table->boolean('energy_type')->index()->nullable()->comment('1: electricity, 2: gas, 3: dual');
            $table->boolean('solar_panel')->nullable()->comment('0: No, 1: Yes');
            $table->string('solar_options', 100)->nullable();
            $table->boolean('life_support')->nullable()->comment('0: No, 1: Yes');
            $table->boolean('life_support_energy_type')->nullable()->comment('1: electricity, 2: gas, 3: dual');
            $table->string('life_support_value', 100)->nullable();
            $table->boolean('moving_house')->nullable()->comment('0: No, 1: Yes');
            $table->dateTime('moving_date', $precision = 0)->nullable();
            $table->dateTime('prefered_move_in_time', $precision = 0)->nullable();
            $table->string('elec_concession_rebate_ans')->nullable();
            $table->string('elec_concession_rebate_amount', 50)->nullable();
            $table->string('gas_concession_rebate_ans')->nullable();
            $table->string('gas_concession_rebate_amount', 50)->nullable();

            $table->string('screen_name', 50)->nullable();
            $table->string('step_name', 10)->nullable();
            $table->integer('percentage')->nullable();
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_jounery_data_energy');
    }
}
