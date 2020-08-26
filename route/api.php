<?php

use App\System\Interfaces\RouteInterface;

function registerApiRoutes(RouteInterface $route)
{
    $route->group('api', function (RouteInterface $route){
        //ルーティング処理
        //$route->get();

        $route->post('/follow/update', 'follow', 'update', ['auth', 'csrf']);
        $route->post('/favorite/update', 'Favorite', 'update', ['auth', 'csrf']);
    });
}