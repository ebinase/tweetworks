<?php

namespace App\System;

//Applicationはデータのやり取りをしないため、Interfaceは導入しない。
class Application
{
    protected $debug = false;
    protected $request;
    protected $response;
    protected $session;

    //==============================================================================
    //コンストラクタ
    //==============================================================================
    public function __construct()
    {
        // TODO: デバッグモード搭載

//        $this->initialize();
         print_r($this->registerRoutes());
//        print_r($this->registerRoutes());
    }

    private function initialize()
    {

    }

    /**
     * ルーティング定義配列を読み込み
     *
     * @return array
     */
    private function registerRoutes()
    {
        // FIXME: dirname(__FILE__)を使った絶対パス指定ができなかった。
        require_once  "../route/web.php";
        // FIXME: 関数ではなくシンプルに配列として読み込めないものか・・・
        return web();
    }


    //==============================================================================
    //すべての処理の起点
    //==============================================================================
    public function run()
    {
        //最後のsend()以外はtry~catch文中に記述
    }

    protected function runAction(string $controller_name, string $action_name, array $params)
    {

    }

    protected function findController()
    {

    }

    //==============================================================================
    //その他のゲッター達
    //==============================================================================
        // TODO: あとで実装
}