<?php

namespace Modules\Ibanners\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Ibanners\Entities\Category;
use Modules\Ibanners\Entities\Banner;
use Modules\Ibanners\Entities\Tag;
use Modules\Ibanners\Repositories\Cache\CacheCategoryDecorator;
use Modules\Ibanners\Repositories\Cache\CacheBannerDecorator;
use Modules\Ibanners\Repositories\Cache\CacheTagDecorator;
use Modules\Ibanners\Repositories\CategoryRepository;
use Modules\Ibanners\Repositories\Eloquent\EloquentCategoryRepository;
use Modules\Ibanners\Repositories\Eloquent\EloquentBannerRepository;
use Modules\Ibanners\Repositories\Eloquent\EloquentTagRepository;
use Modules\Ibanners\Repositories\BannerRepository;
use Modules\Ibanners\Repositories\TagRepository;
use Modules\Core\Traits\CanPublishConfiguration;

class IbannersServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    public function boot()
    {
        $this->publishConfig('ibanners', 'config');
        //$this->publishConfig('ibanners', 'settings');
        $this->publishConfig('ibanners', 'permissions');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(BannerRepository::class, function () {
            $repository = new EloquentBannerRepository(new Banner());

            if (config('app.cache') === false) {
                return $repository;
            }

            return new CacheBannerDecorator($repository);
        });

        $this->app->bind(CategoryRepository::class, function () {
            $repository = new EloquentCategoryRepository(new Category());

            if (config('app.cache') === false) {
                return $repository;
            }

            return new CacheCategoryDecorator($repository);
        });

        $this->app->bind(TagRepository::class, function () {
            $repository = new EloquentTagRepository(new Tag());

            if (config('app.cache') === false) {
                return $repository;
            }

            return new CacheTagDecorator($repository);
        });

    }
}
