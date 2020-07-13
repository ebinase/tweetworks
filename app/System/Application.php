<?php

namespace App\System;

//Applicationはデータのやり取りをしないため、Interfaceは導入しない。

class Application
{
    protected $debug = false;
    protected $request;
    protected $response;
    protected $session;
    protected $router;

    //==============================================================================
    //コンストラクタ
    //==============================================================================
    public function __construct($debug = false)
    {
        $this->setDebugMode($debug);
        $this->initialize();
    }

    protected function setDebugMode($debug)
    {
        if ($debug) {
            $this->debug = true;
            ini_set('display_errors', 1);
            error_reporting(-1);
        } else {
            $this->debug = false;
            ini_set('display_errors', 0);
        }
    }

    protected function initialize()
    {
        //TODO: いろいろインスタンス化する処理を記述
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->registerRoutes());
    }

    /**
     * ルーティング定義配列を読み込み
     *
     * @return array
     */
    protected function registerRoutes(): array
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
        try {
            $params = $this->router->resolve($this->request->getPathInfo());
            if($params === false) {
                throw new HttpNotFoundException("No route found for {$this->request->getPathInfo()}.");
            }

            $controller = $params['controller'];
            $action = $params['action'];

            $this->runAction($controller, $action, $params);
        } catch (HttpNotFoundException $e) {
            $this->render404Page($e);
        }

        $this->response->send();
    }

    protected function runAction(string $controller_name, string $action_name, array $params)
    {
        //名前空間を考慮して完全修飾名にする
        //参考：https://sousaku-memo.net/php-system/1417
        $controller_class = '\\App\\Controller\\' . ucfirst($controller_name) . 'Controller';

        $controller = $this->findController($controller_class);
        if($controller === false) {
            throw new HttpNotFoundException("{$controller_class} is not found.");
        }

        $content = $controller->run($action_name, $params);

        $this->response->setContent($content);
    }
    //// $controller_classと同名のコントローラをインスタンス化して返す
    protected function findController(string $controller_class)
    {
        // FIXME: パーフェクトPHP 237ページの記述は必要なのか考える。
        // 下記は、ファイルが読み込めるかどうかで処理を分離せずに、簡易版とした
        $controller =  new $controller_class($this);
        if (isset($controller)) {
            return $controller;
        } else {
            return false;
        }
    }

    protected function render404Page($e)
    {
        // TODO:実装
    }


    //==============================================================================
    //その他のゲッター達
    //==============================================================================
        // TODO: 実装
}