<?php

namespace Database\seeds;


class FollowsTableSeeder extends Seeder
{
    public static function getSeederQuery()
    {
        for ($i = 1; $i <= 100; $i++) {
            $now = \Carbon\Carbon::now();
            $follows = [
                'following_id' => random_int(1, 10000000000),
                'followed_id' => random_int(1, 10000000000),
                'created_at' => $now
            ];
        }
        return $follows;


    }
}