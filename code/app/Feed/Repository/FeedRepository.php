<?php

namespace App\Feed\Repository;

use App\Feed;
use App\Page;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class FeedRepository
 * @package App\Feed\Repository
 */
class FeedRepository
{
    /**
     * @param Collection $feeds
     * @param Page $page
     */
    public function bulkInsert(Collection $feeds, Page $page): void
    {
        $data = [];
        $now = Carbon::now('utc')->toDateTimeString();
        $pageId = $page->id;

        foreach ($feeds as $feed) {
            /** @var Feed $feed */
            $data[] = [
                'title' => $feed->title,
                'url' => $feed->url,
                'thumbnail' => $feed->thumbnail,
                'publish_date' => $feed->publish_date,
                'description' => $feed->description,
                'page_id' => $pageId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        Feed::insert($data);
    }
}