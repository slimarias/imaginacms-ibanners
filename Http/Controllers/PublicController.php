<?php

namespace Modules\Ibanners\Http\Controllers;

use Mockery\CountValidator\Exception;
use Modules\Ibanners\Repositories\CategoryRepository;
use Modules\Ibanners\Repositories\BannerRepository;
use Modules\Core\Http\Controllers\BasePublicController;
use Route;
use Request;
use Log;

class PublicController extends BasePublicController
{
    /**
     * @var BannerRepository
     */
    private $banner;
    private $category;

    public function __construct(BannerRepository $banner,CategoryRepository $category)
    {
        parent::__construct();
        $this->banner = $banner;
        $this->category = $category;
    }

    public function index()
    {
        //Search category.
        $uri = Route::current()->uri();

        //Default Template
        $tpl = 'ibanners.index';
        if(empty($uri)) {
            //Root
        } else {
            $category = $this->category->findBySlug($uri);
            $banners = $this->banner->whereCategory($category->id);

            //Get Custom Template.
            $ctpl = "ibanners.category.{$category->id}.index";
            if(view()->exists($ctpl)) $tpl = $ctpl;
        }


        return view($tpl, compact('banners','category'));

    }

    public function show($slug)
    {

        $tpl = 'ibanners.show';
        $banner = $this->banner->findBySlug($slug);
        $category = $banner->categories()->first();
        //Get Custom Template.
        $ctpl = "ibanners.category.{$category->id}.show";
        if(view()->exists($ctpl)) $tpl = $ctpl;

        return view($tpl, compact('banner','category'));
    }
}
