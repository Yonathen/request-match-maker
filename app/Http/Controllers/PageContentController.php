<?php

namespace App\Http\Controllers;

use App\Utility\R;
use App\Repositories\Interfaces\PageRepositoryInterface;
use App\Repositories\Interfaces\PageContentRepositoryInterface;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;
use Illuminate\Http\Request;
use App\Enums\ReturnType;
use App\model\Page;
use App\model\PageContent;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth; 

class PageContentController extends Controller
{
    use R;
    private $pageRepository;
    private $pageContentRepository;

    public function __construct(PageRepositoryInterface $pageRepository, PageContentRepositoryInterface $pageContentRepository)
    {
        $this->middleware('auth:api')->except('show');
        $this->pageRepository = $pageRepository;
        $this->pageContentRepository = $pageContentRepository;
    }

    /**
     * @param  int  $id
     */
    public function show($id)
    {
        $this->type = 'getPageContent';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = true;
            $pageContent = $this->pageContentRepository->getPageContent($id);
            if (is_null($pageContent)) {
                throw (new Exception("Failed to get get Page Content.", 1));
            }
            
            $this->returnValue = $pageContent;
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $this->type = 'createPageContent';
        $this->returnType = ReturnType::SINGLE;
        try {
            
            if ( Gate::denies('isAdmin') ) {
                throw (new Exception("You are not allowed.", 1));
            }
            $page = $this->pageRepository->getPage($request->pageId);

            $pageContent = new PageContent;
            $pageContent->title = $request->title;
            $pageContent->content = $request->content;
        
            if (!is_null($page) && $this->pageContentRepository->createPageContent($page, $pageContent)) {
                $this->status = true;
            } 

            if (!$this->status) {
                throw (new Exception("Failed to create page content.", 1));
            }

            $this->returnValue = $pageContent;

        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $this->type = 'updatePage';
        $this->returnType = ReturnType::SINGLE;
        try {
            if ( Gate::denies('isAdmin') ) {
                throw (new Exception("You are not allowed.", 1));
            }
            $pageContent = $this->pageContentRepository->getPageContent($id);
            $pageContent->title = $request->title;
            $pageContent->content = $request->content;
            if (!is_null($pageContent) && $this->pageContentRepository->editPageContent($pageContent) ) {
                $this->status = true;
            }

            if ( !$this->status ) {
                throw (new Exception("Failed to update page.", 1));
            }

            $this->returnValue = $pageContent;

        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    /**
     * @param  int  $id
     */
    public function destroy($id)
    {
        $this->type = 'deletePageContent';
        $this->returnType = ReturnType::SINGLE;
        try {
            if ( Gate::denies('isAdmin') ) {
                throw (new Exception("You are not allowed.", 1));
            }
            $pageContent = $this->pageContentRepository->getPageContent($id);
            if (!is_null($pageContent) && $this->pageContentRepository->deletePageContent($pageContent) ) {
                $this->status = true;
            }

            if ( !$this->status ) {
                throw (new Exception("Failed to delete page content.", 1));
            }

            $this->returnValue = $pageContent;

        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }
}
