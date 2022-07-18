<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemarketingParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->foreign('lead_id')->references('lead_id')->on('leads');
            $table->bigInteger('customer_user_id')->unsigned()->index()->nullable();
            $table->string('utm_source', 200)->nullable();
            $table->string('utm_medium', 200)->nullable();
            $table->string('utm_campaign', 200)->nullable();
            $table->string('utm_term', 200)->nullable();
            $table->string('utm_content', 200)->nullable();
            $table->string('gclid', 200)->nullable();
            $table->string('fbclid', 200)->nullable();
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
        Schema::table('marketing', function (Blueprint $table) {
            Schema::dropIfExists('marketing');
        });
    }
}
