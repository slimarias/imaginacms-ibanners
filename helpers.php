<?php

use Modules\Ibanners\Entities\Banner;

if(! function_exists('ibanner')){

    function ibanner($id, $templates, $options=array()){

        //$ibanner = Banner::find($id);

        $banners = Banner::with(['categories']);
        $banners->whereHas('categories', function ($query) use ($id) {
            $query->whereIn('category_id', [$id]);
        });


        $view = View::make($templates)

            ->with([
                'ibanners' => $banners->get(),
                'id_cat' => $id,
                'options' => $options,
            ]);

        return $view->render();

    }
}