<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

if (!class_exists("CreateMasterIdentificationDetailsTable")) {
    class CreateMasterIdentificationDetailsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('master_identification_details', function (Blueprint $table) {
                $table->increments('id');
                $table->string('options', '255');
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
            Schema::dropIfExists('master_identification_details');
        }
    }
}
