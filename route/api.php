<?php

use App\System\Interfaces\RouteInterface;

function registerApiRoutes(RouteInterface $route)
{
    $route->group('api', function ($route){
        //ルーティング処理
        //$route->get();
    });
}