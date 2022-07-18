<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanAddonMasterTechTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_addon_master_tech_types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('addon_id');
            $table->foreign('addon_id')->references('id')->on('plan_addons_master')->onDelete('cascade'); 
            $table->tinyInteger('tech_type');   
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
        Schema::dropIfExists('plan_addon_master_tech_types');
    }
}
