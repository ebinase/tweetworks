<?php

namespace App\Middleware;

use App\System\Application;
use App\System\Exceptions\HttpNotFoundException;
use App\System\Interfaces\Core\MiddlewareInterface;

class PathExists implements MiddlewareInterface
{

    public function handle(Application $application): Application
    {
        //リクエストされたパスのルーティングパラメータ取得
        $params = $application->getRequestRouteParams();
        //リクエストされたパスとルーティング定義が一致しない場合は$paramsにfalseが入っている。

        if ($params === false) {
            //Requestクラスのクライアントからのパス情報を添えて例外を発生させる
            throw new HttpNotFoundException(<<<EOF
 Exception caught in PathExists middleware.
 No route found for '{$application->getRequest()->getPathInfo()}'.
EOF
            );
        }

        print '<p>PathExists通過</p>';

        return $application;
    }
}