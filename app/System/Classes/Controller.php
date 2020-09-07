<?php

namespace App\System\Classes;

use App\System\Classes\Facades\App;
use App\System\Classes\HTTP\Response;
use App\System\Classes\Exceptions\HttpNotFoundException;
use App\System\Interfaces\ControllerInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

abstract class Controller implements ControllerInterface
{
    //エラー通知用
    protected $_controller_name;
    protected $_action_name;

    public function run(string $action_name, RequestInterface $request): ResponseInterface
    {
        $this->_controller_name = strtolower(substr(get_class($this), 0, -10));
        $this->_action_name = $action_name;

        if(! method_exists($this, $action_name)) {
            throw new HttpNotFoundException(
                "{$this->_controller_name}->{$this->_action_name} method does not exist."
            );
        }

        //アクションで処理を行う
        $content = $this->$action_name($request);
        //通常は文字列が帰ってきて、リダイレクトの場合はResponseインスタンスが帰ってくる。

        if ($content instanceof ResponseInterface ) {
            //リダイレクトが呼ばれてResponseインスタンスが帰ってきた場合
            $response = $content;
        } else {
            //直接入力、またはrender()メソッドの結果で、文字列が帰って来た場合
            $response = new Response;
            $response->setContent($content);
        }

        return $response;
    }

    /**
     * Viewクラスを呼び出して$contentを返してもらう
     *
     * 記法は基本的にlaravel準拠(違うのはレイアウトがある場合にそのパスを書く必要があるくらい)
     * パスはtweetworks/resources/views/以降を記述
     * 記入例：$this->render('index',['name' => 'James'], 'layout/lauout');
     *
     * @param string $path テンプレートのパス
     * @param array $variables (省略可)画面表示したい変数等を連想配列(テンプレートの変数名 => 変数など)の形で
     * @param string|false $layout_path (省略可)レイアウトのパス
     * @return string
     */
    protected function render(string $path , array $variables = [], $layout_path = false)
    {

        $view = new View(App::viewDir());

        // htmlエスケープ処理
        $variables = escapeVariables($variables);

        return $view->render($path, $variables, $layout_path);
    }
}