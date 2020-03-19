<?php 
namespace App\Repositories\Interfaces;

use App\model\Page;
use App\model\PageContent;

interface PageContentRepositoryInterface
{


     /**
     * @param PageContent $pageContent
     */
     public function getPage(PageContent $pageContent);

     /**
     * @param Page $page
     */
     public function getPageContent($id);

     /**
     * @param Page $page
     * @param PageContent $pageContent
     */
     public function createPageContent(Page $page, PageContent $pageContent);

     /**
     * @param PageContent $pageContent
     */
     public function editPageContent(PageContent $pageContent);

     /**
     * @param PageContent $pageContent
     */
     public function deletePageContent(PageContent $pageContent);
}