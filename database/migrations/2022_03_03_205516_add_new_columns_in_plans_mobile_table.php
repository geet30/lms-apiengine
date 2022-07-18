<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsInPlansMobileTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::table('plans_mobile', function (Blueprint $table) {
            if (!Schema::hasColumn('plans_mobile', 'business_size')) {
                $table->tinyInteger('business_size')->after('plan_type')->nullable();
            }
            if (!Schema::hasColumn('plans_mobile', 'cost_type_id')) {
                $table->text('cost_type_id')->after('business_size')->nullable();
            }
            if (!Schema::hasColumn('plans_mobile', 'bdm_available')) {
                $table->tinyInteger('bdm_available')->after('business_size')->nullable();
            }
            if (!Schema::hasColumn('plans_mobile', 'bdm_contact_number')) {
                $table->string('bdm_contact_number',20)->after('bdm_available')->nullable();
            }
            if (!Schema::hasColumn('plans_mobile', 'bdm_details')) {
                $table->text('bdm_details')->after('bdm_contact_number')->nullable();
            }
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans_mobile', function (Blueprint $table) {
            if (Schema::hasColumn('plans_mobile', 'business_size')) {
                $table->dropColumn('business_size');
            }
            if (Schema::hasColumn('plans_mobile', 'cost_type_id')) {
                $table->dropColumn('cost_type_id');
            }
            if (Schema::hasColumn('plans_mobile', 'bdm_available')) {
                $table->dropColumn('bdm_available');
            }
            if (Schema::hasColumn('plans_mobile', 'bdm_contact_number')) {
                $table->dropColumn('bdm_contact_number');
            }
            if (Schema::hasColumn('plans_mobile', 'bdm_details')) {
                $table->dropColumn('bdm_details');
            }
        });
    }
}
