<?php
namespace App\System\Interfaces\Core;

use App\System\Interfaces\RequestInterface;
use App\System\Interfaces\ResponseInterface;

interface ErrorHandlerInterface
{
    public function handle(
        RequestInterface $request, \Exception $e
    ):ResponseInterface;
}