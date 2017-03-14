<?php

namespace Modules\Ibanners\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface BannerRepository extends BaseRepository
{
    /**
     * Return the latest x ibanners banners
     * @param int $amount
     * @return Collection
     */
    public function latest($amount = 5);

    /**
     * Get the previous banner of the given banner
     * @param object $banner
     * @return object
     */
    public function getPreviousOf($banner);

    /**
     * Get the next banner of the given banner
     * @param object $banner
     * @return object
     */
    public function getNextOf($banner);
}
