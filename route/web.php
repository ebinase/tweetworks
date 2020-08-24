<?php

use App\System\Interfaces\RouteInterface;

function registerWebRoutes(RouteInterface $route)
{
//    $route->group('web', function ($route){
//        $route->get();
//    });

    $route->group('web', function (RouteInterface $route){
      //$route->メソッド(url, controller, action, |オプション→middleware['name1','name2',...], route_name);
        //トップページ
        $route->get('/', 'top', 'index');
            //ログイン周り
            $route->get('/sign-up', 'Auth/Register', 'showSignupPage');
            $route->post('/sign-up/confirm', 'Auth/Register', 'confirm', ['csrf']);
            $route->post('/sign-up/register', 'Auth/Register', 'register', ['csrf']);

            $route->get('/login', 'Auth/Login', 'showLoginForm', ['guest']);
            $route->post('/login/auth', 'Auth/Login', 'auth', ['guest']);

            $route->get('/logout', 'Auth/Login', 'logout');


        // ユーザーページ
        $route->get('/user/:unique_name', 'user', 'index');
        $route->get('/user/:unique_name/follows', 'user', 'followsIndex');
        $route->get('/user/:unique_name/followers', 'user', 'followersIndex');

        // タイムライン表示
        $route->get('/all', 'timeline', 'all');
        $route->get('/home', 'timeline', 'home', ['auth']);

        $route->get('/detail/:tweet_id', 'tweet', 'show');

        $route->post('/tweet/post', 'tweet', 'post', ['auth', 'csrf']);
        $route->post('/tweet/delete', 'tweet', 'delete', ['auth', 'csrf']);

        $route->post('/reply/post', 'reply', 'post', ['auth', 'csrf']);

        $route->post('/follow/update', 'follow', 'update', ['auth', 'csrf']);


    });
}