<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_id');
            $table->string('reference_no',50)->nullable();
            $table->unsignedInteger('service_id');
            $table->unsignedInteger('provider_id')->nullable();
            $table->unsignedInteger('plan_id')->nullable();
            $table->tinyInteger('status');
            $table->tinyInteger('is_moving')->comment('0 => No , 1 => Yes');
            $table->timestamp('moving_date')->nullable();
            $table->tinyInteger('is_duplicate')->nullable();
            $table->tinyInteger('sale_source')->nullable()->comment('1 => Email , 2 => SMS');
            $table->tinyInteger('schema_status')->nullable();
            $table->tinyInteger('correlation_id')->nullable();
            $table->tinyInteger('sale_status')->nullable();
            $table->tinyInteger('sale_sub_status')->nullable(); 
            $table->string('sale_status_id',50)->nullable(); 
            $table->string('subaffiliate_referral_title')->nullable();
            $table->string('subaffiliate_referral_code')->nullable();
            $table->tinyInteger('is_unique');
            $table->string('access_remarketing');
            $table->tinyInteger('sale_completed_by')->comment('1 => Customer , 2 => Agent');
            $table->tinyInteger('sale_com_type')->nullable();
            $table->tinyInteger('resale_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_products');
    }
}
