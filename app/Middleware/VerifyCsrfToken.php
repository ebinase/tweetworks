<?php

namespace App\Middleware;

use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\Core\MiddlewareInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

class VerifyCsrfToken implements MiddlewareInterface
{
    public function process(RequestInterface $request, HttpHandlerInterface $next): ResponseInterface
    {
        //セッションに格納されたトークンを取り出すためのキーを取得
        //今回はキー名の命名規則が「フォームの送信先のベースurl以降のパス名」なのでgetPathInfo()で自動的に取得する。
        //FIXME: バグ: ワイルドカードを含むURLの場合うまく動作しない可能性(キー名が一致しなくなる)
        //ただ、そもそもcsrfチェックを行うurlにはワイルドカードを含まない可能性が高い？
        $key = $request->getPathInfo();

        //セッションとフォームのCSRFトークンを照合する
        if(! CSRF::checkCsrfToken($key)) {
//            $this->_messenger->setError('csrf', 'エラーが発生しました。はじめからやり直してください。');

            //戻り先を指定(通常はフォーム画面)
            //FIXME: Messengerの利用のほうが良さげ？？
//            $back_to = $application->getRequest()->getGet('back');
            $back_to = '/home';
            Route::redirect($back_to);
        }
        return $next->handle($request);
    }
}