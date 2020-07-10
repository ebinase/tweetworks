<?php

namespace App\System\Interfaces;

interface ApplicationInterface
{
    //Input---------------------------------------------------------------
    //ルーティング定義配列読み込み
    function registerRoutes(): array;
    //コントローラ呼び出し、アクション実行、レスポンス送信
    function runAction(string $controller_name, string $action_name, array $params): void;
}