<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateIdmatrixTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('affiliate_idmatrix', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger("foreign_passport")->default('0');
            $table->tinyInteger("medicare_card")->default('0');
            $table->tinyInteger("driver_license")->default('0');
            $table->tinyInteger("australian_passport")->default('0');
            $table->tinyInteger('matrix_content_key_enable')->default('0');
            $table->string('matrix_content')->nullable();
            $table->tinyInteger('id_matrix_enable')->default('0');
            $table->tinyInteger('status')->default('0');
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
        Schema::dropIfExists('affiliate_idmatrix');
    }
}
