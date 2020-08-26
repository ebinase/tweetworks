<?php

namespace App\Middleware;

use App\System\Classes\Facades\Auth;
use App\System\Classes\Facades\Route;
use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\Core\MiddlewareInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

class Guest implements MiddlewareInterface
{

    public function process(RequestInterface $request, HttpHandlerInterface $next): ResponseInterface
    {
        //ログイン済みだったらホームにリダイレクト
        if (Auth::check() == true) {
            return redirect('/home');
        }

//        print 'Guest通過▶';
        return $next->handle($request);
    }
}