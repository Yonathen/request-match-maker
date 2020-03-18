<?php 
namespace App\Repositories\Interfaces;

use App\model\Page;
use App\model\PageContent;

/** @template T */
interface PageRepositoryInterface
{

	/**
	 *
     * @return mixed
     */
	public function all();


	/**
     * @param int $id
     */
	public function getPage($id);

	/**
	
     * @param Page $page
     */
	public function getPageContent(Page $page);


	/**
     * @param Page $page
     */
	public function savePageChange(Page $page);


	/**
     * @param Page $page
     */
	public function deletePage(Page $page);



}