<?php

namespace Database\seeds;

class Seeder
{
    public function run()
    {
//        スコープ定義演算子FavoritesTableSeederのseedメソッドにアクセス
        FavoritesTableSeeder::seed();
        FollowsTableSeeder::seed();
        RepliesTableSeeder::seed();
        TweetsTableSeeder::seed();
        UsersTableSeeder::seed();
    }

}
