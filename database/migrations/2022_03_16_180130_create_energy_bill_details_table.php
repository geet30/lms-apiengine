<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Lead;

if (!class_exists('CreateEnergyBillDetailsTable')) {

    class CreateEnergyBillDetailsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('energy_bill_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('lead_id')->index()->nullable();
                $table->foreign('lead_id')->references('lead_id')->on('leads');
                $table->integer('current_provider_id')->nullable();
                $table->date('bill_start_date')->nullable();
                $table->date('bill_end_date')->nullable();
                $table->float('bill_amount')->nullable();
                $table->tinyInteger('usage_level')->nullable();
                $table->string('meter_type', '50')->nullable();
                $table->string('tariff_type', '50')->nullable();
                $table->float('solar_usage')->nullable();
                $table->float('peak_usage')->nullable();
                $table->float('off_peak_usage')->nullable();
                $table->float('shoulder_usage')->nullable();
                $table->tinyInteger('control_load')->default(0)->comment('0:no,1:yes');
                $table->float('control_load_one_usage')->nullable();
                $table->float('control_load_two_usage')->nullable();
                $table->tinyInteger('control_load_timeofuse')->default(0)->comment('0:no,1:yes');
                $table->float('control_load_one_off_peak')->nullable();
                $table->float('control_load_one_shoulder')->nullable();
                $table->float('control_load_two_off_peak')->nullable();
                $table->float('control_load_two_shoulder')->nullable();
                $table->tinyInteger('demand_tariff')->nullable();
                $table->tinyInteger('demand_rate_last_step')->nullable();
                $table->Integer('demand_usage_type')->nullable();
                $table->Integer('demand_meter_type')->nullable();
                $table->Integer('demand_tariff_code')->nullable();
                $table->float('demand_rate1_peak_usage')->nullable();
                $table->float('demand_rate1_off_peak_usage')->nullable();
                $table->float('demand_rate1_shoulder_usage')->nullable();
                $table->Integer('demand_rate1_days')->nullable();
                $table->float('demand_rate2_peak_usage')->nullable();
                $table->float('demand_rate2_off_peak_usage')->nullable();
                $table->float('demand_rate2_shoulder_usage')->nullable();
                $table->Integer('demand_rate2_days')->nullable();
                $table->float('demand_rate3_peak_usage')->nullable();
                $table->float('demand_rate3_off_peak_usage')->nullable();
                $table->float('demand_rate3_shoulder_usage')->nullable();
                $table->Integer('demand_rate3_days')->nullable();
                $table->float('demand_rate4_peak_usage')->nullable();
                $table->float('demand_rate4_off_peak_usage')->nullable();
                $table->float('demand_rate4_shoulder_usage')->nullable();
                $table->Integer('demand_rate4_days')->nullable();
                $table->float('credit_score')->nullable();
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
            Schema::dropIfExists('energy_bill_details');
        }
    }
}
