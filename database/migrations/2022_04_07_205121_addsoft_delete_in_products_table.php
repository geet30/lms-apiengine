<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddsoftDeleteInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_products_energy', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_products_energy', 'deleted_at')) {
                $table->softDeletes();
            }
        });
        Schema::table('sale_products_broadband', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_products_broadband', 'deleted_at')) {
                $table->softDeletes();
            }
            
        });
        Schema::table('sale_products_mobile', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_products_mobile', 'deleted_at')) {
                $table->softDeletes();
            }
            
        });

        $tables = DB::select('SHOW TABLES');
        $dbName = DB::getDatabaseName();
        foreach($tables as $dbtable)
        {
            Schema::table($dbtable->{'Tables_in_'.$dbName}, function (Blueprint $table) use($dbtable) {
                $dbName = DB::getDatabaseName();
                echo "<pre>";echo $dbtable->{'Tables_in_'.$dbName};
                if (Schema::hasColumn($dbtable->{'Tables_in_'.$dbName}, 'created_at')) {
                    DB::select('update '.$dbtable->{'Tables_in_'.$dbName}.' set created_at="2021-03-15 23:40:30" where created_at is null;');
                    DB::select('ALTER TABLE `'.$dbtable->{'Tables_in_'.$dbName}.'`
                        CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                    ');
                }

                if (Schema::hasColumn($dbtable->{'Tables_in_'.$dbName}, 'updated_at')) {
                    DB::select('update '.$dbtable->{'Tables_in_'.$dbName}.' set updated_at="2021-03-15 23:40:30" where updated_at is null;');
                    DB::select('ALTER TABLE `'.$dbtable->{'Tables_in_'.$dbName}.'`
                        CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP;
                    ');
                }
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
        Schema::table('sale_products_energy', function (Blueprint $table) {
            //
        });
    }
}
