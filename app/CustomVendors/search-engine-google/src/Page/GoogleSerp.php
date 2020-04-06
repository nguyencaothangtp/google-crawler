<?php

namespace Serps\SearchEngine\Google\Page;

use Serps\Core\Dom\DomElement;
use Serps\Core\Serp\CompositeResultSet;
use Serps\Exception;
use Serps\SearchEngine\Google\Exception\InvalidDOMException;
use Serps\SearchEngine\Google\Parser\Evaluated\AdwordsParser;
use Serps\SearchEngine\Google\Parser\Evaluated\MobileAdwordsParser;

class GoogleSerp extends GoogleDom
{
    /**
     * @return CompositeResultSet
     * @throws Exception
     * @throws InvalidDOMException
     */
    public function getAdwordsResults()
    {
        if ($this->javascriptIsEvaluated()) {
            if ($this->isMobile()) {
                $parser = new MobileAdwordsParser();
            } else {
                $parser = new AdwordsParser();
            }

            return $parser->parse($this);
        } else {
            throw new InvalidDOMException('Raw dom is not supported, please provide an evaluated version of the dom');
        }
    }

    /**
     * Get the total number of results available for the search terms
     * @return int the number of results
     */
    public function getNumberOfResults()
    {
        $item = $this->cssQuery('#result-stats');
        if ($item->length != 1) {
            return null;
        }

        // number of results is followed by time, we want to targets the first node (text node) that is the number of
        // results
        $nodeValue = $item->getNodeAt(0)->getChildren()->getNodeAt(0)->getNodeValue();

        if (!$nodeValue) {
            return null;
        }


        // WARNING: The number of result is explained in different format according to the country. Fon instance:
        // UK:  6,200,000
        // FR:  6 200 000
        // DE:  2.200.000
        // IN:  62,00,000
        // We have to use a global matcher
        $matched = preg_match_all('/([0-9]+[^0-9]?)+/u', $nodeValue, $countMatch);

        if (!$matched) {
            return null;
        }

        // get the last count, when we use pagination the first count is the page number
        // see https://github.com/serp-spider/search-engine-google/issues/100
        $count = $countMatch[0][count($countMatch[0]) - 1];

        return (int)preg_replace('/[^0-9]/', '', $count);
    }


    /**
     * @return bool
     * @throws Exception
     * @throws InvalidDOMException
     */
    public function javascriptIsEvaluated()
    {
        $body = $this->getXpath()->query('//body');

        if ($body->length != 1) {
            throw new Exception('No body found');
        }

        $body = $body->item(0);
        /** @var $body DomElement */
        $class = $body->getAttribute('class');
        if ($class == 'hsrp') {
            return false;
        } elseif (strstr($class, 'srp')) {
            return true;
        } else {
            throw new InvalidDOMException('Unable to check javascript status.');
        }
    }

    /**
     * @return bool
     */
    public function isMobile()
    {
        $item = $this->cssQuery('head meta[name="viewport"]');
        return $item->length == 1;
    }
}
