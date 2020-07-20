<?php

namespace App\System;

abstract class Cotroller
{
    //エラー通知用
    protected $controller_name;
    protected $action_name;
    //インスタンス
    protected $application;
    protected $request;
    protected $response;
    protected $session;


    public function __construct(Application $application)
    {
        $this->controller_name = strtolower(substr(get_class($this), 0, -10));

        $this->application = $application;
        $this->request = $application->getRequest();
        $this->response = $application->getResponse();
        $this->session = $application->getSession();
    }

    public function run(string $action_name, array $params = [])
    {
        $this->action_name = $action_name;

        if(! method_exists($this, $action_name)) {
            $this->forward404();
        }

        if ($this->needsAuth($params) && ! $this->session->isAuthenticated()) {
            //TODO: ログイン後に見ていた画面に戻る機能(laravelのold()関数)
            throw new UnauthorizedException("you are not authorized.");
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
            'request' => $this->request,
            'base_url' => $this->request->getBaseUrl(),
            'session' => $this->session,
        ];

        $view = new View($this->application->getViewDir(), $defaults);

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
    protected function forward404()
    {
        throw new HttpNotFoundException(
            "{$this->controller_name}->{$this->action_name} method does not exist."
        );
    }

    protected function redirect(string $url)
    {
        //ベースURL以降を指定された場合(例：/user/hogehoge)
        if (! preg_match('#https?://#', $url)) {
            $protocol = $this->request->isSsl() ? 'https://' : 'http://';
            $host = $this->request->getHost();
            $base_url = $this->request->getBaseUrl();

            $url = $protocol . $host . $base_url . $url;
        }

        $this->response->setStatusCode(302, 'Found');
        $this->response->setHttpHeader('Location', $url);
    }

    //==============================================================================
    // CSRF対策
    //==============================================================================
    protected function generateCsrfToken($form_name)
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->session->get($key, []);
        if(count($tokens) >= 10) {
            array_shift($tokens);
        }

        //FIXME:　トークンの暗号化の仕方
        $token = sha1($form_name. session_id() . microtime());
        $tokens[] = $token;

        $this->session->set($key, $tokens);

        return $token;
    }

    //tokenをチェックして、一致したらその使用されたトークンを削除してそれ以外を戻してあげる
    protected function checkCsrfToken($form_name, $token)
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->session->get($key, []);

        if (($pos = array_search($token, $tokens, true)) !== false) {
            unset($tokens[$pos]);
            $this->session->set($key, $tokens);

            return true;
        }
        return false;
    }


    //==============================================================================
    // 認証系
    //==============================================================================
    //FIXME:ログイン認証は絶対外部化したほうがいい

    protected function needsAuth($params):bool
    {
        if ($params['auth'] == '1') {
            return true;
        } elseif ($params['auth'] == '0') {
            return false;
        }
        throw new HttpNotFoundException("'auth' parameter in web.php is not correct.");
    }
}