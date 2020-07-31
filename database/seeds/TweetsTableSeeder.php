<?php

namespace Database\seeds;

use App\Model\Tweet;

class TweetsTableSeeder
{

    public static function seed()
    {
        $tweet = new Tweet();

        for ($i = 1; $i <= 100; $i++) {

            $tweet->smartInsert([
                'id' => $i,
                // TODO: userテーブルシーダーで作成するuser_idが1~100までしか無いのでその範囲内で設定してください
                'user_id' => random_int(1, 10000000000),
                'text' => 'こんにちは' .$i,
            ]);
        }
    }
}