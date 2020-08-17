<?php

namespace App\Middleware;

use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\Core\MiddlewareInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

class Authenticate implements MiddlewareInterface
{

    public function process(RequestInterface $request, HttpHandlerInterface $next): ResponseInterface
    {
        //ログインしていなかったらログインページにリダイレクト
        if ($request->session()->isAuthenticated() === false) {
            Route::redirect('/login');
        }

        //ログイン中のユーザーIDがセッションに記録されてなかったら再ログインしてもらう
        if (is_null($request->session()->get('user_id'))) {
            Route::redirect('/login');
        }

        print '<p>Authenticate通過</p>';
        return $next->handle($request);
    }
}