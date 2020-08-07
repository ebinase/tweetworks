<?php

namespace Database\seeds;

use App\Model\Reply;

class RepliesTableSeeder
{
    public static function seed()
    {
        $reply = new Reply();

//        for ($i = 1; $i <= 100; $i++) {
//
//            $reply->smartInsert([
//                'tweet_id' => random_int(1, 100),
//                'reply_to_id' => random_int(1, 100)
//            ]);
//        }

        // TODO:$iと$jの数値見直し
        // 返信の数は3個くらいでいいと思う

        // TODO:リプライへのリプライも登録してほしい
        // ツイート
        // ↑リプライ１
        //   ↑リプライ2
        // 的な。

//       TODO:↑やってみたくて新しく$k登場させたが、そもそものテーブル構成変える必要があるのではと中断(?)

        for($i = 1; $i <= 20; $i++){
            for ($j = 1; $j <= 3; $j++) {
                for ($k = 1; $k <= 3; $k++) {

                    $reply->smartInsert([
                        'tweet_id' => $i,
                        'reply_to_id' => $j,
                    ]);
                }
            }
        }

    }
}