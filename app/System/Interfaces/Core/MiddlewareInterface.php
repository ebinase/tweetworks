<?php

namespace App\System\Interfaces\Core;

use App\System\Interfaces\RequestInterface;
use App\System\Interfaces\ResponseInterface;

interface MiddlewareInterface
{
    public function process(RequestInterface $request, RequestHandlerInterface $next): ResponseInterface;
}