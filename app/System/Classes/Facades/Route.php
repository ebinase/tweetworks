<?php

namespace App\System\Classes\Facades;

use App\System\Classes\Services\Service;
use App\System\Interfaces\HTTP\ResponseInterface;
use App\System\Classes\HTTP\Response;

class Route
{
    public function __construct()
    {

    }

    //レスポンスクラスを作成してミドルウェアとハンドラのチェーンを途中で折り返しさせる。
    public static function redirect($url) :ResponseInterface
    {
        //ベースURL以降を指定された場合(例：/user/hogehoge)
        if (! preg_match('#https?://#', $url)) {
            $url = self::url($url);
        }

        //レスポンスはDIコンテナを使わずに作成し、ミドルウェアなどを経由しながらKernelに返す。
        $response = new Response;
        $response->setStatusCode(302, 'Found');
        $response->setHttpHeader('Location', $url);
        $response->setContent('');  //不要だが明示的に記述

        return $response;
    }

    public function back()
    {

    }

    public static function url($uri)
    {
        $request = Service::call('request');
        $protocol = $request->isSsl() ? 'https://' : 'http://';
        $host = $request->getHost();
        $base_url = $request->getBaseUrl();

        return $protocol . $host . $base_url . $uri;
    }

    public function route($name, $wildcard = [])
    {

    }

    public function previous() {

    }
}