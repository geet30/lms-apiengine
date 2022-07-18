<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateTemplateAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_template_attribute', function (Blueprint $table) {
            $table->id();

            $table->tinyInteger('source_type')->cooment('1=>email,2=>sms');
            $table->tinyInteger('service_id')->comment('
             0=>common,
             1=>energy,
             2=>mobile,
             3=>broadband');
            $table->tinyInteger('template_type')->comment(
                '0=>common,
            1=>welcome,
            2=>remarketing,
            3=>confirmation,
            4=>send_plan
            5=>remarketing_energy_broadband',

            );
            $table->string('attribute');
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
        Schema::dropIfExists('affiliate_template_attribute');
    }
}
