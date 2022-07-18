<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowPlanfeatureInProviderContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('provider_contents', function (Blueprint $table) {
            $table->json('show_plan_on')->after('e_billing_preference_option')->nullable()->comment('1=Online,2=Telesales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_contents', function (Blueprint $table) {
            $table->dropColumn('show_plan_on');
        });
    }
}
