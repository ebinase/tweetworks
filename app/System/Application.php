<?php

namespace App\System;

use App\System\Components\Messenger;
use App\System\Exceptions\HttpNotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Interfaces\Core\ApplicationInterface;
use App\System\Interfaces\Core\SingletonInterface;
use App\System\Interfaces\Core\HandlerInterface;

//todo: Controllerからリダイレクト系移行
class Application implements SingletonInterface, HandlerInterface, ApplicationInterface
{
    protected $_debug = false;
    protected $_request;
    protected $_response;
    protected $_session;
    protected $_route;

    protected $_messenger;

    //==============================================================================
    //コンストラクタ
    //==============================================================================
    public function __construct($debug = false)
    {
        // デバッグモードのオンオフを設定
        $this->setDebugMode($debug);
        // アプリケーションで保持しておくインスタンスの生成
        $this->initialize();
        // 要求されたURLに関する情報をRouteクラスに設定
        $this->setupRouteParams();

        //これらの処理が済んだらApplicationインスタンスごとKernelに引き渡される。
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
        $this->_route = new Route();

        $this->_messenger = new Messenger($this->_session);
    }

    /**
     * クライアントに要求されたパスに関する情報だけを取得しRouteクラスに保存
     * @param void
     * @return void
     */
    protected function setupRouteParams(){
        // $_routeにルーティング定義配列を登録する。
        $this->_registerRoutes();
        //ルーティング定義配列とクライアントから要求されたパスを取得
        $difinitions = $this->_route->getDifinitions();
        $required_path = $this->_request->getPathInfo();

        //Routerクラスのresolveメソッドで今回要求されたパスに関する情報だけを抜き出す
        $params = Router::resolve($difinitions, $required_path);
        //ルートに関する情報を管理するRouteクラスに保存
        $this->_route->setParams($params);
    }

    /**
     * ルーティング定義配列を読み込み
     *
     * @return void
     */
    protected function _registerRoutes() :void
    {
        //このあたりの読み込み処理はRouteクラスのコンストラクタでやりたいが、
        //web.phpなどでRouteインスタンスを使う必要があるため、インスタンス化後に読み込むしか無い・・・

        require_once  self::getRouteDir() . '/web.php';
        registerWebRoutes($this->_route);
        require_once  self::getRouteDir() . '/api.php';
        registerApiRoutes($this->_route);
        require_once  self::getRouteDir() . '/develop.php';
        registerDevelopRoutes($this->_route);
    }


    //==============================================================================
    //すべての処理の起点
    //==============================================================================
    public function run(): Application
    {
        //最後のsend()以外はtry~catch文中に記述
        try {
            $params = $this->_route->getParams();
            if($params === false) {
                throw new HttpNotFoundException("No route found for {$this->_request->getPathInfo()}.");
            }

            $controller = $params['controller'];
            $action = $params['action'];

            $content = $this->_runAction($controller, $action, $params);

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

        $this->_response->setContent($content);

        return $this;
    }

    protected function _runAction(string $controller_name, string $action_name, array $params = [])
    {
        //TODO: app/Controller/Authなどのディレクトリ内のコントローラーにも対応させる
        // 現状では下記の名前空間のせいで/Controller直下しか呼び出せない
        //名前空間を考慮して完全修飾名にする
        //参考：https://sousaku-memo.net/php-system/1417
        $controller_class = '\\App\\Controller\\' . ucfirst($controller_name) . 'Controller';

        $controller = $this->_findController($controller_class);
        if($controller === false) {
            throw new HttpNotFoundException("{$controller_class} is not found.");
        }

        return $controller->run($action_name, $params);
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

    function redirect($path, $default = ''): string
    {
        // TODO: Implement redirect() method.
    }

    function render404Page(\Exception $e)
    {
        // TODO: Implement render404Page() method.
    }

    function render500Page(\Exception $e)
    {
        // TODO: Implement render500Page() method.
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

    public function send() {
        $this->_response->send();
    }


    //==============================================================================
    //その他のゲッター達
    //==============================================================================
    public function isDebugMode()
    {
        return $this->_debug;
    }

    public function getRequest(): Request
    {
        return $this->_request;
    }

    public function getResponse(): Response
    {
        return $this->_response;
    }

    public function getRoute(): Route
    {
        return $this->_route;
    }

    public function getSession(): Session
    {
        return $this->_session;
    }

    public function getMessenger(): Messenger
    {
        return $this->_messenger;
    }

    public static function getRootDir()
    {
        return str_replace('/app/System/Application.php', '', __FILE__);
    }

    public static function getControllerDir()
    {
        return self::getRootDir() . '/app/Controller';
    }

    public static function getViewDir()
    {
        return self::getRootDir() . '/resources/views';
    }

    public static function getModelDir()
    {
        return self::getRootDir() . '/app/Model';
    }

    public static function getRouteDir()
    {
        return self::getRootDir() . '/route';
    }

}