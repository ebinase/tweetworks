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
        //↑せやね、ただし自分自身はフォローしないから
        // following_id <= user_id
        // followed_id < user_id

//      TODO:↑  following_id　も < user_idだと思ったので、とりあえず$i <= 19;にしてみました
        //蛯名：↑「フォローを行う人」はユーザー全員だからfollowing_id <= user_id

        for($i = 1; $i <= 20; $i++){
            //ユーザーひとりがフォローする人数は0人から19人で完全にランダム
            $num = random_int(0, 19);
            for ($j = 1; $j <= $num; $j++) {
                //ユーザーidが重複してなかったら登録
                if ($i != $j) {
                    $follow->smartInsert([
                        'following_id' =>$i,
                        'followed_id' => $j,
                    ]);
                }
            }
        }

    }
}