<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('service_id');
            $table->unsignedInteger('section_id');
            $table->string('section_script', 255)->nullable();
            $table->tinyInteger('section_status')->default(0)->comment('0 Disabled 1  Enabled');
            $table->string('acknowledgement', 255)->nullable();
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
        Schema::dropIfExists('provider_sections');
    }
}
