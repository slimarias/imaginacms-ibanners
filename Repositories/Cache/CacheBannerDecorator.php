<?php

namespace Modules\Ibanners\Repositories\Cache;

use Modules\Ibanners\Repositories\Collection;
use Modules\Ibanners\Repositories\BannerRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheBannerDecorator extends BaseCacheDecorator implements BannerRepository
{
    public function __construct(BannerRepository $banner)
    {
        parent::__construct();
        $this->entityName = 'banners';
        $this->repository = $banner;
    }

    /**
     * Return the latest x ibanners banners
     * @param int $amount
     * @return Collection
     */
    public function latest($amount = 5)
    {
        return $this->cache
            ->remember("{$this->locale}.{$this->entityName}.latest.{$amount}", $this->cacheTime,
                function () use ($amount) {
                    return $this->repository->latest($amount);
                }
            );
    }

    /**
     * Get the previous banner of the given banner
     * @param object $banner
     * @return object
     */
    public function getPreviousOf($banner)
    {
        $bannerId = $banner->id;

        return $this->cache
            ->remember("{$this->locale}.{$this->entityName}.getPreviousOf.{$bannerId}", $this->cacheTime,
                function () use ($banner) {
                    return $this->repository->getPreviousOf($banner);
                }
            );
    }

    /**
     * Get the next banner of the given banner
     * @param object $banner
     * @return object
     */
    public function getNextOf($banner)
    {
        $bannerId = $banner->id;

        return $this->cache
            ->remember("{$this->locale}.{$this->entityName}.getNextOf.{$bannerId}", $this->cacheTime,
                function () use ($banner) {
                    return $this->repository->getNextOf($banner);
                }
            );
    }
}
