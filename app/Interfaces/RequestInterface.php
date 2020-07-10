<?php


namespace App\Interfaces;


interface RequestInterface
{
    //単純メソッド
    function isPost();
    function getGet();
    function getPost();
    function getHost();
    function isSsl(): bool;
    function getRequestUri();

    //複合メソッド
    function getBaseUrl(): string;
    function getPathInfo(): string;
}