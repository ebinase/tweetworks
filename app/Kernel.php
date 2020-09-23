<?php

namespace App;

use App\System\Classes\Core\Kernel as HttpKernel;

final class Kernel extends HttpKernel
{
    //==============================================================================
    //ミドルウェアの設定
    //ここに記入したミドルウェアが上から順に実行される。
    //==============================================================================

    function _registerSettings()
    {
        //全てのルートに対して実行するミドルウェア
         $this->_middlewares = [
            \App\Middleware\PathExists::class,
            \App\Middleware\CheckRequestMethod::class,
        ];

         //グループごとに実行するミドルウェア
        $this->_middlewareGroups = [
            'web' => [
                \App\Middleware\SessionReferer::class,
            ],
            'api' => [

            ],
            'admin' => [
                \App\Middleware\SessionReferer::class,
                \App\Middleware\AdminAuthenticate::class,
            ],
        ];

        //各ルートで個別に設定できるミドルウェア
        // 「/route」フォルダのファイルで設定できる。
        $this->_routeMiddleware = [
            'auth' => \App\Middleware\Authenticate::class,
            'guest' => \App\Middleware\Guest::class,
            'csrf' => \App\Middleware\VerifyCsrfToken::class,
        ];

        }
}