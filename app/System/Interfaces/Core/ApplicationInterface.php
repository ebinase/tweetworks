<?php

namespace App\System\Interfaces\Core;

use App\System\Exceptions\HttpNotFoundException;

// webアプリとしての機能のインターフェース
interface ApplicationInterface
{
    //アプリケーション起動。デバッグモードの設定と様々なクラスのインスタンス化を行う。
    function __construct($debug = false);


    /**
     * リダイレクトを行う
     *
     * @param string $path フルURLでも短縮URLでも機能。
     * @param string $default 本来は設定してもリダイレクトでは表示されないが、下記のreturnを意識させるために明示的に実装。
     * @return string Controller->run()は必ずstringを返すように設定されているため、$defaultの文字列を返す。
     */
    function redirect($path, $default = ''): string;

    //Kernel、Controllerの中で使用されることを想定。
    function render404Page(\Exception $e);
    function render500Page(\Exception $e);

    //最後のレスポンスを返す際に使用。
    function send();
}