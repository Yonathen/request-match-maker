<?php

namespace App\Providers;

use App\Repositories\Interfaces\PageRepositoryInterface;
use App\Repositories\Interfaces\PageContentRepositoryInterface;
use App\Repositories\Interfaces\UserExistingRepositoryInterface;
use App\Repositories\Interfaces\UserNewRepositoryInterface;

use App\Repositories\PageRepository;
use App\Repositories\PageContentRepository;
use App\Repositories\UserNewRepository;
use App\Repositories\UserExistingRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(PageRepositoryInterface::class, PageRepository::class);
        $this->app->bind(PageContentRepositoryInterface::class, PageContentRepository::class);
        
        $this->app->bind(UserNewRepositoryInterface::class, UserNewRepository::class);
        $this->app->bind(UserExistingRepositoryInterface::class, UserExistingRepository::class);
    }
}
