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

        for($i = 1; $i <= 20; $i++){
            for ($j = 1; $j <= 100; $j++) {

                $reply->smartInsert([
                    'tweet_id' => $i,
                    'reply_to_id' => $j,
                ]);
            }
        }

    }
}