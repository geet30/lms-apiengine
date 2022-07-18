<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignedUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('source_user_id');
            $table->integer('relational_user_id');
            $table->tinyInteger('relation_type')->comment('1 affiliate-provider, 2 affiliate-user, 3 subaffiliate-user, 4 subaffiliate-provider');
            $table->tinyInteger('status')->default(0)->comment('0 Disabled 1 Enabled');
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
        Schema::dropIfExists('assigned_users');
    }
}
