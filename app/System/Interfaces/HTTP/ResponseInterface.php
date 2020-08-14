<?php

namespace App\System\Interfaces\HTTP;

interface ResponseInterface
{
    //セッター
    function setContent($content);
    function setStatusCode(string $status_code, string $status_text);
    function setHttpHeader(string $name, string $value);

}