<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = "page";

    public function pageContent()
    {
    	return $this->hasMany('App\model\PageContent');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($page) {
             $page->pageContent()->delete();
        });
    }
}
