<?php

namespace Database\seeds;

class FavoritesTableSeeder extends Seeder
{
    public static function getSeederQuery()
    {
        for ($i = 1; $i <= 100; $i++){
            $now =\Carbon\Carbon::now();
            $favorites = [
                'user_id' => random_int(1, 10000000000),
                'tweet_id' => $i,
                'created_at' => $now
            ];
        }
    return $favorites;

    }
}
