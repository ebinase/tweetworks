<?php

namespace App\System\Classes\Facades;

use App\System\Classes\Services\Service;

class CSRF
{
    public static function generateCsrfToken($key)
    {
        $session = Service::call('session');
        $key = 'csrf_tokens/' . $key;
        $tokens = $session->get($key, []);
        if(count($tokens) >= 10) {
            array_shift($tokens);
        }

        //FIXME:　トークンの暗号化の仕方(しっかりとした乱数生成器を用いる)
        $token = sha1($key. session_id() . microtime());
        $tokens[] = $token;

        $session->set($key, $tokens);

        return $token;
    }

    //tokenをチェックして、一致したらその使用されたトークンを削除してそれ以外を戻してあげる
    public static function checkCsrfToken($key)
    {
        $request = Service::call('request');
        $session = Service::call('session');

        //フォームから送られてきたトークンの値を取得
        $token = $request->getPost('_token');

        $key = 'csrf_tokens/' . $key;
        $tokens = $session->get($key, []);

        if (($pos = array_search($token, $tokens, true)) !== false) {
            unset($tokens[$pos]);
            $session->set($key, $tokens);

            return true;
        }
        return false;
    }
}