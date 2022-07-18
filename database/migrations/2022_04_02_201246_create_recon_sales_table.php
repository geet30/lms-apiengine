<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReconSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recon_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->index()->nullable();
            $table->foreign('lead_id')->references('lead_id')->on('leads');
            $table->string('sale_reference_no')->nullable();
            $table->string('recon_reference_no')->nullable();
            $table->unsignedBigInteger('affiliate_id')->index()->nullable();
            $table->unsignedBigInteger('parent_id')->index()->nullable();
            $table->string('file_name')->nullable();
            $table->boolean('lead_status')->nullable();
            $table->boolean('energy_type')->index()->nullable();
            $table->boolean('recon_status')->nullable();
            $table->longText('last_updated_columns')->nullable();
            $table->string('last_updated_by')->nullable();
            $table->timestamp('sale_created')->nullable();
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
        Schema::dropIfExists('recon_sales');
    }
}
