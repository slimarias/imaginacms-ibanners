<?php

use Illuminate\Routing\Router;
use Modules\Ibanners\Entities\Category as Category;

/** @var Router $router */
if (! App::runningInConsole()) {
    foreach (Category::query()->where('parent_id', 0)->get() as $category) {


        /** @var Router $router */
        $router->group(['prefix' => $category->slug], function (Router $router) use ($category) {
            $locale = LaravelLocalization::setLocale() ?: App::getLocale();

            $router->get('/', [
                'as' => $locale . '.ibanners.' . $category->slug,
                'uses' => 'PublicController@index',
                //'middleware' => config('asgard.ibanners.config.middleware'),
            ]);
            $router->get('{slug}', [
                'as' => $locale . '.ibanners.' . $category->slug .'.slug',
                'uses' => 'PublicController@show',
                //'middleware' => config('asgard.ibanners.config.middleware'),
            ]);
        });

    }
}
