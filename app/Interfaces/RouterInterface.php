<?php


namespace App\Interfaces;


interface RouterInterface
{
    function __construct(array $difinitions);

    //requestクラスから$path_infoを受け取ってルーティング定義配列とマッチング
    function resolve(string $path_info);
}