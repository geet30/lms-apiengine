<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Lead;

if (!class_exists('CreateLeadDataEnergyTable')) {
    class CreateLeadDataEnergyTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('lead_data_energy', function (Blueprint $table) {
                $table->id();
                $table->integer('lead_id');
                $table->foreignIdFor(Lead::class);
                $table->unsignedInteger('affiliate_id');
                $table->unsignedInteger('sub_affiliate_id')->nullable();
                $table->tinyInteger('energy_type')->comment('1:electricity', '2 :gas,3:electricitygas', '4:lpg');
                $table->tinyInteger('property_type')->comment('1:resedential', '2 :business');
                $table->tinyInteger('solar_panel')->nullable()->comment('0:no', '1:yes');
                $table->tinyInteger('solar_options')->nullable();
                $table->tinyInteger('life_support')->default(0)->comment('0:no,1:yes');
                $table->tinyInteger('life_support_energy_type')->default(0)->comment('1:electricity', '2 :gas,3:electricitygas');
                $table->string('life_support_value')->nullable();
                $table->tinyInteger('moving_house')->default(0)->comment('0:no,1:yes');
                $table->date('moving_date')->nullable();
                $table->string('prefered_move_in_time', '20')->nullable();
                $table->tinyInteger('elec_concession_rebate_ans')->default(0)->comment('0:no,1:yes');
                $table->float('elec_concession_rebate_amount')->nullable();
                $table->tinyInteger('gas_concession_rebate_ans')->default(0)->comment('0:no,1:yes');
                $table->float('gas_concession_rebate_amount')->nullable();
                $table->integer('distributor_id');
                $table->integer('previous_provider_id')->nullable();
                $table->integer('plan_id')->nullable();
                $table->string('plan_bundle_code', '100')->nullable();
                $table->tinyInteger('is_dual')->nullable()->comment('0:singl', '1:both or dual ');;
                $table->tinyInteger('bill_available')->defualt(0)->comment('0:no,1:yes');
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
            Schema::dropIfExists('lead_data_energy');
        }
    }
}
