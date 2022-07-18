<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'name'))
            {
                $table->string('name', 255)->nullable();
            }
            if (!Schema::hasColumn('users', 'session_id'))
            {
                $table->string('session_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'role'))
            {
                $table->tinyInteger('role')->nullable();
            } 
            if (!Schema::hasColumn('users', 'status'))
            {
                $table->tinyInteger('status')->default(0);
            }
            if (!Schema::hasColumn('users', 'email_sent'))
            {
                $table->integer('email_sent')->default(0);
            }
            if (!Schema::hasColumn('users', 'token'))
            {
                $table->text('token')->nullable();
            }
            if (!Schema::hasColumn('users', 'created_by'))
            {
               $table->integer('created_by')->nullable();
            }    
            if (!Schema::hasColumn('users', 'google2fa_secret'))
            {
                $table->string('google2fa_secret', 255)->nullable();
            }
            if (!Schema::hasColumn('users', 'two_factor_recovery_codes'))
            {
                $table->text('two_factor_recovery_codes')->nullable();
            }
            if (!Schema::hasColumn('users', 'two_factor_enabled'))
            {
                $table->tinyInteger('two_factor_enabled')->default('0');
            }
            if (!Schema::hasColumn('users', 'phone'))
            {
                $table->String('phone')->nullable();
            }
            if (!Schema::hasColumn('users', 'permission_template'))
            {
                $table->string('permission_template')->nullable();
            }
            if (!Schema::hasColumn('users', 'permission_services'))
            {
                $table->text('permission_services')->nullable();
            }  
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'name'))
            {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('users', 'session_id'))
            {
                $table->dropColumn('session_id');
            }
            if (Schema::hasColumn('users', 'role'))
            {
                $table->dropColumn('role');
            } 
            if (Schema::hasColumn('users', 'status'))
            {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('users', 'email_sent'))
            {
                $table->dropColumn('email_sent');
            }
            if (Schema::hasColumn('users', 'token'))
            {
                $table->dropColumn('token');
            }
            if (Schema::hasColumn('users', 'created_by'))
            {
               $table->dropColumn('created_by');
            }    
            if (Schema::hasColumn('users', 'google2fa_secret'))
            {
                $table->dropColumn('google2fa_secret');
            }
            if (Schema::hasColumn('users', 'two_factor_recovery_codes'))
            {
                $table->dropColumn('two_factor_recovery_codes');
            }
            if (Schema::hasColumn('users', 'two_factor_enabled'))
            {
                $table->dropColumn('two_factor_enabled');
            }
            if (Schema::hasColumn('users', 'phone'))
            {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('users', 'permission_template'))
            {
                $table->dropColumn('permission_template');
            }
            if (Schema::hasColumn('users', 'permission_services'))
            {
                $table->dropColumn('permission_services');
            }
            $table->dropSoftDeletes();
        });
    }
}
