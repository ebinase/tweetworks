<?php

namespace Database\seeds;

 use App\Model\Favorite;

 class FavoritesTableSeeder
{

    public static function seed()
    {
        $favorite = new Favorite();

        //一人あたりのお気に入りの数
        $favorite_num = 40;

        for($user_i = 1; $user_i <= 20; $user_i++) {
            for ($tweet_j = 1; $tweet_j <= $favorite_num; $tweet_j++) {
                $favorite->smartInsert([
                    'user_id' => $user_i,
                    // 10刻みでその間のランダムな数字を生成(1~10, 11~20, ・・・)
                    'tweet_id' => ($tweet_j - 1) * 10 + random_int(1,10),
                ]);
            }
        }



    }

}
