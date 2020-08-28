<?php

namespace App\System\Interfaces\HTTP;

interface JsonResponseInterface
{
    //API用メソッド
    public function prepareJson($content);
}