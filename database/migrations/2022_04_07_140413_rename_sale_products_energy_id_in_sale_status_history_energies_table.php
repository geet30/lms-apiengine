<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSaleProductsEnergyIdInSaleStatusHistoryEnergiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_status_history_energies', function (Blueprint $table) {
            $table->renameColumn('sale_products_id', 'sale_product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_status_history_energies', function (Blueprint $table) {
            //
        });
    }
}
