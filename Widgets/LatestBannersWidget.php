<?php

namespace Modules\Ibanners\Widgets;

use Modules\Ibanners\Repositories\BannerRepository;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;
use Modules\Setting\Contracts\Setting;

class LatestBannersWidget extends BaseWidget
{
    /**
     * @var BannerRepository
     */
    private $banner;

    public function __construct(BannerRepository $banner, Setting $setting)
    {
        $this->banner = $banner;
        $this->setting = $setting;
    }

    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'LatestBannersWidget';
    }

    /**
     * Get the widget options
     * Possible options:
     *  x, y, width, height
     * @return string
     */
    protected function options()
    {
        return [
            'width' => '4',
            'height' => '4',
        ];
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'ibanners::admin.widgets.latest-banners';
    }

    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        $limit = $this->setting->get('ibanners::widget-banners-amount', locale(), 5);

        return ['banners' => $this->banner->latest($limit)];
    }
}
