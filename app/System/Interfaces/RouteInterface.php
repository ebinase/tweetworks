<?php

namespace App\System\Interfaces;

interface RouteInterface
{
    //各ルートが属するグループを登録する
    function group($group, callable $func);

    function get($url, $controller, $action, $middlewares = [], $name = null);
    function post($url, $controller, $action, $middlewares = [], $name = null);
    function put($url, $controller, $action, $middlewares = [], $name = null);
    function delete($url, $controller, $action, $middlewares = [], $name = null);

    function resource($url, $controller, $action, $middlewares = [], $name = null);

    //Routerに渡すルーティング定義配列を返す
    function getDifinitions();

}