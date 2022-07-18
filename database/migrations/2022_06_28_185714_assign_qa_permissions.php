<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AssignQaPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $insertNewPermissions = DB::table('permissions')->insert([ 
            [            
                'name' => 'sale_assign_qa_section',
                'display_name' => 'sale_assign_qa_section',
                'description' => 'sale_assign_qa_section.',
                'service_id' => '0',
                'guard_name' =>'web'
            ], 
            [            
                'name' => 'sale_assign_qa_to_sale',
                'display_name' => 'sale_assign_qa_to_sale',
                'description' => 'sale_assign_qa_to_sale.',
                'service_id' => '0',
                'guard_name' =>'web'
            ],  
            [            
                'name' => 'sale_assign_collaborator_to_sale',
                'display_name' => 'sale_assign_collaborator_to_sale',
                'description' => 'sale_assign_collaborator_to_sale.',
                'service_id' => '0',
                'guard_name' =>'web'
            ], 
            [            
                'name' => 'sale_assign_sale_to_unsigned_sale',
                'display_name' => 'sale_assign_sale_to_unsigned_sale',
                'description' => 'sale_assign_sale_to_unsigned_sale.',
                'service_id' => '0',
                'guard_name' =>'web'
            ], 
        ]);

        if ($insertNewPermissions) {
            echo 'permissions added successfully';
        } else {
            echo 'permissions not added please rollback and check';
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
