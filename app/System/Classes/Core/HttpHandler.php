<?php


namespace App\System\Classes\Core;

use App\System\Classes\Exceptions\HttpNotFoundException;
use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

class HttpHandler implements HttpHandlerInterface
{
    private $_request;

    //==============================================================================
    //コントローラを起動してレスポンスクラスを返す
    //==============================================================================
    public function handle(RequestInterface $request): ResponseInterface
    {
        $params = $request->getRouteParam();
        $controller = $params['controller'];
        $action = $params['action'];

        //コントローラからレスポンスインスタンスが帰ってくる
        $response = $this->_runAction($controller, $action, $request);

        return $response;
    }

    protected function _runAction(string $controller_name, string $action_name, RequestInterface $request)
    {
        //名前空間を考慮して完全修飾名にする
        //参考：https://sousaku-memo.net/php-system/1417
        //FIXME: スラッシュの後を自動で大文字に変換したい(auth/login ▶ Auth\Login)
//        //フォルダの階層ごとに区切って配列に格納(例：/Auth/Login ▶ ['Auth', 'Login'])
//        $names = explode('/', $controller_name);
//        $combind_name = '';
//        foreach ($names as $name) {
//            $combind_name = $combind_name. ucfirst($name) . '\\';
//        }
        $controller_name = str_replace('/', '\\', $controller_name);
        //フォルダ名とコントローラ名をスラッシュで区切って先頭大文字化(クラス名だけ。フォルダ名は入力値のまま)
        $controller_class = '\\App\\Controller\\' . ucfirst($controller_name) . 'Controller';

        $controller = $this->_findController($controller_class);
        if($controller === false) {
            throw new HttpNotFoundException("{$controller_class} is not found.");
        }

        return $controller->run($action_name, $request);
    }

    // $controller_classと同名のコントローラをインスタンス化して返す
    protected function _findController(string $controller_class)
    {
        $controller =  new $controller_class();
        if (isset($controller)) {
            return $controller;
        } else {
            return false;
        }
    }
}