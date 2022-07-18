<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogoResolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logo_resolutions', function (Blueprint $table) {
            $table->id();
            $table->integer('height');
            $table->integer('width');
            $table->integer('category_id');
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
        Schema::dropIfExists('logo_resolutions');
    }
}
