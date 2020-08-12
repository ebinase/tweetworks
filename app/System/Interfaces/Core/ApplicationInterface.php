<?php

namespace App\System\Interfaces\Core;

use App\System\Exceptions\HttpNotFoundException;

// webアプリとしての機能のインターフェース
interface ApplicationInterface
{
    //アプリケーション起動。デバッグモードの設定と様々なクラスのインスタンス化を行う。
    function __construct($debug = false);

    //FIXME: リクエストされたルート情報の置き場所はApplicationでいいのか・・・
    //コンストラクタで取得した現在のリクエストルートのコントローラなどの設定を配列で取得
    function getRequestRouteParams();

    /**
     * リダイレクトを行う
     *
     * @param string $url フルURLでも短縮URLでも機能。
     *
     * 最後にexitを実行
     */
    function redirect($url);

    function url($uri);

    //Kernel、Controllerの中で使用されることを想定。
    function render404Page(\Exception $e);
    function render500Page(\Exception $e);

    //最後のレスポンスを返す際に使用。
    function send();
}