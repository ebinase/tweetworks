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

        //一人あたりのお気に入りの数
        $favorite_num = 40;

//        TODO:Tweetの方で20*20=400ツイートに変更した
        //蛯名：一人のユーザーが同じツイートを複数回いいねはできないので重複が出ないようにした
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
