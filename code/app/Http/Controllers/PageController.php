<?php

namespace App\Http\Controllers;

use App\Page\Repository\PageRepository;

class PageController extends Controller
{
    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * PageController constructor.
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy($id){
        $this->pageRepository->removeById($id);

        return redirect('feed');
    }
}
