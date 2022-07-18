<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->index()->nullable();
            $table->foreign('lead_id')->references('lead_id')->on('leads');
            $table->bigInteger('visitor_id')->unsigned()->index()->nullable();
            $table->foreign('visitor_id')->references('id')->on('visitors');
            $table->string('phone')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });

        Schema::table('visitors', function (Blueprint $table) {
            $table->after('dob', function ($table) {
                $table->string('phone')->nullable();    
            });           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitor_logs');
    }
}
