<?php

namespace Database\seeds;

use App\Model\Reply;

class RepliesTableSeeder
{
    public static function seed()
    {
        $reply = new Reply();

        for ($i = 1; $i <= 100; $i++) {

            $reply->smartInsert([
                // TODO: tweetテーブルシーダーで作成するtweet_idが1~100までしか無いのでその範囲内で設定してください
                'tweet_id' => random_int(1, 10000000000),
                'reply_to_id' => random_int(1, 10000000000)
            ]);
        }
    }
}