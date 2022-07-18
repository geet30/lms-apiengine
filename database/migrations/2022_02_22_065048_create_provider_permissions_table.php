<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->enum('is_new_connection',[0,1])->nullable()->default(0);
            $table->enum('is_port',[0,1])->nullable()->default(0);
            $table->enum('is_retention',[0,1])->nullable()->default(0);
            $table->enum('is_life_support',[0,1])->nullable()->default(0);
            $table->enum('is_submit_sale_api',[0,1])->nullable()->default(0);
            $table->enum('is_resale',[0,1])->nullable()->default(0);
            $table->enum('is_gas_only',[0,1])->nullable()->default(0);
            $table->enum('is_demand_usage',[0,1])->nullable()->default(0);
            $table->enum('ea_credit_score_allow',[0,1])->nullable()->default(0);
            $table->decimal('credit_score', 5,2)->nullable();
            $table->enum('is_telecom',[0,1])->nullable()->default(0);
            $table->enum('is_send_plan',[0,1])->nullable()->default(0);
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('provider_permissions');
    }
}
