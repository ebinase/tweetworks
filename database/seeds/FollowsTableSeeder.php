<?php

namespace Database\seeds;

use App\Model\Follow;

class FollowsTableSeeder
{
    public static function seed()
    {
        $follow = new Follow();

        for ($i = 1; $i <= 100; $i++) {

            $follow->smartInsert([
                // TODO: userテーブルシーダーで作成するuser_idが1~100までしか無いのでその範囲内で設定してください
                'following_id' => random_int(1, 10000000000),
                'followed_id' => random_int(1, 10000000000)
            ]);
        }

    }
}