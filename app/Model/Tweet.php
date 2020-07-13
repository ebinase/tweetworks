<?php

namespace App\Model;

use App\System\Model;

class Tweet extends Model
{
    //==============================================================================
    //コンストラクタ
    //==============================================================================
    protected function setTableName()
    {
        $this->tableName = 'tweets';
    }

    //==============================================================================
    //アクションごとのデータ取得用メソッド
    //==============================================================================
    public function getAllTweet()
    {
        $sql = 'SELECT * FROM tweets';
        return $this->fetchAll($sql);
    }

}