<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CheckBoxContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_box_content', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->comment("1: plan eic check box");
            $table->integer('type_id');
            $table->tinyInteger('required')->default(0);
            $table->tinyInteger('status')->nullable();
            $table->string('validation_message')->nullable();
            $table->text('content')->nullable();
            $table->text('module_type')->nullable();
            $table->tinyInteger('save_checkbox_status')->default(0);
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
        Schema::dropIfExists('check_box_content');
    }
}
