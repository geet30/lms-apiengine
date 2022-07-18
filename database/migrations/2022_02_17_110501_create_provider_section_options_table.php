<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderSectionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_section_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('provider_section_id');
            $table->unsignedInteger('section_option_id');
            $table->tinyInteger('section_option_status')->default(0)->comment('0 Disabled 1  Enabled');
            $table->integer('min_value_limit')->nullable();
            $table->integer('max_value_limit')->nullable();
            $table->tinyInteger('is_required')->default(0)->comment('0 Disabled 1  Enabled');
            $table->tinyInteger('is_deleted')->default(0)->comment('0 Disabled 1  Enabled');
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
        Schema::dropIfExists('provider_section_options');
    }
}
