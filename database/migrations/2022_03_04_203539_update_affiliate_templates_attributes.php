<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAffiliateTemplatesAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('affiliate_templates')) {
            Schema::table('affiliate_templates', function (Blueprint $table) {
                $table->string('sender_id', 50)->nullable()->change();
                $table->tinyInteger("sender_id_method")->after('sender_id')->nullable()->comment("1=>default,2=>custom,3=>2way");
                $table->bigInteger('plivo_number')->nullable()->change();
            });
        }
        if (!Schema::hasColumn('affiliate_templates', 'source_type')) {
            Schema::table('affiliate_templates', function (Blueprint $table) {
                $table->tinyInteger('source_type')->after('status')->nullable()->comment('1=>Bitly,2=>Rebrandly');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliate_templates', function (Blueprint $table) {
            $table->dropColumn('sender_id_method');
            $table->string('sender_id', 50)->nullable()->change();
            $table->integer('plivo_number')->nullable()->change();
        });
    }
}
