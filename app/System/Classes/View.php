<?php

namespace App\System\Classes;

use App\System\Interfaces\ViewInterface;

class View implements ViewInterface
{
    protected $_base_dir;
    protected $_defaults;
    protected $_layout_variables = [];

    public function __construct($base_dir, $defaults = [])
    {
        $this->_base_dir = $base_dir;
        $this->_defaults = $defaults;
    }

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

    //renderメソッド内で使うと_contentの値もエスケープされるので注意！！
    /**
     * 配列(多次元やネストしたものを含む)のすべての要素をエスケープ
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

    /**
     * ページネーションのリンクを作るためのメソッド。
     *
     * あくまでもclassとかの準備だけで、実際に表示するのはテンプレートの役割。
     * urlはリクエストされたページのものがビュー側で自動で補完される。
     * ページ番号の管理はクエリ文字(~?page=1)で行う
     *
     * 完成形イメージ
     * < 1 .. 5 6 |7| 8 9 .. 50 >
     * →→ $page = 7, $last_page = 50,
     * @param $page         int     現在のページ数
     * @param $last_page    int     一番最後のページの番号
     * @param $range        int     表示するリンクの数。左右対称とするためできる限り奇数で。
     */
    public function renderPageList($page, $last_page, $range)
    {
        //バリデーション===========================================
        if ($page < 1) {
            //ページ番号に負の値を設定された場合
            $page = 1;
        }

        if ($page >= $last_page) {
            //ページ番号に最大ページ数以上の値を設定された場合
            $page = $last_page;
        }

        //表示するページ数の設定よりも最大ページ数が少なかったら表示をページ数に合わせる
        if ($last_page < $range) {
            $range = $last_page;
        }



        //前、後ボタンのリンク先を設定==========================================================
        // イメージの違いでprev&nextとback&forthで使い分けしてます・・・ちょっとめんどくさいです・・・
//        $prev_btn['link'] = $url . '?page=' . (string) ($page - 1);
//        $prev_btn['class'] = 'bgn-btn';
//        $next_btn['link'] = $url . '?page=' . (string) ($page + 1);
//        $next_btn['class'] = 'bgn-btn';
        $next_btn = true;
        $prev_btn = true;

        if ($page <= 1) {
            //前のページヘのボタンを無効化
            $prev_btn = false;
        }

        if ($page >= $last_page) {
            //次のページヘのリンクを無効化
            $next_btn = false;
        }

        //メインの各ページへのリンクの設定===========================================================
        // start_page ←  range  →　end_page
        //          1  |2|  3  4  5
        //            $page

        //例：rangeが5なら、前後は2ずつ
        //   < 5 6 |7| 8 9 >
        $back_range = $forth_range = floor($range / 2); //切り捨て

        //表示幅が偶数の場合は左右非対称となり修正が必要
        //例：rangeが4、表示中のページが7の場合
        //   < 6 |7| 8 9 >
        if ($range%2 == 0) {
            $back_range += -1; //前のページ側の表示数を一つ減らす
        }

        $start_page = $page - $back_range;
        $end_page = $page + $forth_range;

        //startまたはendが有効なページ数ではなかった場合の修正
        //120行目あたりでrangeを適切な幅にしているため、どちらかを修正するともう片方も自動的に適切な値になる。
        if ($start_page <= 0) {
            //スタート地点が1より小さくなってしまったら、スタートを1にしてそこから終了地点を割り出す。
            //range= 5 ▶　start)1 |2| 3 4 5(end
            $start_page = 1;
            $end_page = 0 + $range;
        } elseif ($end_page > $last_page) {
            //range= 5 ▶　start)1 2 3 |4| 5(end
            $end_page = $last_page;
            $start_page = $last_page - $range + 1;
        }

        // 「...」←skipの表示の設定==========================================================
        $skip_back = true;
        $skip_forth = true;

        if (($page - $back_range) <= 1 ) {
            $skip_back = false;
        }

        if (($page + $forth_range) >= $last_page) {
            $skip_forth = false;
        }

        return $this->render('components/pagination-links', [
            //メインのリンクの部分
            'start' => $start_page,
            'end' => $end_page,
            'current' => $page,
            //最初と最後へのスキップ部分
            'first' => 1,
            'last' => $last_page,
            'skip_back' => $skip_back,
            'skip_forth' => $skip_forth,
            //前後への移動ボタン
            'next_btn' => $next_btn,
            'prev_btn' => $prev_btn,

        ]);

    }
}