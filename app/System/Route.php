<?php

namespace App\System;

//ルーティング定義配列の作成やルーティングパラメータの提供をする
class Route implements Interfaces\RouteInterface
{
    private $_routesArray;
    private $_params; // array または false

    public function getDifinitions()
    {
        return $this->_routesArray;
    }

    public function get($url, $controller, $action, $auth = 0, $name = null)
    {
        $this->_setRoutesArray($url, $controller, $action, 'get', $auth, $name);
    }

    public function post($url, $controller, $action, $auth =0, $name = null)
    {
        $this->_setRoutesArray($url, $controller, $action, 'post', $auth, $name);
    }

    private function _setRoutesArray($url, $controller, $action, $method, $auth, $name) {
        $this->_routesArray[$url] = [
            'controller' => $controller,
            'action' => $action,
            'method' => $method,
            'auth' => $auth,
            'name' => $name,
        ];
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params): void
    {
        $this->_params = $params;
    }


    function mapFullUrls($base_url)
    {
        $urls = [];
        foreach ($this->_routesArray as $key => $value) {
            $urls[$key] = $base_url . $key;
        }
        return $urls;
    }
}