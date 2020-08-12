<?php

namespace Database\seeds;

use App\Model\Tweet;

class TweetsTableSeeder
{

    public static function seed()
    {
        $tweet = new Tweet();
        $date = new \DateTime();
        $date->setDate(2020, 1, 1)
            ->setTime(0, 0, 0);

        //ユーザーの人数
        $user_num = 20;

        //ユーザー一人あたりリプライ以外で$tweet_num回ツイート
        $tweet_num_by_eachuser = 10;

        //各ツイートへのリプライの数
        $reply_num = 2;
        //上記のリプライのうち、ツイートした本人がさらに返信をするリプライの数
        $re_reply_num = 1;
        /*
         * 例)上から順に1,2,1だと
         * ツイート
         * ↑リプ１(返信が来る)
         * 　↑リプへのリプ１
         * ↑リプ２(無視される)
         * */

        //リプライを含めた総ツイート数は
        //{ (1+ $reply_num + $re_reply_num)*$usr_num }* $tweet_num_by_eachuser

        //累計ツイートidカウント用変数
        $tweet_id = 0;
        //ループ回数カウンタ
        $roop = 0;
        while ($roop <=$tweet_num_by_eachuser) {
            $roop++;
            for ($u_i = 1; $u_i <= $user_num; $u_i++) {
                //ツイート
                $tweet->smartInsert([
                    'user_id' => $u_i,
                    'text' => "1+1は？ (id: {$u_i})",
                    'created_at' => $date->modify('+10 minutes')->format('Y-m-d H:i:s'),
                ]);
                $tweet_id++;
                //リプライ先のtweet_id保管用変数
                $main_id = $tweet_id;

                for ($r_j = 1; $r_j <= $reply_num; $r_j++) {
                    //ツイートした人のid+1, +2,...のidのユーザーがリプライ
                    $reply_user = $u_i + $r_j;
                    //返信するユーザーのidがユーザー数を超えたらid=1,2...のユーザーが返信
                    if ($reply_user > $user_num) {
                        $reply_user = $reply_user - $user_num;
                    }
                    //リプライを保存
                    $tweet->smartInsert([
                        'user_id' => $reply_user,
                        'text' => "みそスープ (id: {$reply_user})",
                        'reply_to_id' => $main_id,
                        'created_at' => $date->modify('+10 minutes')->format('Y-m-d H:i:s'),
                    ]);
                    $tweet_id++;

                    if ($r_j <= $re_reply_num) {
                        //10分後にツイートした本人がリプに返信
                        $tweet->smartInsert([
                            'user_id' => $u_i,
                            'text' => 'ありがとう！',
                            'reply_to_id' => $tweet_id,
                            'created_at' => $date->modify('+10 minutes')->format('Y-m-d H:i:s'),
                        ]);
                        $tweet_id++;
                    }
                }
            }
        }
    }
}