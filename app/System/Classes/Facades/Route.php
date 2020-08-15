<?php

namespace App\System\Classes\Facades;

use App\System\Classes\Core\Application;

class Route
{
    public function __construct()
    {

    }

    public function redirect($to)
    {
//ベースURL以降を指定された場合(例：/user/hogehoge)
        if (! preg_match('#https?://#', $url)) {
            $url = $this->url($url);
        }

        $this->_response->setStatusCode(302, 'Found');
        $this->_response->setHttpHeader('Location', $url);

        $this->send();
        //FIXME: ログなどを残したい場合はエラーハンドラなどを搭載する
        exit();
    }

    public function back()
    {

    }

    public function url($uri)
    {
        $protocol = $this->_request->isSsl() ? 'https://' : 'http://';
        $host = $this->_request->getHost();
        $base_url = $this->_request->getBaseUrl();

        return $protocol . $host . $base_url . $uri;
    }

    public function route($name, $wildcard = [])
    {

    }

    public function previous() {

    }
}