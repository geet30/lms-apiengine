<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_parameters', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('service_id');
            $table->string('key',100)->nullble()->default(NULL);
            $table->tinyInteger('key_local_id')->nullable()->default(1);
            $table->string('value',100);
            $table->integer('parameter_group')->nullable()->default(NULL)->comment('1 => Parameters , 2 => Plan_type, 3 => Sign_up_popup_form');
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
        Schema::dropIfExists('affiliate_parameters');
    }
}
