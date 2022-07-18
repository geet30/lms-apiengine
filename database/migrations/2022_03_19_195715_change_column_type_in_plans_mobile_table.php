<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTypeInPlansMobileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('plans_mobile', 'cost_type_id')) {
            Schema::table('plans_mobile', function (Blueprint $table) {
                $table->integer('cost_type_id')->change();                
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
        if (Schema::hasColumn('plans_mobile', 'cost_type_id')) {
            Schema::table('plans_mobile', function (Blueprint $table) {
                $table->text('cost_type_id')->change();                
            });
        }
    }
}
