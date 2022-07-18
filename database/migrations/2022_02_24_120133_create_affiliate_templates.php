<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_templates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            // $table->tinyInteger('sub_email_type');
            $table->tinyInteger('type')->comment('
              1=>email,
              2=>sms
            ');
            $table->tinyInteger('email_type')->comment(
                '1=>welcome,
                 2 =>remarketing,
                 3=>confirmation
                 4=>send_plan,',
            );
            $table->integer('service_id');
            $table->string('template_name');
            $table->string('utm_name')->nullable();
            $table->string('utm_rm')->nullable();
            $table->string('utm_rm_date_status')->nullable();
            $table->string('rm_source')->nullable();
            $table->string('from_name')->nullable();
            $table->string('from_email')->nullable();
            $table->string('sending_domain')->nullable();
            $table->string('ip_pool')->nullable();
            $table->string('reply_to')->nullable();
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('select_remarketing_type')->nullable()->comment('
            normal=>1,(
            movin => 2');
            $table->tinyInteger('move_in_template')->nullable()->comment('yes=>1,no=>2');
            $table->mediumInteger('interval')->nullable();
            $table->tinyInteger('remarketing_duplicate_check')->nullable();
            $table->tinyInteger('opens_tracking')->nullable();
            $table->tinyInteger('click_tracking')->nullable();
            $table->tinyInteger('transactional')->nullable();
            $table->text('email_cc')->nullable();
            $table->text('email_bcc')->nullable();
            $table->text('content')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('branding_url')->nullable();
            $table->integer('sender_id')->nullable();
            $table->integer('plivo_number')->nullable();
            $table->tinyInteger('check_restricted_time')->nullable();
            $table->string('sms_delay_time')->nullable();
            $table->integer('template_id')->nullable();
            $table->integer('template_set_id')->nullable();
            $table->string('target_type')->nullable();
            $table->tinyInteger('immediate_sms')->nullable();
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
        Schema::dropIfExists('affiliate_templates');
    }
}
