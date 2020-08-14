<?php

namespace Database\seeds;

use App\Model\Follow;

class FollowsTableSeeder
{
    public static function seed()
    {
        $follow = new Follow();

        for($i = 1; $i <= 20; $i++){
            //ユーザーひとりがフォローする人数は0人から19人で完全にランダム
            $num = random_int(0, 19);
            for ($j = 1; $j <= $num; $j++) {
                //ユーザーidが重複してなかったら登録
                if ($i != $j) {
                    $follow->smartInsert([
                        'user_id' =>$i,
                        'user_followed_id' => $j,
                    ]);
                }
            }
        }

    }
}