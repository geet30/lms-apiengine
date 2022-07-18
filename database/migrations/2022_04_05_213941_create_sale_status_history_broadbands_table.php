<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleStatusHistoryBroadbandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_status_history_broadbands', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_products_broadband_id');
            $table->integer('user_id');
            $table->tinyInteger('status');
            $table->tinyInteger('sub_status')->nullable();
            $table->string('comment');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_status_history_broadbands');
    }
}
