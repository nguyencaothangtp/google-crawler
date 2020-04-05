<?php

namespace App\Jobs;

class CrawlSiteJob extends Job
{
    /**
     * The uploaded filename with full path.
     *
     * @param string
     */
    private $file;

    /**
     * Create a new job instance.
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
