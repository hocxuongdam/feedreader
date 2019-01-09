<?php

namespace App\Feed\Builder;

use App\Feed;
use App\Page;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class VnExpressFeedBuilder
 * @package App\Feed\Builder
 */
class VnExpressFeedBuilder extends AbstractFeedBuilder
{
    /**
     * @return Collection
     */
    public function buildFeedItems()
    {
        $feeds = [];

        foreach ($this->xml->channel->item as $item) {
            $encodedDescription = htmlspecialchars_decode($item->description->asXml());

            $feed = new Feed();
            $feed->title = $item->title ?? '';
            $feed->url = $item->link ?? '';
            $feed->publish_date = $item->pubDate ?? '';
            $feed->thumbnail = $this->getThumbnailUrl($encodedDescription);
            $feed->description = $this->getDescription($encodedDescription);
            $feeds[] = $feed;
        }

        return collect($feeds);
    }

    /**
     * @return Page
     */
    public function buildFeedPage(): Page
    {
        $url = strip_tags($this->xml->channel->link->asXML());
        $pubDate = strip_tags($this->xml->channel->pubDate->asXML());
        $pageDate = date('Y-m-d', strtotime($pubDate));
        $page = Page::where('url', $url)->where('pageDate', $pageDate)->first();

        if ($page !== null) {
            return $page;
        }

        $page = new Page();
        $page->title = strip_tags($this->xml->channel->title->asXML());
        $page->url = $url;
        $page->pubDate = $pubDate;
        $page->pageDate = $pageDate;

        return $page;
    }

    /**
     * @param string $encodedDescription
     * @return string
     */
    private function getThumbnailUrl(string $encodedDescription): string
    {
        preg_match('/(http(s?):)([\/|.|\w|\s|-])*\.(?:jpg|gif|png)/', $encodedDescription, $images);
        return $images[0] ?? '';
    }

    /**
     * @param string $encodedDescription
     * @return string
     */
    private function getDescription(string $encodedDescription): string
    {
        return str_replace("]]>", "", strip_tags($encodedDescription));
    }
}