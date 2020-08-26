<?php

namespace App\Middleware;

use App\System\Classes\Exceptions\HttpNotFoundException;
use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\Core\MiddlewareInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

class CheckRequestMethod implements MiddlewareInterface
{

    public function process(RequestInterface $request, HttpHandlerInterface $next): ResponseInterface
    {
        //ユーザーからのリクエストのHTTPメソッドの形式を取得(比較のため大文字から小文字に変換)
        $request_method = strtolower($request->getRequestMethod());

        //ルーティングパラメータに設定されているメソッドの値を取得
        $routeParam = $request->getRouteParam();

        if ($request_method !== $routeParam['method']) {
            $request_method = strtoupper($request_method);
            throw new HttpNotFoundException("wrong request method：requested {$request_method}");
        }

//        print 'CheckRequestMethod通過▶';
        return $next->handle($request);
    }
}