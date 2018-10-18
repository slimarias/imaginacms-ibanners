<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/ibanners'], function (Router $router) {

    \CRUD::resource('ibanners','category', 'CategoryController');
    \CRUD::resource('ibanners','banner', 'BannerController');
});

