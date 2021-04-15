<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB; 
use Illuminate\Support\Facades\Cache;

class FlushCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'videv:FlushCache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apus cache';

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
     * @return mixed
     */
    public function handle()
    {
		Cache::flush();
    }
}
