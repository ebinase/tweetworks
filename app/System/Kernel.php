<?php

namespace App\System;

use App\System\Interfaces\Core\KernelInterface;
use App\System\Interfaces\Core\SingletonInterface;

use App\System\Exceptions\HttpNotFoundException;
use App\System\Exceptions\UnauthorizedException;

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


    public function __construct(Application $application)
    {
        $this->_initialize($application);

        $this->_registerSettings();
        $this->_bootstrap();
    }

    //Applicationのシングルトン機能からインスタンスを取得
    protected function _initialize(Application $application) {
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
        //$middlewares配列に追記をしていく
        $params = $this->_application->getRequestRouteParams();

        /**************/print_r($params);

        // ルートパラメータが存在しない時は$middlewaresを初期値のままにして即座にコンストラクタを終了。
        // するとインスタンス化後にPathExistsミドルウェアで弾かれて404エラーが生じる。
        if ($params === false) {
            return;
        }

        //ルートグループを取得(web / api / develop)
        $routeGroup = $params['group'];

        /**************/ print 'ルートグループは' . $routeGroup;

        // //今回のルートグループはどこか見極めてそのグループのミドルウェアを登録
        $this->_middlewares = array_merge($this->_middlewares, $this->_middlewareGroups[$routeGroup]);

        //そのルート特有のミドルウェアを登録
        foreach ($params['middlewares'] as $middleware) {
            //$paramsに登録されたミドルウェアを追加する
            //FIXME: ミドルウェアが重複した際の対処(優先度：低)
            if (isset($this->_routeMiddleware[$middleware])) {
                $this->_middlewares[] = $this->_routeMiddleware[$middleware];
            }
        }

        /**************/print '適用されるミドルウェアは';
        /**************/print_r($this->_middlewares);
    }
    
    

    public function handle(): void
    {
        try {
            foreach ($this->_middlewares as $middleware) {
                //FIXME: クロージャとかを使ってメソッドチェーンを作ってみたい
                $handler = new $middleware;
                $handler->handle($this->_application);
                //ハンドラを初期化
                unset($handler);
            }

            //$application->run();
            //TODO: afterミドルウェアの実装方法検討
        } catch (HttpNotFoundException $e) {
            $this->_application->render404Page($e);
        }
    }

}