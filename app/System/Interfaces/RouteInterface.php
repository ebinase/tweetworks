<?php

namespace App\System\Interfaces;

interface RouteInterface
{
    //各ルートが属するグループを登録する(web.phpなどで使用)
    function group($group, callable $func);

    function get($url, $controller, $action, $middlewares = [], $name = null);
    function post($url, $controller, $action, $middlewares = [], $name = null);
    function put($url, $controller, $action, $middlewares = [], $name = null);
    function delete($url, $controller, $action, $middlewares = [], $name = null);

    function resource($url, $controller, $action, $middlewares = [], $name = null);

    //Routerに渡すルーティング定義配列を返す(Application内で使用)
    function getDifinitions();

}