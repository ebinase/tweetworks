<?php

namespace Database\seeds;


class TweetsTableSeeder extends Seeder
{
    public static function getSeederQuery()
    {
        for ($i = 1; $i <= 100; $i++){
            $now =\Carbon\Carbon::now();
            $tweets = [
                'id' => $i,
                'user_id' => random_int(1, 10000000000),
                'text' => 'hogehogetweet'.$i,
                'created_at' => $now
            ];
        }
        return $tweets;
    }
}