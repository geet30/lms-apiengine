<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bank_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('account_type')->comment('1: Card, 2: Bank')->nullable();
            $table->string('account_no', 99)->nullable();
            $table->string('account_holder_name', 99)->nullable();
            $table->string('abn', 99)->nullable();
            $table->string('bsb_code', 99)->nullable();
            $table->string('first_six', 99)->nullable();
            $table->string('last_four', 99)->nullable();
            $table->string('exp_month', 99)->nullable();
            $table->string('exp_year', 99)->nullable();
            $table->string('cvv', 99)->nullable();
            $table->string('card_type', 99)->nullable();
            $table->string('reference_number', 99)->nullable();
            $table->string('token', 99)->nullable();
            $table->string('token_hMAC', 99)->nullable();
            $table->boolean('is_valid')->comment('0: Invalid, 1: Valid')->nullable();
            $table->boolean('is_cvv_valid')->comment('0: Invalid, 1: Valid')->nullable();
            $table->boolean('type')->nullable();
            $table->boolean('attempt')->nullable();
            $table->boolean('attempt_time')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });

        Schema::table('affiliates', function (Blueprint $table) {
            $table->after('dedicated_page', function ($table) {
                $table->string('youtube_url', 150)->nullable();
                $table->string('twitter_url', 150)->nullable();
                $table->string('facebook_url', 150)->nullable();
                $table->string('linkedin_url', 150)->nullable();
                $table->string('google_url', 150)->nullable();
            });           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bank_details');
    }
}
