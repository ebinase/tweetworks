<?php

namespace Database\seeds;

 use App\Model\Favorite;

 class FavoritesTableSeeder
{

    public static function seed()
    {
        $favorite = new Favorite();

//        for ($i = 1; $i <= 100; $i++) {
//
//            $favorite->smartInsert([
//                'user_id' => random_int(1, 100),
//                'tweet_id' => $i
//            ]);
//        }

        // TODO: いまはtweet_idは1から2000まであるからその中からランダムで30個くらい選ぼう
        // (user 20人　✕　ひとり100ツイート)

//        TODO:Tweetの方で20*20=400ツイートに変更した
        for($i = 1; $i <= 20; $i++){

                $favorite->smartInsert([
                    'tweet_id' => random_int(1, 400),
                    'user_id' => $i,
                ]);
            }



    }

}
