<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersIpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers_ips', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('ips')->nullable();
            $table->string('ip_range')->nullable();
            $table->string('token')->nullable();
            $table->string('debit_info_csv_password')->nullable();
            $table->string('debit_info_csv_ip')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('providers_ips');
    }
}
