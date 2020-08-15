<?php

namespace App\System\Classes\Facades;

class CSRF
{
    public function generateCsrfToken($key)
    {
        $key = 'csrf_tokens/' . $key;
        $tokens = $this->_session->get($key, []);
        if(count($tokens) >= 10) {
            array_shift($tokens);
        }

        //FIXME:　トークンの暗号化の仕方(しっかりとした乱数生成器を用いる)
        $token = sha1($key. session_id() . microtime());
        $tokens[] = $token;

        $this->_session->set($key, $tokens);

        return $token;
    }

    //tokenをチェックして、一致したらその使用されたトークンを削除してそれ以外を戻してあげる
    public function checkCsrfToken($key)
    {
        //フォームから送られてきたトークンの値を取得
        $token = $this->_request->getPost('_token');

        $key = 'csrf_tokens/' . $key;
        $tokens = $this->_session->get($key, []);

        if (($pos = array_search($token, $tokens, true)) !== false) {
            unset($tokens[$pos]);
            $this->_session->set($key, $tokens);

            return true;
        }
        return false;
    }
}