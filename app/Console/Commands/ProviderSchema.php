<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Providers\SchemaController;
use App\Models\Providers;

class ProviderSchema extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:schema';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command used to send schema for all providers';

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
     * Send schema for Move in and cor sales.
     *
     * @return int
     */
    public function handle()
    {
        $schema = new SchemaController(new Providers);
        $schema->sendProviderMoveInSaleSchema();
        $schema->sendProviderCorSaleSchema();
        return 0;
    }
}