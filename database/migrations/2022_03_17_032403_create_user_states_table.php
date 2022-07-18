<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_states', function (Blueprint $table) {
            $table->increments('user_state_id');
            $table->integer('user_id');
            $table->integer('state_id');
            $table->tinyInteger('user_type')->comment('1 affiliate, 2 provider, 3 role_user, 4 sub-affiliate');
            $table->tinyInteger('status')->default(1)->comment('1 Enable 2  Disable');
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
        Schema::dropIfExists('user_states');
    }
}
