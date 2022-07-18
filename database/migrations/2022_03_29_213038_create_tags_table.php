<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('service_id')->comment('1 => energy, 2 => mobile, 3=> broadband');
            $table->tinyInteger('is_highlighted');
            $table->tinyInteger('is_one_in_state');
            $table->tinyInteger('is_top_of_list');
            $table->tinyInteger('set_for_all_plans');
            $table->tinyInteger('rank')->nullable();
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
        Schema::dropIfExists('tags');
    }
}
