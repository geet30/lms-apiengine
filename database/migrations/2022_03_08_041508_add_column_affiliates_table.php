<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('affiliates')) {
            Schema::table('affiliates', function (Blueprint $table) {
                $table->timestamp("restricted_start_time")->after('status')->nullable();
                $table->timestamp("restricted_end_time")->after('status')->nullable();
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
        Schema::table('affiliates', function (Blueprint $table) {
            $table->dropColumn('restricted_end_time');
            $table->dropColumn('restricted_start_time');
        });
    }
}
