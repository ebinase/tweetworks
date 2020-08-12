<?php

namespace Database\seeds;

class Seeder
{
    public function run()
    {
//        スコープ定義演算子FavoritesTableSeederのseedメソッドにアクセス
        FavoritesTableSeeder::seed();
        FollowsTableSeeder::seed();
        TweetsTableSeeder::seed();
//        RepliesTableSeeder::seed();
        UsersTableSeeder::seed();
    }

}
