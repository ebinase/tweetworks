<?php

namespace App\System\Interfaces;

interface MessageInterface
{
    // コントローラ内で処理にエラーが生じたときに使う
    function setError($key, $message);
    function setOld($key, $message);
    function setMessage($key, $message);

    //If分の条件式等に。
    function errorExist();
    function oldExist();
    function infoExist();

    // 配列の形で全て取得
    function getAllError();
    function getAllOld();
    function getAllInfo();

    //取得
    function getError($key, $default = null);
    function getOld($key, $default = null);
    function getInfo($key, $default = null);
}