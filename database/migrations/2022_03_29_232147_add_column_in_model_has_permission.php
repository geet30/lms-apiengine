<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInModelHasPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_has_permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('model_has_permissions','service_id')) {
                $table->tinyInteger('service_id')->default(0);
            }
        });

        DB::statement('ALTER TABLE `model_has_permissions` 
        CHANGE COLUMN `service_id` `service_id` INT(10) NOT NULL , DROP PRIMARY KEY,
        ADD PRIMARY KEY (`permission_id`, `model_id`, `model_type`, `service_id`)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('model_has_permissions', function (Blueprint $table) {
            if (Schema::hasColumn('model_has_permissions','service_id')) {
                $table->dropColumn('service_id');
            }
        });
    }
}
