<?php

namespace Database\seeds;

class Seeder extends \App\System\Model
{

    public function _setTableName()
    {

    }

    public function run()
    {
//        FIXME:よくわかってない。HogeTableSeederクラスのgetSeederQueryメソッドの返り値（？）を$sqls　に配列として入れたい。
        $sqls[] =  FavoritesTableSeeder::getSeederQuery();
        $sqls[] =  FollowsTableSeeder::getSeederQuery();
        $sqls[] =  RepliesTableSeeder::getSeederQuery();
        $sqls[] =  TweetsTableSeeder::getSeederQuery();
        $sqls[] =  UsersTableSeeder::getSeederQuery();

//        FIXME:ここの処理は？



    }

}
