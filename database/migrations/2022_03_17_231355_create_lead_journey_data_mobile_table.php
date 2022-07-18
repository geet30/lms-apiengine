<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadJourneyDataMobileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_journey_data_mobile', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedInteger('lead_id')->nullable();
            $table->integer('connection_type')->nullable();
            $table->integer('current_provider')->nullable();
            $table->integer('contract')->nullable();
            $table->string('plan_cost_min', 50)->nullable();
            $table->string('plan_cost_max', 50)->nullable();
            $table->string('data_usage_min', 50)->nullable();
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
        Schema::dropIfExists('lead_journey_data_mobile');
    }
}
