<?php 
namespace App\Repositories;

use App\Repositories\Interfaces\PageContentRepositoryInterface;
use App\model\Page;
use App\model\PageContent;

class PageContentRepository implements PageContentRepositoryInterface 
{


	/**
     * @param PageContent $pageContent
     */
	public function getPage(PageContent $pageContent)
	{
		return $pageContent->page;
	}

	/**
     * @param Page $page
     */
	public function getPageContent($id) 
	{
		return PageContent::find($id);
	}

	/**
     * @param Page $page
     * @param PageContent $pageContent
     */
	public function createPageContent(Page $page, PageContent $pageContent)
	{
		$pageContent->page()->associate($page);
		return $pageContent->save();
	}

	/**
     * @param PageContent $pageContent
     */
	public function editPageContent(PageContent $pageContent)
	{
		return $pageContent->save();
	}

	/**
     * @param PageContent $pageContent
     */
	public function deletePageContent(PageContent $pageContent)
	{
		return PageContent::destroy($pageContent->id);
	}

}