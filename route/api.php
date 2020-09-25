<?php

use App\System\Interfaces\RouteInterface;

function registerApiRoutes(RouteInterface $route)
{
    $route->group('api', function (RouteInterface $route){
        //ルーティング処理
        //$route->get();

        $route->post('/api/tweet/post', 'API/Tweet', 'post', ['auth', 'csrf']);
        $route->post('/api/tweet/danger/post', 'API/Tweet', 'post', ['auth']);

        $route->post('/follow/update', 'follow', 'update', ['auth']);
        $route->post('/favorite/update', 'Favorite', 'update', ['auth']);
    });
}