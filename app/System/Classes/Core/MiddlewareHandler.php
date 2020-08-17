<?php

namespace App\System\Classes\Core;

use App\System\Interfaces\Core\HttpHandlerInterface;
use App\System\Interfaces\Core\MiddlewareInterface;
use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

//middlewareとhttpHandler(処理アクション)のインターフェースを変換して同列に扱えるようにするアダプタクラス
class MiddlewareHandler implements HttpHandlerInterface
{
    /**
     * このインスタンスで実行するミドルウェア
     *
     * @var MiddlewareInterface
     */
    private $middleware;

    /**
     * この次に実行したいミドルウェアとハンドラが詰まったパイプライン.
     * ミドルウェア内の$nextの中身
     *
     * @var HttpHandlerInterface Kernelで関数合成されたハンドラとミドルウェア
     */
    private $handler;

    public function __construct(MiddlewareInterface $middleware, HttpHandlerInterface $handler)
    {
        $this->middleware = $middleware;
        $this->handler = $handler;
    }

    /**
     * ミドルウェアを実行するとともに次に実行するパイプライン($this->handler)を渡す。
     *  ミドルウェア内での$next->handleの実体
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    function handle(RequestInterface $request): ResponseInterface
    {
        return $this->middleware->process($request, $this->handler);
    }
}