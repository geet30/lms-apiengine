<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateUnsubscribeSources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_unsubscribe_sources', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('unsubscribe_source')->nullable()->comment('1 Email 2  Sms');
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
        Schema::dropIfExists('affiliate_unsubscribe_sources');
    }
}
