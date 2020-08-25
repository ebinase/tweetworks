<?php

namespace App\System\Interfaces\Core;

use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

// 手続き型webアプリとしての入出力機能を定義するインターフェース
//リクエスト(入力)→処理→レスポンス(出力)と手続き型のモジュールを構成する。
interface ApplicationInterface
{
    //アプリケーション起動。デバッグモードの設定とURLをパースして対応するリクエストクラスを作成する。
    public function __construct($isDebagMode_set_manually = false);

    //作成したリクエストクラスを処理部分に渡す
    public function getRequest():RequestInterface;

    //処理部分が作成したレスポンスを受け取る。
    public function setResponse(ResponseInterface $response);

    //最後に送信
    public function send():void;
}