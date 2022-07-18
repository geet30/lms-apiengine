<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadJourneyDataBroadband extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_journey_data_broadband', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->index()->nullable();
            $table->foreign('lead_id')->references('lead_id')->on('leads');
            $table->integer('connection_type')->nullable();
            $table->text('technology_type','50')->nullable();
            $table->text('address',199)->nullable();
            $table->tinyInteger('movein_type')->default(0)->comment('0 => No , 1 => Yes');
            $table->timestamp('movein_date')->nullable();
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
        Schema::dropIfExists('lead_journey_data_broadband');
    }
}
