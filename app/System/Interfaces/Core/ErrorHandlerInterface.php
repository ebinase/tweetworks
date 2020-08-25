<?php
namespace App\System\Interfaces\Core;

use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

interface ErrorHandlerInterface
{
    public function __construct();

    public function handle(RequestInterface $request, \Exception $e):ResponseInterface;
}