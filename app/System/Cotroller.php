<?php

namespace App\System;

use Cassandra\Exception\UnauthorizedException;

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

    protected $auth_actions = [];

    public function __construct(Application $application)
    {
        //コントローラ名いらんくね？
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

        if ($this->needsAuth($action_name) && ! $this->session->isAuthenticated()) {
            throw new UnauthorizedException();
        }

        return $this->$action_name($params);
    }

    //Viewクラスを呼び出して$contentを返してもらう
    protected function render($variables = [], $template = null, $layoute = 'layout')
    {
        //render()のパスはresourcesのフォルダ構成'hoge/foo'
        $defaults = [
            'request' => $this->request,
            'base_url' => $this->request->getBaseUrl(),
            'session' => $this->session,
        ];

        $view = new View($this->application->getViewDir(), $defaults);

        //FIXME: この辺、多分修正必要(理解できてない)
        if(is_null($template)) {
            $template = $this->action_name;
        }

        $path = $this->controller_name. '/' . $template;

        return $view->render($path, $variables, $layoute);
    }

    //==============================================================================
    // リダイレクト系
    //==============================================================================
    //指定された名前のメソッドがコントローラ内に存在しない時、
    //例外でApplicationのtry~catch文に捕捉させる
    protected function forward404()
    {
        throw new HttpNotFoundException(
            'Forwarded 404 page from ' . $this->controller_name. '/' . $this->action_name
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
    protected function needsAuth($action_name)
    {
        $needAuth = $this->auth_actions === true
            || is_array($this->auth_actions) && in_array($action_name, $this->auth_actions);
        if($needAuth) {
            return true;
        }
        return false;
    }
}