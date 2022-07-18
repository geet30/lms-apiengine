<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateParamters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_paramters', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('user_id');
            $table->Integer('service_id');
            $table->string('plan_listing', 10);
            $table->string('plan_detail', 10);
            $table->string('remarketing', 10);
            $table->string('slug')->nullable();
            $table->string('terms')->nullable();
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
        Schema::dropIfExists('affiliate_paramters');
    }
}
