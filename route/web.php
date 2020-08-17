<?php

use App\System\Interfaces\RouteInterface;

function registerWebRoutes(RouteInterface $route)
{
//    $route->group('web', function ($route){
//        $route->get();
//    });

    $route->group('web', function (RouteInterface $route){
      //$route->メソッド(url, controller, action, |オプション→middleware['name1','name2',...], route_name);

        $route->get('/sign-up', 'register', 'showSignupPage');
        $route->post('/sign-up/confirm', 'register', 'confirm', ['csrf']);
        $route->post('/sign-up/register', 'register', 'register', ['csrf']);

        $route->get('/login', 'login', 'showLoginForm', ['guest']);
        $route->post('/login/auth', 'login', 'auth', ['guest']);

        $route->get('/logout', 'login', 'logout');

        $route->get('/home', 'tweet', 'home', ['auth']);

        // ユーザーページ
        $route->get('/user/:unique_name', 'user', 'index', ['auth']);

        // タイムライン表示
        $route->get('/all', 'tweet', 'all');
        $route->get('/detail/:tweet_id', 'tweet', 'detail');

        $route->post('/tweet/post', 'tweet', 'post', ['auth', 'csrf']);
        $route->post('/tweet/delete', 'tweet', 'delete', ['auth', 'csrf']);

        $route->post('/reply/post', 'reply', 'post', ['auth', 'csrf']);
    });
}