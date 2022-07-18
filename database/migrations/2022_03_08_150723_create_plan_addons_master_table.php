<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanAddonsMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_addons_master', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('category')->comment('3 => home connection, 4 => modem, 5 => additional addons');
            $table->tinyInteger('service_id')->comment('1 => energy, 2 => mobile, 3=> broadband');
            $table->unsignedInteger('provider_id')->nullable();
            $table->foreign('provider_id')->references('user_id')->on('providers')->onDelete('cascade'); 
            $table->string('name')->nullable();
            $table->text('description');
            $table->integer('cost_type_id')->nullable();
            $table->decimal('cost', 8,2)->nullable();
            $table->integer('connection_type')->nullable();
            $table->text('inclusion')->nullable();
            $table->text('script')->nullable();
            $table->tinyInteger('status'); 
            $table->integer('order')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('plan_addons_master');
    }
}
