<?php

namespace App\System\Interfaces\Core;

use App\System\Interfaces\HTTP\RequestInterface;

interface KernelInterface
{
    public function __construct(RequestInterface $request);

    public function handle();
}