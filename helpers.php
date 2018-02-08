<?php

use Modules\Ibanners\Entities\Banner;
use Modules\Ibanners\Entities\Status;

if(! function_exists('ibanner')){

    function ibanner($id, $templates, $options=array()){


        $banners = Banner::with(['categories']);
        $banners->leftJoin('ibanner__banner__category', 'ibanner__banner__category.post_id', '=', 'ibanner__banners.id');
        $banners->whereIn('ibanner__banner__category.category_id', [$id]);
        $banners->whereStatus(Status::PUBLISHED);


        $view = View::make($templates)

            ->with([
                'ibanners' => $banners->get(),
                'id_cat' => $id,
                'options' => $options,
            ]);

        return $view->render();

    }
}