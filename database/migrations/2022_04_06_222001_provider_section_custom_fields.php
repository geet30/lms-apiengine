<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProviderSectionCustomFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('provider_section_custom_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('section_id');
            $table->string('label', 100);
            $table->string('placeholder',100);
            $table->tinyInteger('mandatory');
            $table->text('message');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_section_custom_fields');
    }
}
