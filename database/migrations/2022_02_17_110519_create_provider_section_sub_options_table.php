<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderSectionSubOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_section_sub_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('section_option_id');
            $table->unsignedInteger('section_sub_option_id');
            $table->tinyInteger('section_sub_option_status')->default(0)->comment('0 Disabled 1  Enabled');
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
        Schema::dropIfExists('provider_section_sub_options');
    }
}
