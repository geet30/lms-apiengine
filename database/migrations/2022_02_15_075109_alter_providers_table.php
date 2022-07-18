<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->Integer('user_id')->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('service_id')->after('user_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('legal_name')->after('name');
            $table->mediumInteger('abn_acn_no')->nullable()->after('legal_name');
            $table->string('support_email')->nullable()->after('abn_acn_no');
            $table->string('complaint_email')->nullable()->after('support_email');
            $table->string('description')->nullable()->after('complaint_email');
            $table->tinyInteger('status')->default(0)->comment('0 Disabled 1  Enabled')->after('demand_usage_check');
            $table->tinyInteger('is_deleted')->default(0)->comment('0 Disabled 1  Enabled')->after('status');
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
