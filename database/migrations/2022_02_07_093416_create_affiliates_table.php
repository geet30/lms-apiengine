<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class CreateAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->increments('id')->change();
        });

        Schema::create('affiliates', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(User::class);
            $table->integer('parent_id');
            $table->string('legal_name');
            $table->string('company_name');
            $table->string('sender_id', 32);
            $table->string('support_phone_number');
            $table->string('lead_export_password');
            $table->string('sale_export_password');
            $table->tinyInteger('generate_token')->nullable();
            $table->tinyInteger('show_agent_portal')->nullable();
            $table->tinyInteger('sub_affiliate_type')->default(1)->comment('1 Referral 2  White label');
            $table->string('referral_code_url')->nullable();
            $table->string('referral_code_title')->nullable();
            $table->mediumInteger('referal_code')->nullable();
            $table->string('logo')->nullable();
            $table->string('dedicated_page')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('google_plus_url')->nullable();
            $table->smallInteger('lead_data_in_cookie')->comment('sub_aff_cookie_interval')->nullable();
            $table->smallInteger('lead_ownership_days_interval')->comment('data_interval used in api-controller to check_leads_from_last_days')->nullable();
            $table->string('debit_info_password')->nullable();
            $table->tinyInteger('allow_credit_score')->nullable();
            $table->tinyInteger('default_credit_score')->nullable();
            $table->smallInteger('allow_default_credit_score')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 Disabled 1  Enabled');
            $table->tinyInteger('is_deleted')->default(0)->comment('0 Disabled 1  Enabled');
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
        Schema::dropIfExists('affiliates');
    }
}
