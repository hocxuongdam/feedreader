<?php

namespace App\Page\Repository;

use App\Feed;
use App\Page;

/**
 * Class PageRepository
 * @package App\Page\Repository
 */
class PageRepository
{
    /**
     * @param Page $page
     * @throws \Exception
     */
    public function remove(Page $page): void
    {
        Feed::where('page_id', $page->id)->delete();
        $page->delete();
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function removeById(int $id): void
    {
        $page = Page::find($id);
        if ($page !== null){
            $this->remove($page);
        }
    }
}