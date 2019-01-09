<?php

namespace App\Console\Commands;

use App\Feed;
use App\Page;
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pageId = $this->argument('id');
        $page = Page::find($pageId);

        if ($page !== null){
            Feed::where('page_id', $pageId)->delete();
            $page->delete();
            $this->info('Page removed!');
        }else {
            $this->error('Page not found!');
        }
    }
}
