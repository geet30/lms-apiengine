<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('affiliate_id');
            $table->integer('service_id')->nullable();
            $table->string('api_name', 99)->comment('Store the api name like detokenization or Tokenization');
            $table->tinyInteger('api_status')->comment('Store the api status like 200 or 500');
            $table->text('api_response')->nullable()->comment('store the api response');
            $table->text('api_request')->comment('Store the body request ');
            $table->string('phone', 15);
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
        Schema::dropIfExists('sms_logs');
    }
}
