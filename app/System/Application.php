<?php

namespace App\System;

//Applicationはデータのやり取りをしないため、Interfaceは導入しない。
class Application
{
    protected $_debug = false;
    protected $_request;
    protected $_response;
    protected $_session;
    protected $_router;

    protected $_errors;

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
            $this->_debug = true;
            ini_set('display_errors', 1);
            error_reporting(-1);
        } else {
            $this->_debug = false;
            ini_set('display_errors', 0);
        }
    }

    protected function initialize()
    {
        $this->_request = new Request();
        $this->_response = new Response();
        $this->_session = new Session();
        $this->_router = new Router($this->_registerRoutes());

        $this->_errors = new Errors($this->_session);
    }

    /**
     * ルーティング定義配列を読み込み
     *
     * @return array
     */
    protected function _registerRoutes(): array
    {
        require_once  $this->getRouteDir() . '/web.php';
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
            $params = $this->_router->resolve($this->_request->getPathInfo());
            if($params === false) {
                throw new HttpNotFoundException("No route found for {$this->_request->getPathInfo()}.");
            }

            $controller = $params['controller'];
            $action = $params['action'];

            $this->_runAction($controller, $action, $params);

        } catch (HttpNotFoundException $e) {
            $this->_render404Page($e);

        } catch (UnauthorizedException $e) {
            //認証エラーが出たらログイン画面へ
            // FIXME: login画面への移行に修正。
            // $this->runAction($controller, $action);
            $this->_render404Page($e);

        }  catch (\PDOException $e) {
            $this->_render500Page($e);
        }

        $this->_response->send();
    }

    protected function _runAction(string $controller_name, string $action_name, array $params = [])
    {
        //名前空間を考慮して完全修飾名にする
        //参考：https://sousaku-memo.net/php-system/1417
        $controller_class = '\\App\\Controller\\' . ucfirst($controller_name) . 'Controller';

        $controller = $this->_findController($controller_class);
        if($controller === false) {
            throw new HttpNotFoundException("{$controller_class} is not found.");
        }

        $content = $controller->run($action_name, $params);

        $this->_response->setContent($content);
    }

    //// $controller_classと同名のコントローラをインスタンス化して返す
    protected function _findController(string $controller_class)
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

    protected function _render404Page($e)
    {
        $this->_response->setStatusCode(404, 'Not Found');
        $message = $this->isDebugMode() ? $e->getMessage() : 'Page not Found';
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $this->_response->setContent(<<<EOF
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>page not found</title>
</head>
<body>
<h1>404</h1>
{$message}
</body>
</html>
EOF
        );
    }

    protected function _render500Page($e)
    {
        $this->_response->setStatusCode(500, 'Internal Server Error');
        $message = $this->isDebugMode() ? $e->getMessage() : 'Internal Server Error';
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $this->_response->setContent(<<<EOF
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Internal Server Error</title>
</head>
<body>
<h1>500</h1>
{$message}
</body>
</html>
EOF
        );
    }


    //==============================================================================
    //その他のゲッター達
    //==============================================================================
    public function isDebugMode()
    {
        return $this->_debug;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function getResponse()
    {
        return $this->_response;
    }

    public function getSession()
    {
        return $this->_session;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function getRootDir()
    {
        return str_replace('/app/System/Application.php', '', __FILE__);
    }

    public function getControllerDir()
    {
        return $this->getRootDir() . '/app/Controller';
    }

    public function getViewDir()
    {
        return $this->getRootDir() . '/resources/views';
    }

    public function getModelDir()
    {
        return $this->getRootDir() . '/app/Model';
    }

    public function getRouteDir()
    {
        return $this->getRootDir() . '/route';
    }
}