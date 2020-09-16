<?php

namespace App\System\Classes;

use App\System\Interfaces\ViewInterface;

class View implements ViewInterface
{
    /**
     * @var string ビューファイルが置いてあるディレクトリのルート
     */
    protected $_base_dir;

    /**
     * 「全てのビュー」で共通で取り扱いたい変数を保存
     *
     * 例：CSRFトークンなど
     *
     * このインスタンス内でずっと使われるため、
     * コンポーネントなどを用いる場合に名前の競合に注意。
     *
     * @var array
     */
    protected $_defaults = [];

    /**
     * ページタイトルなどレイアウトの変数をテンプレートから設定したい場合に使う
     *
     * @var array
     */
    protected $_layout_variables = [];



    public function __construct($base_dir, $defaults = [])
    {
        $this->_base_dir = $base_dir;
        $this->_defaults = array_merge($this->_defaults, $this->_escapeVariables($defaults));
    }

    /**
     * エスケープ処理した上でをインスタンス内に登録
     *
     * @param array $variables ビューで使う変数を格納した配列
     */
    public function registerDefaults($variables)
    {
        $this->_defaults = array_merge($this->_defaults, $this->_escapeVariables($variables));
    }

    /**
     * 主にテンプレートの中でレイアウト内のタイトルを設定するために使う。
     *
     * @param $name
     * @param $value
     */
    public function setLayoutVar($name, $value)
    {
        $value = $this->_escapeVariables($value);
        $this->_layout_variables[$name] = $value;
    }

    //変数展開を行うため、変数名の重複がないように引数にはアンダースコアをつける
    public function render($_path, $_variables =[], $_layout_path = false): string
    {
        $_file = $this->_base_dir . '/' . $_path . '.php';


        //変数展開
        extract(array_merge($this->_defaults, $_variables));

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
                array_merge($this->_layout_variables, $_variables, ['_content' => $content])
            );
        }

        return $content;
    }

    /**
     * 配列(多次元やネストしたものを含む)のすべての要素をエスケープ
     *
     * renderメソッド内で使うと_contentの値もエスケープされるので注意！！
     * ヘルパとしても実装してます。
     *
     * @param array | string $variables
     * @return mixed
     */
    private function _escapeVariables($variables)
    {
        if (is_array($variables)) {
            foreach ($variables as $key => $value) {
                if (is_array($value)) {
                    $variables[$key] = $this->_escapeVariables($value);
                }else {
                    $variables[$key] = $this->escape($value);
                }
            }
        } else {
            $variables = $this->escape($variables);
        }

        return $variables;
    }

    public function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

}