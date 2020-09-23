<?php

namespace App\System\Classes;

use App\System\Interfaces\RouteInterface;

//ルーティング定義配列の作成やルーティングパラメータの提供をする
class Route implements RouteInterface
{
    // ルーティング定義配列
    /* 例)$_difinitions = [
               '/user/:user_id' => [
                  'controller' => 'user',
                  'action' => 'showUserPage',
                  'method' => 'get'
                  'auth' => 1,
                  'name' => 'user_page',
                  //↓ groupメソッドで追記
                  'group' => 'web'
               ],
               ・・・以下、各ルートごとの定義が続く・・・
           ];
   */
    private $_difinitions = [];


    //ルーティング定義配列一時保管用
    //形式はdifinitionsとほぼ一緒
    private $_tempArray = [];


    //==============================================================================
    //(ほぼ)コンストラクタ
    // →web.phpなどでRouteインスタンスを使う必要があるため、コンストラクタにはできない
    //==============================================================================

    //各ルートのタイプ(web, apiなど)に属するルートの登録とルーティング定義配列の登録
    function group($group, callable $callback)
    {
        //web.phpなどで定義されたルートを配列に変換して$this->_tempArrayに一時保管
        $callback($this);

        //各ルートが属するグループを登録
        foreach ($this->_tempArray as $url => $params) {
            $this->_tempArray[$url] = array_merge($this->_tempArray[$url], ['group' => $group]);
        }

        //ルーティング定義配列に$this->_tempArrayを登録
        $this->_difinitions = array_merge($this->_difinitions, $this->_tempArray);

        //他のグループから呼び出される場合に備えて一時保管用の配列を初期化
        $this->_tempArray = [];
    }

    public function get($url, $controller, $action, $middlewares = [], $name = null)
    {
        $this->_setRoutesArray($url, $controller, $action, 'get', $middlewares, $name);
    }

    public function post($url, $controller, $action, $middlewares = [], $name = null)
    {
        $this->_setRoutesArray($url, $controller, $action, 'post', $middlewares, $name);
    }

    function put($url, $controller, $action, $middlewares = [], $name = null)
    {
        $this->_setRoutesArray($url, $controller, $action, 'put', $middlewares, $name);
    }

    function delete($url, $controller, $action, $middlewares = [], $name = null)
    {
        $this->_setRoutesArray($url, $controller, $action, 'delete', $middlewares, $name);
    }

    //REST API用簡易設定メソッド
    function resource($url, $controller, $action, $middlewares = [], $name = null)
    {
        $this->get($url, $controller, $action, $middlewares = [], $name = null);
        $this->post($url, $controller, $action, $middlewares = [], $name = null);
        $this->put($url, $controller, $action, $middlewares = [], $name = null);
        $this->delete($url, $controller, $action, $middlewares = [], $name = null);
    }

    //web.phpなどで定義されたルートを配列に変換して$this->_tempArrayに一時保管
    private function _setRoutesArray($url, $controller, $action, $method, $middlewares, $name) {
        $this->_tempArray[$url] = [
            'controller' => $controller,
            'action' => $action,
            'method' => $method,
            'middlewares' => $middlewares,
            'name' => $name,
        ];
    }


//    function middleware($middleware)
//    {
//
//    }

    //==============================================================================
    //ゲッター/セッター
    //==============================================================================

    public function getDifinitions()
    {
        return $this->_difinitions;
    }

}