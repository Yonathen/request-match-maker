<?php

namespace App\Http\Controllers;

use App\Utility\R;
use App\Repositories\Interfaces\PageRepositoryInterface;
use App\Repositories\Interfaces\PageContentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\ResponseCollection;
use Illuminate\Http\Request;
use App\Enums\ReturnType;
use App\model\Page;
use App\model\PageContent;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth; 

class PageController extends Controller
{
    use R;
    private $pageRepository;
    private $pageContentRepository;
    private $userRepository;

    public function __construct(PageRepositoryInterface $pageRepository, 
        PageContentRepositoryInterface $pageContentRepository)
    {
        $this->middleware(['auth:api', 'verified'])->only(['store', 'update', 'destroy']);
        $this->pageRepository = $pageRepository;
        $this->pageContentRepository = $pageContentRepository;
    }


    public function index()
    {
        $this->type = 'getAllPages';
        $this->returnType = ReturnType::COLLECTION;
        
        $this->status = true;
        $this->returnValue = $this->pageRepository->all();
    

        return $this->getResponse();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $this->type = 'createPage';
        $this->returnType = ReturnType::SINGLE;
        try {
            if ( Gate::denies('isAdmin') ) {
                throw (new Exception("You are not allowed.", 1));
            }

            $this->status = true;
            $page = new Page;
            $pageContent = new PageContent;

            $page->last_updated = date('Y-m-d');
            $page->name = $request->name;
            if (!is_null($request->pageContent)) {
                $pageContent->title = $request->pageContent["title"];
                $pageContent->content = $request->pageContent["content"];
            }

            $saved = $this->pageRepository->savePageChange($page);
            if ($saved && !is_null($request->pageContent)) {
                if (!$this->pageContentRepository->createPageContent($page, $pageContent)){
                    $saved = false;
                }
            } 
            if (!$saved) {
                throw (new Exception("Failed to create page.", 1));
            }
            $this->returnValue = $page;

        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

    /**
     * @param  int  $id
     */
    public function show($id)
    {
        $this->type = 'getPage';
        $this->returnType = ReturnType::SINGLE;
        try {
            $this->status = true;
            $page = $this->pageRepository->getPage($id);
            if (is_null($page)) {
                throw (new Exception("Failed to get page.", 1));
            }
            $pageContent = $this->pageRepository->getPageContent($id);
            $this->returnValue = [ 'page_detail' => $page, 'page_content' => $pageContent ];
        
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

            $this->status = false;
            $page = $this->pageRepository->getPage($id);
            if (!is_null($page)) {
                $page->last_updated = date('Y-m-d');
                $page->name = $request->name;
                if ( $this->pageRepository->savePageChange($page) ) {
                    $this->status = true;
                }
            }

            if ( !$this->status ) {
                throw (new Exception("Failed to update page.", 1));
            }

            $this->returnValue = $page;

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
        $this->type = 'deletePage';
        $this->returnType = ReturnType::SINGLE;
        try {

            if ( Gate::denies('isAdmin') ) {
                throw (new Exception("You are not allowed.", 1));
            }

            $this->status = false;
            $page = $this->pageRepository->getPage($id);
            if (!is_null($page)) {
                if ( $this->pageRepository->deletePage($page) ) {
                    $this->status = true;
                }
            }

            if ( !$this->status ) {
                throw (new Exception("Failed to delete page.", 1));
            }

            $this->returnValue = $page;
        
        } catch (Exception $e) {
            $this->failedRequest($e);
        }

        return $this->getResponse();
    }

}
