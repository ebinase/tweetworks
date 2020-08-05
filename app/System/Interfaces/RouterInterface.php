<?php

namespace App\System\Interfaces;

interface RouterInterface
{
    //要求されたパスとルーティング定義配列とをマッチング
    static function resolve(array $difinitions, string $required_path);
}