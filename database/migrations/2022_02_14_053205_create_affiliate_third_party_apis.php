<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateThirdPartyApis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_third_party_apis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('third_party_platform')->nullable()->comment('1 Spark Post, 2 Twillo, 3 Plivo, 4 Rapid API');
            $table->string('spark_post_api_key', 255)->nullable();
            $table->string('affiliate_sub_acc_id', 255)->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 Disabled 1  Enabled');
            $table->tinyInteger('is_deleted')->default(0)->comment('0 Disabled 1  Enabled');
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('affiliate_third_party_apis');
    }
}
