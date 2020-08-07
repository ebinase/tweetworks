<?php

namespace Database\seeds;

use App\Model\Follow;

class FollowsTableSeeder
{
    public static function seed()
    {
        $follow = new Follow();

//        for ($i = 1; $i <= 100; $i++) {
//
//            $follow->smartInsert([
//                'following_id' => random_int(1, 100),
//                'followed_id' => random_int(1, 100)
//            ]);
//        }
//TODO:following_id,Followed_id はuserの数以下(<=user_id)？？
        for($i = 1; $i <= 20; $i++){
            for ($j = 1; $j <= 100; $j++) {

                $follow->smartInsert([
                    'following_id' => $j,
                    'followed_id' => $j,

                ]);
            }
        }


    }
}