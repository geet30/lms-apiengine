<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('provider_id');
            $table->integer('state_id')->nullable();
            $table->string('title')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->enum('type',[1,2,3,4,6,7,8,9,10,11,12,13,14,15,16,17])->comment("
                1 => comman_plan,
                2 => promo_plan,
                3 => cis_content,
                4 => credit_check,
                5 => direct_debit,
                6 => poring_and_transfer,
                7 => privacy_policy,
                8 => fairgo_policy,
                9 => why_us,
               10 => paper_bill_content,
               11 => what_happen_next,
               12 => pop_up_content,
               13 => footer,
               14 => state_consent,
               15 => satellite_eic,
               16 => tele_sale_eic,
               17 => acknowledgement"
            );
            $table->string('description')->nullable();
            $table->text('e_billing_preference_option')->nullable();
            $table->text('why_us')->nullable();
            $table->tinyInteger('service_type')->nullable()->comment("
               0 => energy,
               1 => mobile,
               2 => broadband

                ");
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
        Schema::dropIfExists('provider_contents');
    }
}
