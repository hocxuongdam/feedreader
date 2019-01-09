<?php

namespace App\Console\Commands;

use App\Feed\Reader\FeedReader;
use App\Feed\Repository\FeedRepository;
use App\Page;
use Illuminate\Console\Command;
use PharIo\Manifest\InvalidUrlException;

class PagesView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page:view {viewBy?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View all feeds of 1 RSS page. {page} parameter can be an URL or Id. If URL is used, fetch from latest URL.';
    /**
     * @var FeedReader
     */
    private $feedReader;
    /**
     * @var FeedRepository
     */
    private $feedRepository;

    /**
     * Create a new command instance.
     *
     * @param FeedReader $feedReader
     * @param FeedRepository $feedRepository
     */
    public function __construct(FeedReader $feedReader, FeedRepository $feedRepository)
    {
        parent::__construct();
        $this->feedReader = $feedReader;
        $this->feedRepository = $feedRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $viewBy = $this->argument('viewBy');
        $viewByUrl = false;

        if (is_numeric($viewBy)) {
            $page = Page::find($viewBy);
        } elseif (filter_var($viewBy, FILTER_VALIDATE_URL)){
            $page = Page::where('url', $viewBy)->orderBy('pageDate', 'desc')->first();
            $viewByUrl = true;
        } else {
            $this->error('Must be Id or RSS Url');
            return;
        }

        if ($page === null) {
            if ($viewByUrl){
                try{
                    [$page, $feeds] = $this->feedReader->read($viewBy);
                }catch (InvalidUrlException $exception){
                    $this->error('Invalid URL');
                    return;
                }
                $page->save();
                $this->feedRepository->bulkInsert($feeds, $page);
                $this->showFeeds($feeds);
            }else{
                $this->info('Page not found!');
            }
        } else {
            $feeds = $page->feeds()->getResults();
            $this->showFeeds($feeds);
        }
    }

    /**
     * @param $feeds
     */
    private function showFeeds($feeds): void
    {
        $headers = ['Title', 'Published Date'];
        $feedsArray = [];
        foreach ($feeds as $feed){
            $feedsArray[] = [$feed->title, $feed->publish_date];
        }

        $this->table($headers, $feedsArray);
    }
}
