<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

use Illuminate\Support\Facades\Redis;
class SetApplicationPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:load-application-permission';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $permissoionData =  DB::table('application_permissions')->pluck('permission_id')->toArray(); 
        $assignPermissions = DB::table('permissions')->whereIn('id',$permissoionData)->pluck('name')->toArray();   
        Redis::set('application_permission', json_encode($assignPermissions)); 
        print_r('Permissions loaded successfully.');
    }
}
