<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansMobileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_mobile', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('provider_id')->nullable();
            $table->string('name')->nullable();
            $table->tinyInteger('connection_type')->nullable();
            $table->tinyInteger('plan_type')->nullable();
            $table->decimal('cost',5,2)->nullable();
            $table->integer('plan_data')->nullable();
            $table->tinyInteger('plan_data_unit')->nullable();
            $table->string('network_type')->nullable();
            $table->integer('contract_id')->nullable();
            $table->timestamp('activation_date_time')->nullable();
            $table->timestamp('deactivation_date_time')->nullable();
            $table->text('inclusion')->nullable();
            $table->text('details')->nullable();
            $table->tinyInteger('new_connection_allowed')->comment('0 = No, 1 = yes')->default(0);
            $table->tinyInteger('port_allowed')->comment('0 = No, 1 = yes')->default(0);
            $table->tinyInteger('retention_allowed')->comment('0 = No, 1 = yes')->default(0);
            $table->text('amazing_extra_facilities')->nullable();
            $table->string('national_voice_calls')->nullable();
            $table->string('national_video_calls')->nullable();
            $table->string('national_text')->nullable();
            $table->string('national_mms')->nullable();
            $table->string('national_directory_assist')->nullable();
            $table->string('national_diversion')->nullable();
            $table->string('national_call_forwarding')->nullable();
            $table->string('national_voicemail_deposits')->nullable();
            $table->string('national_toll_free_numbers')->nullable();
            $table->text('national_internet_data')->nullable();
            $table->text('national_special_features')->nullable();
            $table->text('national_additonal_info')->nullable();
            $table->string('international_voice_calls')->nullable();
            $table->string('international_video_calls')->nullable();
            $table->string('international_text')->nullable();
            $table->string('international_mms')->nullable();
            $table->string('international_diversion')->nullable();
            $table->text('international_additonal_info')->nullable();
            $table->string('roaming_charge')->nullable();
            $table->string('roaming_voice_incoming')->nullable();
            $table->string('roaming_voice_outgoing')->nullable();
            $table->string('roaming_video_calls')->nullable();
            $table->string('roaming_text')->nullable();
            $table->string('roaming_mms')->nullable();
            $table->string('roaming_voicemail_deposits')->nullable();
            $table->text('roaming_internet_data')->nullable();
            $table->text('roaming_additonal_info')->nullable();
            $table->string('cancellation_fee')->nullable();
            $table->string('lease_phone_return_fee')->nullable();
            $table->string('activation_fee')->nullable();
            $table->string('late_payment_fee')->nullable();
            $table->string('delivery_fee')->nullable();
            $table->string('express_delivery_fee')->nullable();
            $table->string('paper_invoice_fee')->nullable();
            $table->string('payment_processing_fee')->nullable();
            $table->string('card_payment_fee')->nullable();
            $table->string('minimum_total_cost')->nullable();
            $table->text('other_fee_charges')->nullable()->nullable();
            $table->tinyInteger('remarketing_allow')->comment('0 = No, 1 = yes')->default(0)->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at')->nullable();
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans_mobile');
    }
}
