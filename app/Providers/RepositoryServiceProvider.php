<?php

namespace App\Providers;

use App\Repositories\Interfaces\PageRepositoryInterface;
use App\Repositories\Interfaces\PageContentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\UserSlideRepositoryInterface;
use App\Repositories\Interfaces\UserNewRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Repositories\Interfaces\PartnerRepositoryInterface;
use App\Repositories\Interfaces\RequestMailRepositoryInterface;
use App\Repositories\Interfaces\RequestOfferRepositoryInterface;
use App\Repositories\Interfaces\RequestTraderRepositoryInterface;
use App\Repositories\Interfaces\RequestMatchMakerRepositoryInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;

use App\Repositories\PageRepository;
use App\Repositories\PageContentRepository;
use App\Repositories\UserNewRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserSlideRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\PartnerRepository;
use App\Repositories\RequestMailRepository;
use App\Repositories\RequestOfferRepository;
use App\Repositories\RequestTraderRepository;
use App\Repositories\RequestMatchMakerRepository;
use App\Repositories\FileRepository;

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

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserSlideRepositoryInterface::class, UserSlideRepository::class);
        $this->app->bind(UserNewRepositoryInterface::class, UserNewRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(PartnerRepositoryInterface::class, PartnerRepository::class);
        $this->app->bind(RequestMailRepositoryInterface::class, RequestMailRepository::class);
        $this->app->bind(RequestTraderRepositoryInterface::class, RequestTraderRepository::class);
        $this->app->bind(RequestOfferRepositoryInterface::class, RequestOfferRepository::class);
        $this->app->bind(RequestMatchMakerRepositoryInterface::class, RequestMatchMakerRepository::class);
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
    }
}
