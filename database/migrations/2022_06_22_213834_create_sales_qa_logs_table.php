<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesQaLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sale_logs')->create('sales_qa_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('lead_id');
            $table->string('reference_no',255)->default(NULL)->nullable();
            $table->string('ip',255)->default(NULL)->nullable();
            $table->integer('action')->default(NULL)->nullable()->comment('1 (Assign QA) 2 (Assign Collaborators) 3 (Un-assign QA) 4 (Un-assign Collaborators) 5 ( Start QA) 6 ( End QA) 7 ( Pause/Hold QA)');
            $table->integer('assign_user_id')->default(NULL)->nullable();
            $table->integer('action_performed_by')->default(NULL)->nullable();
            $table->text('comment')->default(NULL)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_qa_logs');
    }
}
