<?php

namespace App\System\Classes\Facades;

use App\System\Classes\Services\Service;
use App\System\Classes\View;

class Paginate
{
    public static function prepareParams($itemsPerPage, $range, $allItemsNum, $url = null)
    {
        $request = Service::call('request');

        $page = $request->getGet('page', 1);
        $last_page = ceil($allItemsNum / $itemsPerPage);

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

        $paginate['range'] = $range;
        $paginate['page'] = $page;
        $paginate['last_page'] = $last_page;
        //データベースのLIMIT句での:startと:offsetの値
        $paginate['db_start'] = (int) (($page - 1) * $itemsPerPage);
        $paginate['items_per_page'] = (int) $itemsPerPage;

        //標準ではクエリ文字込みの現在のページのurlを表示
        if (is_null($url)) {
            $url = $request->getRequestUri();
        }
        //TODO:ここから下のURLの処理が強引すぎるから修正したい
        $query_pos = strpos($url, '?');
        $page_value = $request->getGet('page');

        if ($query_pos === false) {
            //クエリ文字がなければシンプルに追記
            $url .= '?page=';
        } elseif (isset($page_value)) {
            //すでにpageのクエリ文字が存在した場合は削除
            $page_query ='page=' . $page_value;
            $url = str_replace($page_query, '', $url);
            //クエリ文字にpageを追加
            $url .= '&page=';
        }else {
            //page以外のクエリ文字があった場合、シンプルにpageを追加
            $url .= '&page=';
        }
        //&が重複した場合などの対処
        //(リクエストが?page=1だった場合、pageが消されて&pageが追記されるため、?&page=1となってしまう)
        $url = str_replace('&&', '&', $url);
        $url = str_replace('?&', '?', $url);

        $paginate['url'] = $url;

        return $paginate;
    }


    /**
     * ページネーションの表示に必要な準備をしてビューを呼び出すメソッド。
     *
     * あくまでもclassなどの準備だけで、実際に表示するのはテンプレートの役割。
     * urlはリクエストされたページのものがビュー側で自動で補完される。
     * ページ番号の管理はクエリ文字(~?page=1)で行う
     *
     * 完成形イメージ
     * < 1 .. 5 6 |7| 8 9 .. 50 >
     * →→ $page = 7, $last_page = 50,
     * @param $paginate
     * $page         int     現在のページ数
     * $last_page    int     一番最後のページの番号
     * $range        int     表示するリンクの数。左右対称とするためできる限り奇数で。
     *
     * @return string ビューのデータ
     */
    public static function renderPageList($paginate)
    {
        $page = $paginate['page'];
        $last_page = $paginate['last_page'];
        $range = $paginate['range'];






        //前、後ボタンのリンク先を設定==========================================================
        // イメージの違いでprev&nextとback&forthで使い分けしてます・・・ちょっとめんどくさいです・・・
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

        $view = new View(App::viewDir());

        return $view->render('components/pagination-links', [
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
            //ページ管理用クエリ文字を含む遷移先のurl
            'url' => $paginate['url'],
        ]);

    }
}