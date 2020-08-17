<?php

namespace App\Middleware;

use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\Core\MiddlewareInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

class Guest implements MiddlewareInterface
{

    public function process(RequestInterface $request, HttpHandlerInterface $next): ResponseInterface
    {
        //ログイン済みだったらホームにリダイレクト
        if ($request->session()->isAuthenticated() === true) {
            Route::redirect('/home');
        }

        print '<p>Guest通過</p>';
        return $next->handle($request);
    }
}