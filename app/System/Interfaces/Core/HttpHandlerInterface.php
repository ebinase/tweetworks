<?php

namespace App\System\Interfaces\Core;

use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

interface HttpHandlerInterface
{
    // リクエストからレスポンスを作成する処理を実行
    function handle(RequestInterface $request): ResponseInterface;
}