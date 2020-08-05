<?php

namespace App\System\Interfaces;

interface RouteInterface
{
    //Routerに渡すルーティング定義配列を返す
    function getDifinitions();

    function get($url, $controller, $action, $auth = 0, $name = null);
    function post($url, $controller, $action, $auth = 0, $name = null);

    function setParams($params);
    function getParams();

    function redirect($to);

    function mapFullUrls($base_url);

}