<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderLogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_logos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('category_id');
            $table->text('name')->nullable();
            $table->string('url');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('provider_logos');
    }
}
