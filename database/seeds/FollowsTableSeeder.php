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
                'following_id' => random_int(1, 100),
                'followed_id' => random_int(1, 100)
            ]);
        }

    }
}