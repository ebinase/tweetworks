<?php

namespace App\System;

use App\System\Interfaces\RequestInterface;

class Request implements RequestInterface{
    public function isPost()
    {
        // TODO: Implement isPost() method.
    }

    public function getGet()
    {
        // TODO: Implement getGet() method.
    }
    public function getPost()
    {
        // TODO: Implement getPost() method.
    }

    public function getHost()
    {
        // TODO: Implement getHost() method.
    }
    public function isSsl(): bool
    {
        // TODO: Implement isSsl() method.
    }

    public function getRequestUri()
    {
        // TODO: Implement getRequestUri() method.
    }

    function getPathInfo()
    {
        // TODO: Implement getPathInfo() method.
    }

    function getBaseUrl()
    {
        // TODO: Implement getBaseUrl() method.
    }
}