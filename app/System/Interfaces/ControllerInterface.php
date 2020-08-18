<?php

namespace App\System\Interfaces;

use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

interface ControllerInterface
{
    function run(string $action_name, RequestInterface $request): ResponseInterface;
}