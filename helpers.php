<?php

use Modules\Ibanners\Entities\Category;
use Modules\Ibanners\Entities\Banner;
use Modules\Ibanners\Entities\Status;

if(! function_exists('ibanner')){

    function ibanner($id, $templates, $options=array()){


        $banners = Banner::with(['categories']);
        $banners->leftJoin('ibanners__banner__category', 'ibanners__banner__category.banner_id', '=', 'ibanners__banners.id');
        $banners->whereIn('ibanners__banner__category.category_id', [$id]);
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

if (!function_exists('get_banners')) {

    function get_banners($templates, $options = array())
    {
        if(view()->exists($templates)) {
            $default_options = array(
                'categories' => null,// categoria o categorias que desee llamar, se envia como arreglo ['categories'=>[1,2,3]]
                'take' => 5, //Numero de banners a obtener,
                'skip' => 0, //Omitir Cuantos banner a llamar
                'order' => 'desc',//orden de llamado
                'status' => Status::PUBLISHED
            );
            $options = array_merge($default_options, $options);
            $banners = Banner::with(['categories']);
            if (!empty($options['categories']) || isset($options['exclude_categories'])) {

                $banners->leftJoin('ibanners__banner__category', 'ibanners__banner__category.banner_id', '=', 'ibanners__banners.id');
            }
            if (!empty($options['categories'])) {

                $banners->whereIn('ibanners__banner__category.category_id', $options['categories']);

            }
            $banners->whereStatus($options['status'])
                ->skip($options['skip'])
                ->take($options['take'])
                ->orderBy('created_at', $options['order']);

            $view = View::make($templates)
                ->with([
                    'ibanners' => $banners,
                    'id_cat' => implode($options['categories']),
                    'options' => $options,
                ]);
        }else{
            $view = View::make('ibanners::frontend.error')
                ->with([
                    'view' => $templates,
                ]);
        }
        return $view->render();
    }
}