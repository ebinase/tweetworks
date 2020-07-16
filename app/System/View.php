<?php

namespace App\System;

class View
{
    protected $base_dir;
    protected $defaults;
    protected $layout_variables = [];

    public function __construct($base_dir, $defaults = [])
    {
        $this->base_dir = $base_dir;
        $this->defaults = $defaults;
    }

    public function setLayoutVar($name, $value)
    {
        $this->layout_variables[$name] = $value;
    }

    public function render($_path, $_variables =[], $_layout_path = false)
    {
        $_file = $this->base_dir . '/' . $_path . '.php';

        //変数展開
        extract(array_merge($this->defaults, $_variables));

        ob_start();
        ob_implicit_flush(0);

        require_once $_file;

        $content = ob_get_clean();

        // レイアウトファイルが有るなら更に読み込む
        /* その場合のレイアウトファイルのイメージは
        <html>
            <head>いろいろ記述</head>
            <body>
                <header>共通のヘッダー</header>
                <div><?= $_content ?></div>
                <footer>共通のフッター</footer>
            </body>
        </html>
        先にrender()でアクションの結果をもとに$_contentの内容を作ってしまってから
        それをレイアウトに組み込む作業をこの下部のrender()で行う
        */
        if ($_layout_path) {
            $content = $this->render(
                $_layout_path,
                array_merge($this->layout_variables, ['_content' => $content])
            );
        }

        return $content;
    }

    public function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}