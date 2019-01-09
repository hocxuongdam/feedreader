<?php

namespace App\Feed\Factory;

use App\Feed\Builder\AbstractFeedBuilder;
use App\Feed\Builder\VnExpressFeedBuilder;
use SimpleXMLElement;

/**
 * Class FeedBuilderFactory
 * @package App\Feed\Factory
 */
class FeedBuilderFactory
{
    private CONST DOMAIN_VNEXPRESS = 'vnexpress.net';

    /**
     * @param string $url
     * @param SimpleXMLElement $xml
     * @return AbstractFeedBuilder
     */
    public function make(string $url, SimpleXMLElement $xml): AbstractFeedBuilder
    {
        switch ($this->getDomain($url)) {
            case self::DOMAIN_VNEXPRESS:
                return new VnExpressFeedBuilder($xml);
            default:
                return new VnExpressFeedBuilder($xml);
        }
    }

    /**
     * @param string $url
     * @return string
     */
    private function getDomain(string $url): string
    {
        return parse_url($url)['host'];
    }
}