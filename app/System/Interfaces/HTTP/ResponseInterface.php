<?php

namespace App\System\Interfaces\HTTP;

interface ResponseInterface
{
    //セッター
    public function setContent($content);
    public function setStatusCode(string $status_code, string $status_text);
    public function setHttpHeader(string $name, string $value);

    //ゲッター
    public function getContent();
    public function getStatusCode();
    public function getHttpHeaders();
}