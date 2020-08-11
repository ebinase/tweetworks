<?php

namespace App\System;

use App\System\Exceptions\HttpNotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Interfaces\ControllerInterface;

abstract class Controller implements ControllerInterface
{
    //エラー通知用
    protected $_controller_name;
    protected $_action_name;
    //インスタンス
    protected $_application;
    protected $_request;
    protected $_response;
    protected $_route;
    protected $_session;

    protected $_messenger;


    public function __construct(Application $application)
    {
        $this->_controller_name = strtolower(substr(get_class($this), 0, -10));

        $this->_application = $application;
        $this->_request = $application->getRequest();
        $this->_response = $application->getResponse();
        $this->_route = $application->getRoute();
        $this->_session = $application->getSession();
        $this->_messenger = $application->getMessenger();
    }

    public function run(string $action_name, array $params = []): string
    {
        $this->_action_name = $action_name;

        if(! method_exists($this, $action_name)) {
            //TODO: このメソッド廃止。エラー管理は一括でKernelへ
            $this->_forward404();
        }

        if ($this->_needsAuth($params) && ! $this->_session->isAuthenticated()) {
            //TODO: ログイン後に見ていた画面に戻る機能(laravelのold()関数)
//            throw new UnauthorizedException("you are not authorized.");
            return $this->_redirect('/login');
        }
        return $this->$action_name($params);
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
        //render()のパスはresourcesのフォルダ構成'hoge/foo'
        $defaults = [
            '_request' => $this->_request,
            '_url' => $this->_route->mapFullUrls($this->_request->getBaseUrl()),
            '_session' => $this->_session,
        ];

        $view = new View($this->_application::getViewDir(), $defaults);

        // ↓テンプレート名を省略可能にする必要性を感じないためコメントアウト
        // $pathが入力されてなかったらアクション名を自動で代入してあげる
//        if(is_null($path)) {
//            $path = $this->action_name;
//        }

        // フォルダ構成を/views/アクション名/ビューファイル.phpに固定するのは悪手
        // $path = $this->controller_name. '/' . $template;


        return $view->render($path, $variables, $layout_path);
    }

    //==============================================================================
    // リダイレクト系
    //==============================================================================
    //指定された名前のメソッドがコントローラ内に存在しない時、
    //例外でApplicationのtry~catch文に捕捉させる
    protected function _forward404()
    {
        throw new HttpNotFoundException(
            "{$this->_controller_name}->{$this->_action_name} method does not exist."
        );
    }

    protected function _redirect(string $url)
    {
        //ベースURL以降を指定された場合(例：/user/hogehoge)
        if (! preg_match('#https?://#', $url)) {
            $url = $this->_fullUrl($url);
        }

        $this->_response->setStatusCode(302, 'Found');
        $this->_response->setHttpHeader('Location', $url);
    }

    // ベースURL以降のurlをフルバージョンのurlに変換
    protected function _fullUrl($uri)
    {
        $protocol = $this->_request->isSsl() ? 'https://' : 'http://';
        $host = $this->_request->getHost();
        $base_url = $this->_request->getBaseUrl();

        return $protocol . $host . $base_url . $uri;
    }

    //==============================================================================
    // CSRF対策
    //==============================================================================
    protected function _generateCsrfToken($form_name)
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->_session->get($key, []);
        if(count($tokens) >= 10) {
            array_shift($tokens);
        }

        //FIXME:　トークンの暗号化の仕方(しっかりとした乱数生成器を用いる)
        $token = sha1($form_name. session_id() . microtime());
        $tokens[] = $token;

        $this->_session->set($key, $tokens);

        return $token;
    }

    //tokenをチェックして、一致したらその使用されたトークンを削除してそれ以外を戻してあげる
    protected function _checkCsrfToken($form_name, $token)
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->_session->get($key, []);

        if (($pos = array_search($token, $tokens, true)) !== false) {
            unset($tokens[$pos]);
            $this->_session->set($key, $tokens);

            return true;
        }
        return false;
    }


    //==============================================================================
    // 認証系
    //==============================================================================
    //FIXME:ログイン認証は絶対外部化したほうがいい

    protected function _needsAuth($params):bool
    {
        if ($params['auth'] == '1') {
            return true;
        } elseif ($params['auth'] == '0') {
            return false;
        }
        throw new HttpNotFoundException("'auth' parameter in web.php is not correct.");
    }
}