<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderDirectDebitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_direct_debits', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->tinyText('payment_method_type')->nullable();
            $table->string('card_information')->nullable();
            $table->string('bank_information')->nullable();
            $table->enum('is_card_content',[0,1])->nullable();
            $table->enum('is_bank_content',[0,1])->nullable();
            $table->enum('status',[0,1])->nullable();
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
        Schema::dropIfExists('provider_direct_debits');
    }
}
