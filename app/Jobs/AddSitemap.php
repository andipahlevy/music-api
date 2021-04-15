<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\SiteMap;

class AddSitemap implements ShouldQueue
{
    use   InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
	
	protected $param;
	protected $where;
	
    public function __construct($where, $data)
    {
        $this->param = $data;
        $this->where = $where;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		SiteMap::updateOrCreate($this->where, $this->param);
    }
}
