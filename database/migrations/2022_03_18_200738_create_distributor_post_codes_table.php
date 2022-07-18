<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorPostCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('distributor_post_codes')) {
            Schema::create('distributor_post_codes', function (Blueprint $table) {
                $table->id();
                $table->integer('distributor_id');
                $table->integer('post_code');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributor_post_codes');
    }
}
