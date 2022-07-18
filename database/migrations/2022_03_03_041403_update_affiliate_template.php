<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAffiliateTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('affiliate_templates')) {
            Schema::table('affiliate_templates', function (Blueprint $table) {
                $table->time('remarketing_time')->after('select_remarketing_type')->nullable();
                $table->renameColumn("sms_delay_time", "delay_time");
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliate_templates', function (Blueprint $table) {
            $table->dropColumn('remarketing_time');
            $table->renameColumn("delay_time", "sms_delay_time");
        });
    }
}
