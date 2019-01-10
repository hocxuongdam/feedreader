<?php

namespace App\Console\Commands;

use App\Feed;
use App\Page;
use App\Page\Repository\PageRepository;
use Illuminate\Console\Command;

class PageRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page:remove {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove an existing page and its corresponding feeds';
    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * Create a new command instance.
     *
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        parent::__construct();
        $this->pageRepository = $pageRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $pageId = $this->argument('id');
        $page = Page::find($pageId);

        if ($page !== null){
            $this->pageRepository->remove($page);
            $this->info('Page removed!');
        }else {
            $this->error('Page not found!');
        }
    }
}
