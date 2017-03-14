<?php

namespace Modules\Ibanners\Widgets;

use Modules\Ibanners\Repositories\BannerRepository;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;

class BannersWidget extends BaseWidget
{
    /**
     * @var \Modules\Ibanners\Repositories\BannerRepository
     */
    private $banner;

    public function __construct(BannerRepository $banner)
    {
        $this->banner = $banner;
    }

    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'BannersWidget';
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'ibanners::admin.widgets.banners';
    }

    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        return ['bannerCount' => $this->banner->all()->count()];
    }

     /**
     * Get the widget type
     * @return string
     */
    protected function options()
    {
        return [
            'width' => '2',
            'height' => '2',
            'x' => '0',
        ];
    }
}
