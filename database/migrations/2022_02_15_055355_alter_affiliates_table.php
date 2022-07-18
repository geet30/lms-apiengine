<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliates', function (Blueprint $table) {
            $table->string('sender_id', 32)->nullable()->change();
            $table->string('support_phone_number')->nullable()->change();
            $table->boolean('sub_affiliate_type')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
