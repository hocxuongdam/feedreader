<?php

namespace App\Feed\Builder;

use App\Page;
use Illuminate\Database\Eloquent\Collection;
use SimpleXMLElement;

/**
 * Class AbstractFeedBuilder
 * @package App\Feed\Builder
 */
abstract class AbstractFeedBuilder
{
    CONST DATE_FORMAT = 'dd MMM yyyy';

    /**
     * @var SimpleXMLElement
     */
    protected $xml;

    /**
     * AbstractFeedBuilder constructor.
     * @param SimpleXMLElement $xml
     */
    public function __construct(SimpleXMLElement $xml)
    {
        $this->xml = $xml;
    }

    /**
     * @return Collection
     */
    abstract public function buildFeedItems();

    /**
     * @return Page
     */
    abstract public function buildFeedPage(): Page;
}