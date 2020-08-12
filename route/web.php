<?php

use App\System\Route;

function registerWebRoutes(Route $route)
{
//    $route->group('web', function ($route){
//        $route->get();
//    });

    $route->group('web', function (Route $route){
      //$route->メソッド(url, controller, action, |オプション→middleware['name1','name2',...], route_name);

        $route->get('/sign-up', 'register', 'showSignupPage');
        $route->post('/sign-up/confirm', 'register', 'confirm');
        $route->post('/sign-up/register', 'register', 'register');

        $route->get('/login', 'login', 'showLoginForm');
        $route->post('/login/auth', 'login', 'auth');

        $route->post('/logout', 'login', 'logout');

        $route->get('/home', 'tweet', 'home', ['auth', 'csrf']);

        // ユーザーページ
        $route->get('/user/:unique_name', 'user', 'index');

        // タイムライン表示
        $route->get('/all', 'tweet', 'all');
        $route->get('/detail/:tweet_id', 'tweet', 'detail');

        $route->post('/tweet/post', 'tweet', 'post');
        $route->post('/tweet/delete', 'tweet', 'delete');
    });
}