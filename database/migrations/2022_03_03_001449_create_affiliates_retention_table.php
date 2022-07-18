<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

if (!class_exists('CreateAffiliatesRetentionTable')) {
    class CreateAffiliatesRetentionTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('affiliates_retention', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->tinyInteger('service_id')->comment('1 Energy 2  mobile 3 broadband');
                $table->tinyInteger('provider_id')->comment();
                $table->tinyInteger('master_retention_allow')->comment('retetion allow for affilaite and subaffilaite');
                $table->tinyInteger('retention_allow')->comment('retetion allow for only by user_id');
                $table->tinyInteger('type')->comment('1 aff 2 subaff');
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
            Schema::dropIfExists('affiliates_retention');
        }
    }
}
