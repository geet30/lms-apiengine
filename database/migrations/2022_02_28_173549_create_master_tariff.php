<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTariff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_tariffs', function (Blueprint $table) {
            $table->id();
            $table->string('tariff_type');
            $table->string('tariff_code')->nullable();
            $table->tinyInteger('master_tariff_ref_id')->nullable();
            $table->tinyInteger('property_type')->nullable()->comment('1: Residanial ,2:business');
            $table->tinyInteger('distributor_id')->nullable();
            $table->tinyInteger('units_type')->nullable()->comment('');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('master_tariffs');
    }
}
