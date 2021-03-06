<?php

namespace App\System\Interfaces\Core;

use App\System\Interfaces\HTTP\RequestInterface;
use App\System\Interfaces\HTTP\ResponseInterface;

interface KernelInterface
{
    public function __construct(RequestInterface $request);

    public function build():HttpHandlerInterface;

    public function handle(RequestInterface $request, HttpHandlerInterface $pipeline):ResponseInterface;
}