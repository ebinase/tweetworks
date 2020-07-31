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
                'user_id' => random_int(1, 10000000000),
                'text' => 'こんにちは' .$i,
            ]);
        }
    }
}