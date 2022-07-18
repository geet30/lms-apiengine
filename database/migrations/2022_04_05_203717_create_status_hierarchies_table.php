<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusHierarchiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_hierarchies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->unsignedBigInteger('assigned_status_id');
            $table->foreign('assigned_status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->tinyInteger('type')->comment('1 => status, 2 => sub status');
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
        Schema::dropIfExists('status_hierarchies');
    }
}
