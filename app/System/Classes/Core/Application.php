<?php

namespace App\System\Classes\Core;
//
use App\System\Interfaces\Core\ApplicationInterface;

use App\System\Classes\Facades\App;
use App\System\Classes\Services\Env;
use App\System\Classes\Services\Service;

use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;
use App\System\Interfaces\RouteInterface;
use App\System\Classes\Router;

//todo: Controllerからリダイレクト系移行
class Application implements ApplicationInterface
{
    protected $_debug = false;
    protected $_request;
    protected $_response;

    //==============================================================================
    //コンストラクタ
    //==============================================================================
    public function __construct($isDebagMode_set_manually = null)
    {
        try {
            // アプリケーションで使用するパッケージのインスタンスの生成
            $this->initialize();
            // デバッグモードを手動で変更(基本は.envの値を参照する)
            $this->setDebugMode($isDebagMode_set_manually);

            // 要求されたURLに関する情報をRequestに保存
            $routeParam = $this->perseRouteParams(Service::call('request'), Service::call('route'));
            var_dump($routeParam);

            //FIXME: サービスロケータになってる＆コンテナの意味がなくなってる。
            $this->_request = Service::call('request');
            $this->_request->setRouteParam($routeParam);
            //これらの処理が済んだらRequestがKernelに引き渡される。
        } catch (\Exception $e) {
            print '<p>Faild to Boot Application</p>';
            print $e->getMessage();
            die();
        }
    }

    protected function setDebugMode($isDebagMode_set_manually)
    {
        //Applicationクラスに引数が設定されていたらデバッグの設定を上書き
        if ( isset($isDebagMode_set_manually) ) {
            $debug_mode = $isDebagMode_set_manually ? 'true' : 'false';
            Env::update('APP_DEBUG', $debug_mode);
        }

        //何も設定されていなかったら.envのAPP_DEBUGの値に従う
        print Env::get('APP_DEBUG');
        if (Env::get('APP_DEBUG') == 'true') {
            ini_set('display_errors', 1);
            error_reporting(-1);
        } else {
            ini_set('display_errors', 0);
        }
    }

    protected function initialize()
    {
        Service::boot();
        Env::boot();
    }

    //TODO:ルーティング関連処理の最適化
    /**
     * クライアントに要求されたパスに関する情報だけを取得しRouteクラスに保存
     * @param RequestInterface $request
     * @param RouteInterface $route
     * @return array $params
     */
    protected function perseRouteParams(RequestInterface $request, RouteInterface $route){
        // $_routeにルーティング定義配列を登録する。
        $this->_registerRoutes($route);
        //ルーティング定義配列とクライアントから要求されたパスを取得
        $difinitions = $route->getDifinitions();
        $required_path = $request->getPathInfo();

        //Routerクラスのresolveメソッドで今回要求されたパスに関する情報だけを抜き出す
        return Router::resolve($difinitions, $required_path);
    }

    /**
     * ルーティング定義配列の読み込み
     *
     * @param RouteInterface $route
     * @return void
     */
    protected function _registerRoutes(RouteInterface $route) :void
    {
        //このあたりの読み込み処理はRouteクラスのコンストラクタでやりたいが、
        //web.phpなどでRouteインスタンスを使う必要があるため、インスタンス化後に読み込むしか無い・・・

        //TODO: ルートの取得方法変更
        require_once  App::routeDir() . '/web.php';
        registerWebRoutes($route);
        require_once  App::routeDir() . '/api.php';
        registerApiRoutes($route);
        require_once  App::routeDir() . '/develop.php';
        registerDevelopRoutes($route);
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

    public function isDebugMode()
    {
        return $this->_debug;
    }
}