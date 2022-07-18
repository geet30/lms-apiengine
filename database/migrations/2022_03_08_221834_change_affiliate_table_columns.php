<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAffiliateTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropColumn(['debit_info_password', 'facebook_url','twitter_url','instagram_url','youtube_url','linkedin_url','google_plus_url']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
