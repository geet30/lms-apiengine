<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowPlanfeatureInPlansEnergyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans_energy', function($table) {
            $table->json('show_planfeatures_on')->after('payment_options')->nullable()->comment('1=Online,2=Telesales');
        });
    }
public function down()
    {
        Schema::table('plans_energy', function (Blueprint $table) {

            // 1. Create new column
            $table->dropColumn('show_planfeatures_on');
        });
    }
}
