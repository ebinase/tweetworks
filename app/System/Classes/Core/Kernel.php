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

    private $pipeline;


    //==============================================================================
    //処理
    //==============================================================================

    //Request、ファサードにするべき？
    public function __construct(RequestInterface $request)
    {
        $this->_initialize($application);

        $this->_registerSettings();
        $this->_bootstrap();
    }

    protected function _initialize(Application $application) {

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
        $this->_middlewares = array_unshift($this->_middlewares, $this->_middlewareGroups[$routeGroup]);

        //そのルート特有のミドルウェアを登録
        foreach ($params['middlewares'] as $middleware) {
            //$paramsに登録されたミドルウェアを追加する
            //FIXME: ミドルウェアが重複した際の対処(優先度：低)
            if (isset($this->_routeMiddleware[$middleware])) {
                あんシフト
            }
        }

        /**************/print '適用されるミドルウェアは';
        /**************/print_r($this->_middlewares);
    }

    public function build(HttpHandlerInterface $handler): HttpHandlerInterface
    {
        //初期化式
        $composedHandler = new $handler;
        //関数合成を行う
        foreach ($this->middlewares as $middleware) {
            $middlewareInstance = new $middleware;
            $composedHandler = new MiddlewareHandler($middlewareInstance, $composedHandler);
        }
        return $composedHandler;
    }

    public function handle():ResponseInterface
    {
        try {
            $this->pipeline->handle($request);

        } catch (\Exception $e) {
            $errorHandler = new ErrorHandler($request, $e);
        }
    }

}