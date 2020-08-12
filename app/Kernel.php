<?php

namespace App;

use App\System\Kernel as HttpKernel;

final class Kernel extends HttpKernel
{
    //==============================================================================
    //ミドルウェアの設定
    //==============================================================================

    function _registerSettings()
    {
         $this->_middlewares = [
            \App\Middleware\PathExists::class,
            \App\Middleware\CheckRequestMethod::class,
        ];

        $this->_middlewareGroups = [
            'web' => [

            ],
            'api' => [

            ],
            'develop' => [

            ],
        ];

        //各コントローラのコンストラクタでRoute->middleware('hoge')で指定すると
        //下記のクラスをアクションの前に自動的に実行
        $this->_routeMiddleware = [
            'auth' => \App\Middleware\Authenticate::class,
            'guest' => \App\Middleware\Guest::class,
//            'csrf' => \App\Middleware\VerifyCsrfToken::class,
        ];

        }
}