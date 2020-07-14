<?php

namespace App\System;

use App\System\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{

    protected $content;
    protected $status_code = 200;
    protected $status_text ='OK';
    protected $http_headers = array();



    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function setStatusCode(string $status_code, string $status_text='')
    {
        $this->status_code = $status_code;
        $this->status_text = $status_text;
    }

    public function setHttpHeader(string $name, string $value)
    {
        $this->http_headers[$name] = $value;
    }

//    FIXME :void
    public function send(): void
    {
        header('HTTP/1.1 ' . $this->status_code . ' ' . $this->status_text);

        foreach ($this->http_headers as $name => $value){
            header($name . ':' . $value);
        }

        echo $this->content;
    }
}