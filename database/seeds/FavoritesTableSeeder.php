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
                // TODO: userテーブルシーダーで作成するuser_idが1~100までしか無いのでその範囲内で設定してください
                'user_id' => random_int(1, 10000000000),
                'tweet_id' => $i
            ]);
        }



    }

}
