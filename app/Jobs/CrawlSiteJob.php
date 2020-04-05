<?php

namespace App\Jobs;

use App\Helpers\Helper;

class CrawlSiteJob extends Job
{
    /**
     * The uploaded filename with full path.
     *
     * @param string
     */
    private $filePath;

    /**
     * Create a new job instance.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $keywords = Helper::readCSV($this->filePath);
    }
}
