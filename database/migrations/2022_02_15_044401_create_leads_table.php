<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id('lead_id'); 
            $table->bigInteger('visitor_id')->unsigned()->index()->nullable();
            $table->foreign('visitor_id')->references('id')->on('visitors');
            $table->unsignedInteger('affiliate_id');
            $table->unsignedInteger('sub_affiliate_id')->nullable();
            $table->unsignedInteger('sale_source_id')->nullable();

            $table->integer('api_key_id')->unsigned()->index()->nullable();
            $table->foreign('api_key_id')->references('id')->on('affiliate_keys');

            $table->string('post_code')->nullable();
            
            $table->tinyInteger('affiliate_portal_type')->default(1);
            $table->string('referal_code')->nullable();
            $table->string('referal_title')->nullable();
            $table->tinyInteger('is_duplicate')->nullable()->comment('0 => No Duplicate , 1 => Duplicate'); 
            $table->tinyInteger('visitor_source')->nullable()->comment('1 => API , 2 => Agent , 3 => Manual');
            $table->tinyInteger('sale_source')->nullable()->comment('1 => Email , 2 => SMS'); 
            $table->string('sale_comment')->nullable();
            $table->integer('sale_submission_attempt')->nullable();
            $table->integer('connection_address_id')->nullable();
            $table->tinyInteger('billing_preference')->nullable();
            $table->integer('billing_address_id')->nullable();
            $table->integer('billing_po_box_id')->nullable();
            $table->tinyInteger('status')->nullable()->comment('0 => Visit , 1 => Lead, 1 => Sale');
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
        Schema::dropIfExists('leads');
    }
}
