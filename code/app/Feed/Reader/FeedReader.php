<?php

namespace App\Feed\Reader;

use App\Feed\Factory\FeedBuilderFactory;
use App\Page;
use PharIo\Manifest\InvalidUrlException;

/**
 * Class AbstractFeedReader
 * @package App\FeedReader
 */
class FeedReader
{
    /**
     * @var FeedBuilderFactory
     */
    private $feedBuilderFactory;
    /**
     * @var \SimpleXMLElement
     */
    private $xml;

    /**
     * FeedReader constructor.
     * @param FeedBuilderFactory $feedBuilderFactory
     */
    public function __construct(FeedBuilderFactory $feedBuilderFactory)
    {
        $this->feedBuilderFactory = $feedBuilderFactory;
    }

    /**
     * @param string $url
     * @return array
     * @throws InvalidUrlException
     */
    public function read($url): array
    {
        $this->fetchXML($url);
        $feedBuilder = $this->feedBuilderFactory->make($url, $this->xml);
        $page = $feedBuilder->buildFeedPage();

        if ($page->id !== null) {
            $feeds = $page->feeds()->getResults();
        } else {
            $feeds = $feedBuilder->buildFeedItems();
        }

        return [$page, $feeds];
    }

    /**
     * @param string $url
     * @throws InvalidUrlException
     */
    private function fetchXML($url)
    {
        $this->validateUrl($url);
        try{
            $this->xml = simplexml_load_string(file_get_contents($url));
        }catch (\Exception $exception){
            throw new InvalidUrlException('Invalid url');
        }

        if (!($this->xml instanceof \SimpleXMLElement)) {
            throw new InvalidUrlException('Invalid url');
        }
    }

    /**
     * @param string $url
     * @return bool
     * @throws InvalidUrlException
     */
    private function validateUrl($url): bool
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException('Invalid url');
        }

        return true;
    }
}