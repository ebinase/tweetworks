<?php

namespace App\System\Interfaces;

interface ResponseInterface
{
    //セッター
    function setContent($content);
    function setStatusCode(string $status_code, string $status_text);
    function setHttpHeader(string $name, string $value);

    //送信
    function send(): void;

}