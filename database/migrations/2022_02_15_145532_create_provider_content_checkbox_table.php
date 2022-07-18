<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderContentCheckboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_content_checkboxes', function (Blueprint $table) {
            $table->id();
            $table->integer('provider_content_id');
            $table->enum('checkbox_required',[0,1])->default(0);
            $table->string('validation_message');
            $table->string('content');
            $table->boolean('status')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('provider_content_checkbox');
    }
}
