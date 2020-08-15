<?php

namespace App\System\Classes\Core;

use App\System\Interfaces\Core\ApplicationInterface;

use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;
use App\System\Router;

//todo: Controllerからリダイレクト系移行
class Application implements ApplicationInterface
{
    protected $_debug = false;
    protected $_request;
    protected $_response;

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
        // 要求されたURLに関する情報をRequestに保存
        $this->_requestRouteParams = $this->perseRouteParams();

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
    }

    /**
     * クライアントに要求されたパスに関する情報だけを取得しRouteクラスに保存
     * @param void
     * @return array $params
     */
    protected function perseRouteParams(){
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
    // リクエストインスタンスを処理層に提供
    //==============================================================================
    public function getRequest(): RequestInterface
    {
        return $this->_request;
    }


    //==============================================================================
    // 処理層からレスポンスインスタンスを取得
    //==============================================================================
    public function setResponse(ResponseInterface $response)
    {
        $this->_response = $response;
    }

    //==============================================================================
    // 送信
    //==============================================================================
    public function send(): void
    {
        header('HTTP/1.1 ' . $this->_status_code . ' ' . $this->_status_text);

        foreach ($this->_http_headers as $name => $value){
            header($name . ':' . $value);
        }

        echo $this->_content;
    }


    //==============================================================================
    //その他のゲッター達
    //==============================================================================
    public function isDebugMode()
    {
        return $this->_debug;
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