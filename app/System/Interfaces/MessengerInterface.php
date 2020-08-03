<?php

namespace App\System\Interfaces;

interface MessengerInterface
{
    // コントローラ内で処理にエラーが生じたときに使う
    function setError($key, $message);
    function setOld($key, $message);
    function setMessage($key, $message);

    //If分の条件式等に。
    function errorsExist();
    function oldsExist();
    function messagesExist();

    // 配列の形で全て取得
    function getAllErrors();
    function getAllOlds();
    function getAllMessages();

    //取得
    function getError($key, $default = null);
    function getOld($key, $default = null);
    function getMessage($key, $default = null);
}