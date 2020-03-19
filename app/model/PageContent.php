<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $table = "page_content";

    public function page()
    {
    	return $this->belongsTo('App\model\Page');
    }
}
