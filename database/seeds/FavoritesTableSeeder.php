<?php

namespace Database\seeds;

 use App\Model\Favorite;

 class FavoritesTableSeeder
{

    public static function seed()
    {
        $favorite = new Favorite();

        for ($i = 1; $i <= 100; $i++) {

            $favorite->smartInsert([
                'user_id' => random_int(1, 100),
                'tweet_id' => $i
            ]);
        }



    }

}
