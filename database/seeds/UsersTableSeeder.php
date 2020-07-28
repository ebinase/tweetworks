<?php

namespace Database\seeds;


class UsersTableSeeder extends Seeder
{
    public static function getSeederQuery()
    {
        for ($i = 1; $i <= 100; $i++){
            $now =\Carbon\Carbon::now();
            $users = [
                'id' => $i,
                'name' => 'name'. $i,
                'email' => 'name'. $i . '@example.com',
                'unique_name' => 'unique_name'. $i,
                'password' => 'password' .$i,
                'token' => 'token' .$i,
                'created_at' => $now,
                'updated_at' => $now

            ];
        }
        return $users;
    }
}