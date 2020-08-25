<?php

namespace App\System\Classes\HTTP;

use App\System\Interfaces\HTTP\ResponseInterface;

class Response implements ResponseInterface
{

    protected $_content = '';
    protected $_status_code = 200;
    protected $_status_text ='OK';
    protected $_http_headers = array();





    public function setContent($content)
    {
        $this->_content = $content;
    }

    public function getContent()
    {
        return $this->_content;
    }



    public function setStatusCode(string $status_code, string $status_text='')
    {
        $this->_status_code = $status_code;
        $this->_status_text = $status_text;
    }

    public function getStatusCode()
    {
        return $this->_status_code . ' ' . $this->_status_text;
    }


    public function setHttpHeader(string $name, string $value)
    {
        $this->_http_headers[$name] = $value;
    }

    public function getHttpHeaders()
    {
        return $this->_http_headers;
    }
}