<?php

namespace App\System\Interfaces;

interface RequestInterface
{
    //単純メソッド
    function  getRequestMethod();
    function isPost();
    function getGet($name);
    function getPost($name);
    function getHost();
    function isSsl(): bool;
    function getRequestUri();

    //複合メソッド
    function getBaseUrl();
    function getPathInfo();
}