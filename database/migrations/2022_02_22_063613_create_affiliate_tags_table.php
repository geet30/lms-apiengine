<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

if (!class_exists("CreateAffiliateTagsTable")) {
    class CreateAffiliateTagsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('affiliate_tags', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('affiliate_id');
                $table->unsignedInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->unsignedBigInteger('tag_id');
                $table->tinyInteger('is_cookies')->default(0);
                $table->tinyInteger('is_advertisement')->default(0);
                $table->tinyInteger('is_remarketing')->default(0);
                $table->tinyInteger('is_any_time')->default(0);
                $table->tinyInteger('status')->default(0);
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
            Schema::dropIfExists('affiliate_tags');
        }
    }
}
