<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connection_types', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->string('name')->nullable();
            $table->integer('connection_type_id')->nullable(); 
            $table->text('script')->nullable(); 
            $table->tinyInteger('status');
            $table->tinyInteger('is_deleted')->nullable(); 
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
        Schema::dropIfExists('connection_types');
    }
}
