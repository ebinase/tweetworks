<?php

namespace App\System\Classes\Core;

use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\Core\MiddlewareInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

//middlewareとhttpHandler(処理アクション)のインターフェースを変換して同列に扱えるようにするアダプタクラス
class MiddlewareHandler implements HttpHandlerInterface
{
    private $middleware;
    private $handler;

    public function __construct(MiddlewareInterface $middleware, HttpHandlerInterface $handler)
    {
        $this->middleware = $middleware;
        $this->handler = $handler;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    function handle(RequestInterface $request): ResponseInterface
    {
        return $this->middleware->process($request, $this->handler);
    }
}