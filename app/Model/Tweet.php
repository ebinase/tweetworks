<?php

namespace App\Model;

use App\System\Model;

class Tweet extends Model
{
    //==============================================================================
    //コンストラクタ
    //==============================================================================
    protected function _setTableName()
    {
        $this->_tableName = 'tweets';
    }

    //==============================================================================
    //アクションごとのデータ操作メソッド
    //==============================================================================
    public function getAllTweet()
    {
        $sql = 'SELECT * FROM tweets';
        return $this->fetchAll($sql);
    }

    public function getDetailTweet($params)
    {
        $id = $params['tweet_id'];

        $sql = 'SELECT * FROM tweets where id = :tweet_id ;';

        return $this->fetch($sql,[
            ':tweet_id' => $id
        ]);

    }

}