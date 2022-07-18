<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderPostcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_postcodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('provider_id')->nullable();
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->unsignedBigInteger('distributor_id')->nullable();
            $table->foreign('distributor_id')->references('id')->on('distributors');
            $table->integer('postcode')->nullable();
            $table->string('state')->nullable();
            $table->string('suburb_id')->nullable();
            $table->tinyInteger('type')->nullable()->comment('0: provider postcode, 1: Suburb');
            $table->tinyInteger('status')->nullable()->comment('0: In-Active, 1: Active');
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
        Schema::dropIfExists('provider_postcodes');
    }
}
