<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectionAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_product_energy_connection_details', function (Blueprint $table) {
            $table->id();
            $table->integer('connection_post_code')->nullable();
            $table->string('connection_suburb')->nullable();
            $table->string('connection_state')->nullable();
            $table->string('connection_street_number')->nullable();
            $table->string('connection_street_name')->nullable();
            $table->string('manually_connection_address')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });

        Schema::table('sale_products_energy', function (Blueprint $table) {
            $table->after('moving_at', function ($table) {
                $table->unsignedBigInteger('connection_address_id')->index()->nullable();
                $table->foreign('connection_address_id')->references('id')->on('sale_product_energy_connection_details'); 
            });           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connection_addresses');
    }
}
