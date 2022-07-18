<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogoCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logo_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('logo_categories');
    }
}
