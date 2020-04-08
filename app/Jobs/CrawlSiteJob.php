<?php

namespace App\Jobs;

use App\Exceptions\CrawlException;
use App\Helpers\Helper;
use App\KeywordStatistic;
use Serps\Exception;
use Serps\SearchEngine\Google\Exception\InvalidDOMException;

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
     * @throws Exception
     * @throws InvalidDOMException
     */
    public function handle()
    {
        $keywords = Helper::readCSV($this->filePath);
        foreach ($keywords as $keyword) {
            try {
                $keywordStats = Helper::crawlGoogleByKeyword($keyword);

                //Save keyword statistics to database
                KeywordStatistic::create($keywordStats);

                sleep(5); // delay between each crawl
            } catch (CrawlException $e) {
                echo $e->getMessage() . "\n"; // write error to worker's log
            }
        }
    }
}
