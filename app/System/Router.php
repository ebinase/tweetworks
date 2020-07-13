<?php

namespace App\System;

use App\System\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    //==============================================================================
    //コンストラクタ
    //==============================================================================
    public function __construct(array $difinitions)
    {
        $this->compileRoutes();
    }

    public function compileRoutes()
    {

    }

    //==============================================================================
    // Appllicationから呼び出すresolveメソッド
    //==============================================================================

    /**
     * requestクラスから$path_infoを受け取ってルーティング定義配列とマッチング
     *
     * @param string $path_info
     * @return mixed $params アクション名などの配列またはnull
     */
    public function resolve(string $path_info)
    {
        // TODO: Implement resolve() method.
    }
}