<?php

namespace App\Middleware;

use App\System\Classes\Facades\CSRF;
use App\System\Classes\Facades\Messenger\Info;
use App\System\Classes\Facades\Route;
use App\System\Classes\Services\Env;
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
        if(! CSRF::check($key)) {
            Info::set('csrf', '貴様！CSRF攻撃に利用されてるぞ！!');

            $back_to = '/home';
            return Route::redirect($back_to);
        }

//        if (Env::get('APP_DEBUG') == 'true') {
//            print 'CSRFチェック通過▶';
//        }
        return $next->handle($request);
    }
}