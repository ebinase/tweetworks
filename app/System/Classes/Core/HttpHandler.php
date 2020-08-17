<?php


namespace App\System\Classes\Core;

use App\System\Classes\HTTP\Response;
use App\System\Exceptions\HttpNotFoundException;
use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

class HttpHandler implements HttpHandlerInterface
{

    public function handle(RequestInterface $request): ResponseInterface
    {
        //==============================================================================
        //コントローラを起動してレスポンスクラスを返す
        //==============================================================================

        $params = $request->getRouteParam();
        $controller = $params['controller'];
        $action = $params['action'];

        $content = $this->_runAction($controller, $action, $params);

        $response = new Response;
        $response->setContent($content);

        return $response;
    }

    protected function _runAction(string $controller_name, string $action_name, array $params = [])
    {
        //TODO: app/Controller/Authなどのディレクトリ内のコントローラーにも対応させる
        // 現状では下記の名前空間のせいで/Controller直下しか呼び出せない
        //名前空間を考慮して完全修飾名にする
        //参考：https://sousaku-memo.net/php-system/1417
//        $controller_name = str_replace('/', '\\', $controller_name);
        //フォルダ名とコントローラ名をスラッシュで区切って先頭大文字化(クラス名だけ。フォルダ名は入力値のまま)
        $controller_class = '\\App\\Controller\\' . ucfirst($controller_name) . 'Controller';

        $controller = $this->_findController($controller_class);
        if($controller === false) {
            throw new HttpNotFoundException("{$controller_class} is not found.");
        }

        return $controller->run($action_name, $params);
    }

    // $controller_classと同名のコントローラをインスタンス化して返す
    protected function _findController(string $controller_class)
    {
        $controller =  new $controller_class($this);
        if (isset($controller)) {
            return $controller;
        } else {
            return false;
        }
    }
}