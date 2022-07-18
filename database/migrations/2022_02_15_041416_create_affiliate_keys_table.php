<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

if (!class_exists('CreateAffiliateKeysTable')) {

    class CreateAffiliateKeysTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('affiliate_keys', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->string('name', 99);
                $table->string('api_key', 99);
                $table->string('page_url', 255);
                $table->string('origin_url', 255)->nullable();
                $table->mediumInteger('rc_code')->nullable();
                $table->tinyInteger('is_default')->default(0)->comment('0 Disabled 1  Enabled');
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
            Schema::dropIfExists('affiliate_keys');
        }
    }
}
