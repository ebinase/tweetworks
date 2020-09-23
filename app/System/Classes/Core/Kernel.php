<?php

namespace App\System\Classes\Core;

use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\Core\KernelInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

abstract class Kernel implements KernelInterface
{
    // app/Kernel.phpで設定する
    protected $_middlewares;
    protected $_middlewareGroups;
    protected $_routeMiddleware;

    //==============================================================================
    //処理
    //==============================================================================

    public function __construct(RequestInterface $request)
    {
        $this->_registerSettings();
        $this->_bootstrap($request);
    }

    // app/Kernel.phpの設定を読み込む
    abstract function _registerSettings();

    protected function _bootstrap($request) {
        //$middlewares配列に追記をしていく
        $params = $request->getRouteParam();

        // ルートパラメータが存在しない時は$middlewaresを初期値のままにして即座にコンストラクタを終了。
        // するとインスタンス化後にPathExistsミドルウェアで弾かれて404エラーが生じる。
        if ($params === false) {
            return;
        }

        //ルートグループを取得(web / api / develop)
        $routeGroup = $params['group'];

        //今回のルートグループはどこか見極めてそのグループのミドルウェアを登録
        $this->_middlewares = array_merge($this->_middlewares, $this->_middlewareGroups[$routeGroup]);

        //そのルート特有のミドルウェアを登録
        foreach ($params['middlewares'] as $middleware) {
            //$paramsに登録されたミドルウェアを追加する
            if (isset($this->_routeMiddleware[$middleware])) {
                $this->_middlewares[] = $this->_routeMiddleware[$middleware];
            }
        }

    }


    public function build(): HttpHandlerInterface
    {
        //配列とは逆の順番でミドルウェアが実行されるため、事前に配列を反転させて、記入した順に実行されるようにする。
        $middlewares = array_reverse($this->_middlewares);
        //初期化式
        $pipeline = new HttpHandler;
        //関数合成を行う
        foreach ($middlewares as $middleware) {
            $middlewareInstance = new $middleware;
            $pipeline = new MiddlewareHandler($middlewareInstance, $pipeline);
        }
        return $pipeline;
    }

    public function handle(RequestInterface $request, HttpHandlerInterface $pipeline):ResponseInterface
    {
        try {
            return $pipeline->handle($request);

        } catch (\Exception $e) {
            $errorHandler = new ErrorHandler();
            return $errorHandler->handle($request, $e);
        }
    }

}