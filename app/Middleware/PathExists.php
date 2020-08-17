<?php

namespace App\Middleware;

use App\System\Exceptions\HttpNotFoundException;
use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\Core\MiddlewareInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

class PathExists implements MiddlewareInterface
{

    public function process(RequestInterface $request, HttpHandlerInterface $next): ResponseInterface
    {
        //リクエストされたパスのルーティングパラメータ取得
        $params = $request->getRouteParam();
        //リクエストされたパスとルーティング定義が一致しない場合は$paramsにfalseが入っている。

        if ($params === false) {
            //Requestクラスのクライアントからのパス情報を添えて例外を発生させる
            throw new HttpNotFoundException(<<<EOF
 Exception caught in PathExists middleware.
 No route found for '{$request->getPathInfo()}'.
EOF
            );
        }

        print '<p>PathExists通過</p>';

        return $next->handle($request);
    }
}