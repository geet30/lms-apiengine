<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleProductsBroadbandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_products_broadband', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_product_id');
            $table->integer('lead_id');
            $table->unsignedInteger('service_id');
            $table->tinyInteger('product_type')->default(0);
            $table->unsignedInteger('provider_id')->nullable();
            $table->bigInteger('plan_id')->nullable();
            $table->tinyInteger('cost_type')->nullable();
            $table->decimal('cost',5,2)->nullable();
            $table->string('reference_no',50)->nullable();
            $table->tinyInteger('is_moving')->comment('0 => No , 1 => Yes');
            $table->timestamp('moving_at')->nullable();
            $table->timestamp('sale_created_at')->nullable();
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
        Schema::dropIfExists('sale_products_broadbands');
    }
}
