<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('postcodes')) {
            Schema::create('postcodes', function (Blueprint $table) {
                $table->id();
                $table->integer('postcode')->nullable();
                $table->string('suburb',100)->nullable();
                $table->string('state',4)->nullable();
                $table->decimal('latitude',6,3)->nullable();
                $table->decimal('longitude',6,3)->nullable();
                $table->tinyInteger('status')->default(1)->comment('1 Enable 0 Disable');
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
        Schema::dropIfExists('postcodes');
    }
}
