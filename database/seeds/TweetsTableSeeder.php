<?php

namespace Database\seeds;

use App\Model\Tweet;

class TweetsTableSeeder
{

    public static function seed()
    {
        $tweet = new Tweet();

//        for ($i = 1; $i <= 100; $i++) {
//
//            $tweet->smartInsert([
//                'id' => $i,
//                'user_id' => random_int(1, 20),
//                'text' => 'こんにちは' .$i,
//            ]);
//        }

        for($i = 1; $i <= 20; $i++){
            for ($j = 1; $j <= 100; $j++) {

                $tweet->smartInsert([
                    'id' => $j,
                    'user_id' => $i,
                    'text' => 'こんにちは' .$j,
                ]);
            }
        }
    }
}