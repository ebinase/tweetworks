<?php

namespace Database\seeds;

use App\Model\Reply;
use App\Model\Tweet;

class TweetsTableSeeder
{

    public static function seed()
    {
        $tweet = new Tweet();
        $reply = new Reply();
        $date = new \DateTime();
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

        $user_num = 20;

        //ユーザー一人あたり20ツイート
        //そのうち
        for($user_i = 1; $user_i <= $user_num; $user_i++){
            for ($tweet_j = 1; $tweet_j <= 20; $tweet_j++) {
                //各ユーザーは2020-01-01から1日1ツイート
                //user_idと同じ時間にツイート(user_id=1なら01:01:01)
                $date->setDate(2020, 1, $tweet_j)
                    ->setTime($user_i, $user_i, $user_i);

                $tweet->smartInsert([
                    'user_id' => $user_i,
                    'text' => 'こんにちは' . $tweet_j,
                    'created_at' => $date->format('Y-m-d H:i:s'),
                ]);

                //todo: リプライの表現
            }
        }
    }
}