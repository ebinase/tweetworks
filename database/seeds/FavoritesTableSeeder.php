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

        for($i = 1; $i <= 20; $i++){
            for ($j = 1; $j <= 100; $j++) {

                $favorite->smartInsert([
                    'tweet_id' => $j,
                    'user_id' => $i,
                ]);
            }
        }



    }

}
