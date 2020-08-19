<?php

namespace App\Middleware;

use App\System\Classes\Facades\Auth;
use App\System\Classes\Facades\Route;
use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\Core\MiddlewareInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

class Authenticate implements MiddlewareInterface
{

    public function process(RequestInterface $request, HttpHandlerInterface $next): ResponseInterface
    {
        //ログインしていなかったらログインページにリダイレクト
        if (Auth::check() === false) {
            return Route::redirect('/login');
        }

        //ログイン中のユーザーIDがセッションに記録されてなかったら再ログインしてもらう
        if ( is_null(Auth::id()) ) {
            Route::redirect('/login');
        }

        print 'Authenticate通過▶';
        return $next->handle($request);
    }
}