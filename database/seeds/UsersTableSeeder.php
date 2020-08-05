<?php

namespace Database\seeds;

use App\Model\User;

class UsersTableSeeder
{
    public static function seed()
    {
        $user = new User();

        for ($i = 1; $i <= 20; $i++) {

            $user->smartInsert([
                'id' => $i,
                'name' => 'name'. $i,
                'email' => 'name'. $i . '@example.com',
                'unique_name' => 'unique_name'. $i,
                'password' => password_hash('password', PASSWORD_DEFAULT),
            ]);
        }
    }
}
