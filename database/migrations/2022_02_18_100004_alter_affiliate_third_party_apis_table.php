<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAffiliateThirdPartyApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliate_third_party_apis', function (Blueprint $table) {
            $table->renameColumn('spark_post_api_key', 'api_key');
            $table->renameColumn('affiliate_sub_acc_id', 'subaccount_id');
            $table->string('subaccount_key', 255)->after('affiliate_sub_acc_id')->nullable();
            $table->string('subaccount_short_key', 255)->after('subaccount_key')->nullable();
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
