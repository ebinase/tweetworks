<?php

namespace App\System;

use App\System\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    protected $_routes;

    //==============================================================================
    //コンストラクタ
    //==============================================================================
    public function __construct(array $difinitions)
    {
        $this->_routes = $this->compileRoutes($difinitions);
    }


    /**
     * @param $difinitions
     * @return array
     */
    public function compileRoutes($difinitions)
    {
        $routes = array();

        foreach ($difinitions as $url => $params){
//            URLの区切り文字はスラッシュ→explode()関数でスラッシュごとに分割
            $tokens = explode('/', ltrim($url,'/'));
            foreach($tokens as $i =>$token){
//                strposは、該当する文字列が見つからなかった場合は、falseを返す
                if (0=== strpos($token,':')){
                    $name = substr($token,1);
//                    分割した値の中にコロンで始まる文字列があった場合、ここで正規表現の形に変換
                    $token = '(?<' . $name . '>[^/]+)';
                }
                $tokens[$i] = $token;
            }
//            分割したURLをサイドスラッシュで繋げ、変換すみの値として$routes変数に格納
            $pattern = '/' . implode('/', $tokens);
            $routes[$pattern] = $params;
        }

        return $routes;

    }
    //==============================================================================
    // Appllicationから呼び出すresolveメソッド
    //==============================================================================

    /**
     * requestクラスから$path_infoを受け取ってルーティング定義配列とマッチング
     *
     * @param string $path_info
     * @return mixed $params アクション名などの配列またはnull
     */
    public function resolve(string $path_info)
    {
//        PATH_INFOの先頭がスラッシュ出ない場合、先頭にスラッシュを付与
        if ('/' !== substr($path_info,0,1)){
            $path_info  = '/' . $path_info;
        }

        foreach ($this->_routes as $pattern=> $params) {
//          変換済みのルーティング配列は$routesプロパティに格納されている→正規表現を用いてマッチング
//          #→正規表現のスラッシュ(/)と同じ役割
//          (?<name>) → 名前付きサブパターン(以下のurlの少しスクロールした所の「変更履歴」参照)
//          https://www.php.net/manual/ja/function.preg-match.php
            if (preg_match('#^' . $pattern . '$#', $path_info, $matches)){
//              マッチした場合array_merge関数でマージ→$params関数にルーティングパラメータとして格納
                $params = array_merge($params, $matches);

                return  $params;
            }
        }

        return false;
    }
}