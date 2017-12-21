<?php

use Modules\Ibanners\Entities\Category;
use Modules\Ibanners\Entities\Banner;
use Modules\Ibanners\Entities\Status;

if(! function_exists('ibanner')){

    function ibanner($id, $templates, $options=array()){

        //$ibanner = Banner::find($id);

        $banners = Banner::with(['categories']);
        $banners->whereHas('categories', function ($query) use ($id) {
            $query->whereIn('category_id', [$id]);
        });
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