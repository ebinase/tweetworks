<?php

namespace App\System\Interfaces\HTTP;

interface RequestInterface
{
    //単純メソッド
    public function getRequestMethod();
    public  function isPost();
    public  function getGet($name, $default = null);
    public function getAllGet();
    public function getPost($name, $default = null);
    public function getAllPost();
    public function getHost();
    public function isSsl(): bool;
    public function getRequestUri();

    //リクエストされたルートのコントローラー等の情報
    public function setRouteParam($routeParam);
    public function getRouteParam();

    //複合メソッド
    public function getBaseUrl();
    public function getPathInfo($full = false);
}