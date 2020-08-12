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

    /**
     * @var array | false
     */
    protected $_requestRouteParams;
    /*  例)
        $this->_requestRouteParams = [
            [controller]    => tweet,
            [action]        => post,
            [method]        => post,
            [middlewares]   => ['auth', 'csrf'],
            [name]          => null,
            [0]             => /post ,
        ];
     */

    //==============================================================================
    //コンストラクタ
    //==============================================================================
    public function __construct($debug = false)
    {
        // デバッグモードのオンオフを設定
        $this->setDebugMode($debug);
        // アプリケーションで保持しておくインスタンスの生成
        $this->initialize();
        // 要求されたURLに関する情報をApplicationに保存
        $this->_requestRouteParams = $this->setupRouteParams();

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
     * @return array $params
     */
    protected function setupRouteParams(){
        // $_routeにルーティング定義配列を登録する。
        $this->_registerRoutes();
        //ルーティング定義配列とクライアントから要求されたパスを取得
        $difinitions = $this->_route->getDifinitions();
        $required_path = $this->_request->getPathInfo();

        //Routerクラスのresolveメソッドで今回要求されたパスに関する情報だけを抜き出す
        return Router::resolve($difinitions, $required_path);
    }

    /**
     * ルーティング定義配列の読み込み
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
    //コントローラを起動してレスポンス内容をセット
    //==============================================================================
    public function run(): Application
    {
        $params = $this->_requestRouteParams;
        $controller = $params['controller'];
        $action = $params['action'];

        $content = $this->_runAction($controller, $action, $params);

        $this->_response->setContent($content);

        return $this;
    }

    protected function _runAction(string $controller_name, string $action_name, array $params = [])
    {
        //TODO: app/Controller/Authなどのディレクトリ内のコントローラーにも対応させる
        // 現状では下記の名前空間のせいで/Controller直下しか呼び出せない
        //名前空間を考慮して完全修飾名にする
        //参考：https://sousaku-memo.net/php-system/1417
//        $controller_name = str_replace('/', '\\', $controller_name);
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

    public function send() {
        $this->_response->send();
    }

    //==============================================================================
    //リダイレクト系
    //==============================================================================

    function redirect($url, $default = ''): void
    {
        //ベースURL以降を指定された場合(例：/user/hogehoge)
        if (! preg_match('#https?://#', $url)) {
            $url = $this->url($url);
        }

        $this->_response->setStatusCode(302, 'Found');
        $this->_response->setHttpHeader('Location', $url);

        $this->send();
        //FIXME: ログなどを残したい場合はエラーハンドラなどを搭載する
        exit();
    }

    public function url($uri)
    {
        $protocol = $this->_request->isSsl() ? 'https://' : 'http://';
        $host = $this->_request->getHost();
        $base_url = $this->_request->getBaseUrl();

        return $protocol . $host . $base_url . $uri;
    }


    public function render404Page($e)
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

    public function render500Page($e)
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
    // CSRF対策 //TODO:修正
    //==============================================================================
    public function generateCsrfToken($form_path)
    {
        $key = 'csrf_tokens/' . $form_path;
        $tokens = $this->_session->get($key, []);
        if(count($tokens) >= 10) {
            array_shift($tokens);
        }

        //FIXME:　トークンの暗号化の仕方(しっかりとした乱数生成器を用いる)
        $token = sha1($form_path. session_id() . microtime());
        $tokens[] = $token;

        $this->_session->set($key, $tokens);

        return $token;
    }

    //tokenをチェックして、一致したらその使用されたトークンを削除してそれ以外を戻してあげる
    public function checkCsrfToken($form_name, $token)
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->_session->get($key, []);

        if (($pos = array_search($token, $tokens, true)) !== false) {
            unset($tokens[$pos]);
            $this->_session->set($key, $tokens);

            return true;
        }
        return false;
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

    //コンストラクタで取得した現在のリクエストルートのコントローラなどの設定を配列で取得
    public function getRequestRouteParams()
    {
        return $this->_requestRouteParams;
    }
}