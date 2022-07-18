<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansRemarketingInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_remarketing_information', function (Blueprint $table) {
            $table->id();
            $table->integer('plan_id');
            $table->tinyInteger('remarketing_allow')->nullable();
            $table->string('discount')->nullable();
            $table->string('discount_title')->nullable();
            $table->string('contract_term')->nullable();
            $table->string('termination_fee')->nullable();
            $table->text('remarketing_terms_conditions')->nullable();
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
        Schema::dropIfExists('plan_remarketing_information');
    }
}
