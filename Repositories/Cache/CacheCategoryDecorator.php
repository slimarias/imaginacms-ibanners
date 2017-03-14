<?php

namespace Modules\Ibanners\Repositories\Cache;

use Modules\Ibanners\Repositories\CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoryDecorator extends BaseCacheDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'categories';
        $this->repository = $category;
    }
}
