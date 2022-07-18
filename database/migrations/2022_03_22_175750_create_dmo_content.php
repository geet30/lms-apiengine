<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDmoContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dmo_content', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_rate_id');
            $table->foreign('plan_rate_id')->references('id')->on('energy_plan_rates')->onDelete('cascade');
            $table->text('dmo_vdo_content')->nullable();
            $table->tinyInteger('type')->comment('1 plan 2 master');
            $table->tinyInteger('variant')->comment('if type:1 => 1: plan dmo,2:tele_dmo,3: static_dmo, if type:2 => 1: without cond discount, 2: with pay time discount, 3: with direct debit discount, 4: with both pay on time and direct debit discount');
            $table->tinyInteger('dmo_content_status')->nullable();
            $table->string('lowest_annual_cost')->nullable();
            $table->tinyInteger('without_conditional')->nullable();
            $table->string('without_conditional_value')->nullable();
            $table->tinyInteger('with_conditional')->nullable();
            $table->string('with_conditional_value')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('dmo_content');
    }
}
