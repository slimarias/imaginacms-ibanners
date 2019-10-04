<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/banners'], function (Router $router) {
  
  $router->post('/', [
    'as' =>  'api.ibanners.banners.create',
    'uses' => 'SlideApiController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' =>  'api.ibanners.banners.index',
    'uses' => 'SlideApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' =>  'api.ibanners.banners.update',
    'uses' => 'SlideApiController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' =>  'api.ibanners.banners.delete',
    'uses' => 'SlideApiController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' =>  'api.ibanners.banners.show',
    'uses' => 'SlideApiController@show',
  ]);
  
});