<?php
namespace App\System\Interfaces\Core;

use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

interface ErrorHandlerInterface
{
    public function __construct(RequestInterface $request, \Exception $e);

    public function handle():ResponseInterface;
}