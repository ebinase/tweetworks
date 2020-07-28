<?php

namespace Database\seeds;


class RepliesTableSeeder extends Seeder
{
    public static function getSeederQuery()
    {
        for ($i = 1; $i <= 100; $i++) {
            $now = \Carbon\Carbon::now();
            $replies = [
                'tweet_id' => random_int(1, 10000000000),
                'reply_to_id' => random_int(1, 10000000000),
                'created_at' => $now
            ];
        }
        return $replies;

    }
}