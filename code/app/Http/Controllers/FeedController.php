<?php

namespace App\Http\Controllers;

use App\Feed\Reader\FeedReader;
use App\Feed\Repository\FeedRepository;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PharIo\Manifest\InvalidUrlException;

class FeedController extends Controller
{
    /**
     * @var FeedReader
     */
    private $feedReader;
    /**
     * @var FeedRepository
     */
    private $feedRepository;

    /**
     * FeedController constructor.
     * @param FeedReader $feedReader
     * @param FeedRepository $feedRepository
     */
    public function __construct(FeedReader $feedReader, FeedRepository $feedRepository)
    {
        $this->feedReader = $feedReader;
        $this->feedRepository = $feedRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $url = $request->get('url', '');
        $pages = Page::all();
        $viewData = [
            'pages' => $pages,
        ];

        try {
            [$page, $feeds] = $this->feedReader->read($url);
        } catch (InvalidUrlException $exception) {
            $viewData['error'] = 'Please input a valid RSS source';
            return view('feed.index')->with($viewData);
        }

        /** @var Page $page */
        if ($page->id === null){
            $page->save();
            $pages[] = $page;
            $this->feedRepository->bulkInsert($feeds, $page);
        }

        $viewData['page'] = $page;
        $viewData['feeds'] = $feeds;

        return view('feed.index')->with($viewData);
    }
}
