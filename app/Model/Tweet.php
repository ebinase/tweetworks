<?php

namespace App\Model;

use App\System\Classes\Model;

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

    public function getDetailTweet($tweet_id)
    {
        $sql = 'SELECT * FROM tweets where id = :tweet_id ;';

        return $this->fetch($sql, [
            ':tweet_id' => $tweet_id
        ]);

    }

    public function getReplies($tweet_id)
    {
        $sql = 'SELECT * FROM tweets where reply_to_id = :tweet_id ;';

        return $this->fetchAll($sql, [
            ':tweet_id' => $tweet_id,
        ]);
    }
}