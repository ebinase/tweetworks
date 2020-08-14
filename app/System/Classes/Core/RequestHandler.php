<?php


namespace App\System\Core;

use App\System\Classes\Core\Application;
use App\System\Interfaces\RequestInterface;
use App\System\Interfaces\ResponseInterface;

class RequestHandler implements \App\System\Interfaces\Core\RequestHandlerInterface
{

    function handle(RequestInterface $request): ResponseInterface
    {
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
    }
}