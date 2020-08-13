<?php

namespace App\System;

use App\System\Interfaces\RequestInterface;

class Request implements RequestInterface{

    //==============================================================================
    //getPathInfo(ベースURL以降の文字列を返す)
    //==============================================================================
    public function getPathInfo()
    {
        $base_url = $this->getBaseUrl();
        $request_uri = $this->getRequestUri();

        // クエリ文字(?~~)を含む場合は削除
        $query_position = strpos($request_uri, '?');
        if ($query_position !== false){
            $request_uri = substr($request_uri, 0, $query_position);
        }

        //リクエストURIからベースURLを取り除いたものを返す
        return (string)substr($request_uri,strlen($base_url));
    }

    public function getBaseUrl()
    {
        // SCRIPT_NAMEについては
        //https://kaworu.jpn.org/kaworu/2008-01-31-1.php 参照
        $script_name = $_SERVER['SCRIPT_NAME'];
        $request_uri = $this->getRequestUri();

        if (0 === strpos($request_uri, $script_name)){
            // リクエストにフロントコントローラ(index.php)が含まれていたらそのまま返す。
            return $script_name;
        } elseif (0 === strpos($request_uri, dirname($script_name))){
            // フロントコントローラが含まれていなかったら一番最後のスラッシュを取り除く
            return  rtrim(dirname($script_name), '/');
        }

        return '';
    }

    //==============================================================================
    //その他ラッピングメソッド
    //==============================================================================
    public function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function  getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }
         return false;
    }

    public function getGet($name,$default = null)
    {
        if (isset($_GET[$name])){
            return $_GET[$name];
        }
        return  $default;
    }
    public function getPost($name,$default = null)
    {
        if (isset($_POST[$name])){
            return $_POST[$name];
        }
        return $default;
    }

    public function getHost()
    {
        if (!empty($_SERVER['HTTP_HOST'])){
            return $_SERVER['HTTP_HOST'];
        }
        return  $_SERVER['SERVER_NAME'];
    }

    public function isSsl(): bool
    {
       if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
           return true;
       }
       return false;
    }
}