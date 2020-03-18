<?php 
namespace App\Repositories;

use App\Repositories\Interfaces\PageRepositoryInterface;
use App\model\Page;
use App\model\PageContent;

class PageRepository implements PageRepositoryInterface 
{

	/**
     * Get's all posts.
     *
     * @return mixed
     */
	public function all()
    {
        return Page::all();
    }

	/**
     * @param int $id
     */
	public function getPage($id) 
	{
		return Page::find($id);
	}

	/**
     * @param int $id
     */
	public function getPageContent($id)
	{
		return Page::findOrFail($id)->pageContent;
	}


	/**
     * @param Page $page
     */
	public function savePageChange(Page $page)
	{
		return $page->save();
	}



	/**
     * @param Page $page
     */
	public function deletePage(Page $page)
	{
		return Page::destroy($page->id);
	}

}