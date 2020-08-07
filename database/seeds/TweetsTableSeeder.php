<?php

namespace Database\seeds;

use App\Model\Tweet;

class TweetsTableSeeder
{

    public static function seed()
    {
        $tweet = new Tweet();

//        for ($i = 1; $i <= 100; $i++) {
//
//            $tweet->smartInsert([
//                'id' => $i,
//                'user_id' => random_int(1, 20),
//                'text' => 'こんにちは' .$i,
//            ]);
//        }

        // TODO:ユーザーひとりあたり20ツイートくらいでいいんじゃないかなー
        // 現状だとツイートが2000ツイート登録されるからテスト用としてはデータが重いかも

        // TODO: 'created_at'も追加
        // 投稿日時をバラバラにして登録したほうがいいと思います(タイムラインに表示するために)
        // 日時の登録の仕方は調べてみよう

//        TODO:$iの方のfor文これだと回ってない(テーブル中身確認）

        for($i = 1; $i <= 20; $i++){
            for ($j = 1; $j <= 20; $j++) {

                $tweet->smartInsert([
                    'id' => $j,
                    'user_id' => $i,
                    'text' => 'こんにちは' .$j,
                    //TODO:調べたんですが、よくわからず、、放置してます、、
//                    'created_at' => random_int(1262055681,1262055681),

                ]);
            }
        }
    }
}