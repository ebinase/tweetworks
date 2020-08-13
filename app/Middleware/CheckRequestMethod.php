<?php

namespace App\Middleware;

use App\System\Application;
use App\System\Exceptions\HttpNotFoundException;
use App\System\Interfaces\Core\MiddlewareInterface;

class CheckRequestMethod implements MiddlewareInterface
{

    public function handle(Application $application): Application
    {
        //ユーザーからのリクエストのHTTPメソッドの形式を取得(比較のため大文字から小文字に変換)
        $request_method = strtolower($application->getRequest()->getRequestMethod());

        //ルーティングパラメータに設定されているメソッドの値を取得
        $routeParam = $application->getRequestRouteParams();

        if ($request_method !== $routeParam['method']) {
            throw new HttpNotFoundException('wrong request method');
        }

        print '<p>CheckRequestMethod通過</p>';
        return $application;
    }
}