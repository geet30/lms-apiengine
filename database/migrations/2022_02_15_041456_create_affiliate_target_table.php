<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

if (!class_exists('CreateAffiliateTargetTable')) {

    class CreateAffiliateTargetTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('affiliate_target', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->integer('target_value');
                $table->string('sales', 255);
                $table->integer('target_month');
                $table->integer('target_year');
                $table->text('comment')->nullable();
                $table->tinyInteger('status')->default(0)->comment('0 Disabled 1  Enabled');
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
            Schema::dropIfExists('affiliate_target');
        }
    }
}
