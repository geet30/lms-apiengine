<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_states', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamp('deleted_at')->nullable(); 
            $table->timestamps();
        });
        \DB::table('provider_states')->insert([
            [
                'id' => 1,
                'name' => 'ACT',
                'status' => 1
            ],
            [
                'id' => 2,
                'name' => 'NSW',
                'status' => 1,
            ],
            [
                'id' => 3,
                'name' => 'NT',
                'status' => 1
            ],
            [
                'id' => 4,
                'name' => 'QLD',
                'status' => 1
            ],
            [
                'id' => 5,
                'name' => 'SA',
                'status' => 1
            ],
            [
                'id' => 6,
                'name' => 'TAS',
                'status' => 1
            ],
            [
                'id' => 7,
                'name' => 'VIC',
                'status' => 1
            ],
            [
                'id' => 8,
                'name' => 'WA',
                'status' => 1
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provider_states');
        \DB::table('provider_states')->whereIn('id',[1,2,3,4,5,6,7,8])->delete();
    }
}
