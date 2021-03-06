<?php

namespace App;

use App\Exceptions\CrawlException;
use Serps\Core\Browser\Browser;
use Serps\Exception;
use Serps\Exception\RequestError\RequestErrorException;
use Serps\HttpClient\CurlClient;
use Serps\SearchEngine\Google\Exception\InvalidDOMException;
use Serps\SearchEngine\Google\GoogleClient;
use Serps\SearchEngine\Google\GoogleUrl;

class GoogleCrawler
{
    /**
     * Get keyword results by Google search engine
     *
     * @param $keyword
     * @return array
     * @throws Exception
     * @throws InvalidDOMException
     */
    public function crawlByKeyword(string $keyword)
    {
        $keyword = trim($keyword);

        $userAgent = "Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.93 Safari/537.36";
        $browserLanguage = "en-EN";

        $browser = new Browser(new CurlClient(), $userAgent, $browserLanguage);

        // Create a google client using the browser we configured
        $googleClient = new GoogleClient($browser);

        // Create the url that will be parsed
        $googleUrl = new GoogleUrl();
        $googleUrl->setSearchTerm($keyword);

        $result = [
            'keyword' => '',
            'adwords_num' => 0,
            'links_num' => 0,
            'search_results_num' => 0,
            'html_content' => '',
        ];

        try {
            $response = $googleClient->query($googleUrl);

            $result['keyword'] = $keyword;
            $result['adwords_num'] = $response->getAdwordsResults()->count() ?: 0; // Total number of AdWords advertisers
            $result['links_num'] = $response->cssQuery('a')->count() ?: 0; // Total number of links on the page
            $result['search_results_num'] = $response->getNumberOfResults() ?: 0; // Total of search results for this keyword
            $result['html_content'] = $response->getDom()->saveHTML() ?: ''; // HTML code of the page/cache of the page.

        } catch (RequestErrorException $e) {
            throw CrawlException::error($e->getMessage());
        }

        return $result;
    }
}
