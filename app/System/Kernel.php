<?php

namespace App\System;

use App\System\Interfaces\Core\KernelInterface;
use App\System\Interfaces\Core\SingletonInterface;

abstract class Kernel implements KernelInterface
{
    // app/Kernel.phpで設定する
    protected $_middlewares;
    protected $_middlewareGroups;
    protected $_routeMiddleware;


    //==============================================================================
    //処理
    //==============================================================================
    private $_application;
    private $_request;
    private $_response;
    private $_route;
    private $_session;
    private $_messenger;

    //コンストラクタで生じたエラー取得用
    private $_bootError = false;

    public function __construct(Application $application)
    {
        $this->_initialize($application);

        $this->_registerSettings();
        $this->_bootstrap();
    }

    //Applicationのシングルトン機能からインスタンスを取得
    protected function _initialize(SingletonInterface $application) {
        $this->_application = $application;
        $this->_request = $application->getRequest();
        $this->_response = $application->getResponse();
        $this->_route = $application->getRoute();
        $this->_session = $application->getSession();
        $this->_messenger = $application->getMessenger();
    }

    // app/Kernel.phpの設定を読み込む
    abstract function _registerSettings();

    protected function _bootstrap() {
        //TODO: afterミドルウェアの実装方法検討
        //$middlewares配列に追記をしていく
        //今回のルートグループはどこか見極めてそのグループのミドルウェアを登録
        $params = $this->_application->getRequestRouteParams();

        /**************/print_r($params);

        // ルートパラメータが存在しない時はエラーを保存しておいてインスタンス化後に404エラーを投げる
        if ($params === false) {
            $this->_bootError = true;
            return;
        }

        //ルートグループを取得(web / api / develop)
        $routeGroup = $params['group'];

        /**************/ print $routeGroup;

        /**************/print_r($this->_middlewareGroups);
        // 各ルートグループに適用するmiddlewareを登録
        $this->_middlewares = array_merge($this->_middlewares, $this->_middlewareGroups[$routeGroup]);

        //そのルート特有のミドルウェアを登録
        foreach ($params['middlewares'] as $middleware) {
            /**************/print $middleware;
            //$paramsに登録されたミドルウェアを追加する
            //仮にミドルウェアが重複しても上書きされるため、問題ない
            $this->_middlewares[] = $this->_routeMiddleware[$middleware];
        }
        /**************/print_r($this->_middlewares);
    }
    
    

    public function handle(): void
    {
        // TODO: Implement handle() method.
    }

}