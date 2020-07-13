<?php

namespace App\System;

//Applicationはデータのやり取りをしないため、Interfaceは導入しない。
use App\Model\Tweet;

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
        $this->initialize();

        $tweet = new Tweet();
        print_r($tweet->getAllTweet());
    }

    private function initialize()
    {
        //TODO: いろいろインスタンス化する処理を記述
        $this->registerRoutes();
    }

    /**
     * ルーティング定義配列を読み込み
     *
     * @return array
     */
    private function registerRoutes(): array
    {
        // FIXME: dirname(__FILE__)を使った絶対パス指定ができなかった。
        require_once  "../route/web.php";
        // FIXME: 関数ではなくシンプルに配列として読み込めないものか・・・
        return getWebRoutes();
    }


    //==============================================================================
    //すべての処理の起点
    //==============================================================================
    public function run()
    {
        //最後のsend()以外はtry~catch文中に記述
        //パーP、241ページ参照
    }

    protected function runAction(string $controller_name, string $action_name, array $params)
    {
        //注意：名前空間を意識して呼び出す必要あるかも
        //参照：https://sousaku-memo.net/php-system/1417
    }

    protected function findController()
    {

    }

    //==============================================================================
    //その他のゲッター達
    //==============================================================================
        // TODO: 実装
}