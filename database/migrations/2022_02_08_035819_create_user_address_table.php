<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class CreateUserAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            // $table->unsignedInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(User::class);
            $table->tinyInteger('address_type')->comment('1 residential, 2 previous, 3 business, 4 billing');
            $table->string('lot_number', 50)->nullable();
            $table->string('unit_number', 50)->nullable();
            $table->string('unit_type', 50)->nullable();
            $table->string('unit_type_code', 50)->nullable();
            $table->string('floor_number', 50)->nullable();
            $table->string('floor_level_type', 50)->nullable();
            $table->string('floor_type_code', 50)->nullable();
            $table->string('street_number', 50)->nullable();
            $table->string('street_number_suffix', 50)->nullable();
            $table->string('street_name', 50)->nullable();
            $table->string('street_suffix', 50)->nullable();
            $table->string('street_code', 50)->nullable();
            $table->string('house_number', 50)->nullable();
            $table->string('house_number_suffix', 50)->nullable();
            $table->string('suburb', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('postcode', 50)->nullable();
            $table->string('property_name', 50)->nullable();
            $table->string('residential_status', 50)->nullable();
            $table->string('living_year', 50)->nullable();
            $table->string('living_month', 50)->nullable();
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
        Schema::dropIfExists('user_address');
    }
}
