<?php

namespace App\System;

use App\System\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{

    protected $_content;
    protected $_status_code = 200;
    protected $_status_text ='OK';
    protected $_http_headers = array();



    public function setContent($content)
    {
        $this->_content = $content;
    }

    public function setStatusCode(string $status_code, string $status_text='')
    {
        $this->_status_code = $status_code;
        $this->_status_text = $status_text;
    }

    public function setHttpHeader(string $name, string $value)
    {
        $this->_http_headers[$name] = $value;
    }

//    FIXME :void
    public function send(): void
    {
        header('HTTP/1.1 ' . $this->_status_code . ' ' . $this->_status_text);

        foreach ($this->_http_headers as $name => $value){
            header($name . ':' . $value);
        }

        echo $this->_content;
    }
}