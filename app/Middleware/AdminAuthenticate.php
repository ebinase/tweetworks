<?php

namespace App\Middleware;

use App\System\Classes\Facades\Admin;
use App\System\Classes\Facades\Auth;
use App\System\Classes\Facades\Messenger\Info;
use App\System\Classes\Facades\Route;
use App\System\Classes\Services\Service;
use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\Core\MiddlewareInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

class AdminAuthenticate implements MiddlewareInterface
{

    public function process(RequestInterface $request, HttpHandlerInterface $next): ResponseInterface
    {
        //ログインしていなかったらログインページにリダイレクト
        if (Admin::check() === false) {
            Info::set('auth', 'ログインが必要です。');
            return Route::redirect('/admin/login');
        }

//        print 'Authenticate通過▶';
        return $next->handle($request);
    }
}