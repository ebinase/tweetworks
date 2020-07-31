<?php

namespace Database\seeds;

use App\Model\User;

class UsersTableSeeder
{
    public static function seed()
    {
        $user = new User();

        for ($i = 1; $i <= 100; $i++) {

            $user->smartInsert([
                'id' => $i,
                'name' => 'name'. $i,
                'email' => 'name'. $i . '@example.com',
                'unique_name' => 'unique_name'. $i,
                // FIXME: パスワードは全て'password'で大丈夫です。
                'password' => 'password' .$i,
                // FIXME: 名前がremenber_tokenに変更になりました。
                // FIXME: また、remenber_tokenは基本的にnullのママでいいので省略してください
                'token' => 'token' .$i,
            ]);
        }
    }
}
