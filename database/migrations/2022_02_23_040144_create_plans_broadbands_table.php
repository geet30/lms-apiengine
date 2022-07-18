<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansBroadbandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('plans_broadbands', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedInteger('provider_id');
            $table->foreign('provider_id')->references('user_id')->on('providers')->onDelete('cascade');
            $table->string('name');
            $table->integer('contract_id');
            $table->integer('connection_type'); 
            $table->text('satellite_inclusion')->nullable();
            $table->text('inclusion')->nullable();
            $table->text('connection_type_info')->nullable();
            $table->decimal('internet_speed', 8,2)->nullable();
            $table->text('internet_speed_info')->nullable();
            $table->integer('plan_cost_type_id')->nullable();
            $table->decimal('plan_cost', 8,2)->nullable();
            $table->tinyInteger('is_boyo_modem')->nullable();
            $table->text('plan_cost_info')->nullable();
            $table->text('plan_cost_description')->nullable();
            $table->tinyInteger('nbn_key')->nullable();
            $table->string('nbn_key_url')->nullable();

            $table->string('download_speed')->nullable();
            $table->string('upload_speed')->nullable();
            $table->string('typical_peak_time_download_speed')->nullable();
            $table->string('data_limit')->nullable();
            $table->string('speed_description')->nullable();
            $table->text('additional_plan_information')->nullable();
            $table->text('plan_script')->nullable();

            $table->string('total_data_allowance')->nullable();
            $table->string('off_peak_data')->nullable();
            $table->string('peak_data')->nullable(); 

            $table->tinyInteger('special_offer_status')->nullable();
            $table->integer('special_cost_id')->nullable();
            $table->decimal('special_offer_price', 8,2)->nullable(); 
            $table->text('special_offer')->nullable(); 

            $table->tinyInteger('critical_info_type')->nullable();
            $table->string('critical_info_url')->nullable(); 
            $table->string('critical_info_summary')->nullable();

            $table->tinyInteger('status')->default(0)->comment('0-disabled,1-enabled,2-archived,3-draft');
            $table->tinyInteger('remarketing_allow')->nullable();
            $table->integer('version');
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
        Schema::dropIfExists('plans_broadbands');
    }
}
