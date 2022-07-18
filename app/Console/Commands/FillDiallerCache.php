<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use DB;

class FillDiallerCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:ignoredata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command used to add dialler ignore data into redis cache';

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
        // $diallerData = DB::connection('mysql2')->table('dialler_settings')->select('type','type_value')->get()->toArray();
        // dd($diallerData);
        // Redis::del('ignored:ip');
        $domain = Redis::get('ignored:430559457');
        dd($domain);
        // dd($domain);
        // foreach ($diallerData as $data) {
        //     Redis::set('ignored:' .$data->type_value, $data->type_value);
        // } 
        return 0;
    }
}
