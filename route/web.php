<?php

use App\System\Route;

function registerWebRoutes(Route $route)
{
//    $route->group('web', function ($route){
//        $route->get();
//    });

    $route->group('web', function ($route){
        $route->get('/sign-up', 'register', 'showSignupPage');
        $route->post('/sign-up/confirm', 'register', 'confirm');
        $route->post('/sign-up/register', 'register', 'register');

        $route->get('/login', 'login', 'showLoginForm');
        $route->post('/login/auth', 'login', 'auth');

        $route->post('/logout', 'login', 'logout');

        $route->get('/home', 'tweet', 'home', 1);

        // ユーザーページ
        $route->get('/user/:unique_name', 'user', 'index');

        // タイムライン表示
        $route->get('/all', 'tweet', 'all');
        $route->get('/detail/:tweet_id', 'tweet', 'detail');

        $route->post('/tweet/post', 'tweet', 'post', 1);
        $route->post('/tweet/delete', 'tweet', 'delete', 1);
    });
}