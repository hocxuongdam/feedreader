<?php

namespace App\Console\Commands;

use App\Page;
use Illuminate\Console\Command;

class PagesList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all fetched pages.';

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
        $pages = Page::all();
        $headers = ['id', 'title', 'url'];
        $pagesArray = [];

        foreach ($pages as $page){
            $pagesArray[] = [$page->id, $page->title, $page->url];
        }

        $this->table($headers, $pagesArray);
    }
}
