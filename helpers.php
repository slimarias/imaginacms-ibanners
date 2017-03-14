<?php

use Modules\Ibanners\Entities\Category;

if(! function_exists('ibanner')){

    function ibanner($id, $templates, $options=array()){

        //$ibanner = Banner::find($id);

        $ibanner = Category::find($id)->banners;

        $view = View::make($templates)

            ->with([
                'ibanners' => $ibanner,
                'id_cat' => $id,
                'options' => $options,
            ]);

        return $view->render();

    }
}