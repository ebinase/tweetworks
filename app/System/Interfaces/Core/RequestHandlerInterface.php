<?php

namespace App\System\Interfaces\Core;

use App\System\Interfaces\RequestInterface;
use App\System\Interfaces\ResponseInterface;

interface RequestHandlerInterface
{
    // リクエストからレスポンスを作成する処理を実行
    function handle(RequestInterface $request): ResponseInterface;
}