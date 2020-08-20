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
        $sql = <<< EOF
SELECT tweets.id, tweets.user_id, tweets.text, tweets.created_at, users.name, users.unique_name
FROM tweets
INNER JOIN users
    ON tweets.user_id = users.id
EOF;

        return $this->fetchAll($sql);
    }

    public function getDetailTweet($tweet_id)
    {
        $sql = <<< EOF
SELECT tweets.id, tweets.user_id, tweets.text, tweets.created_at, users.name, users.unique_name
FROM tweets
INNER JOIN users
    ON tweets.user_id = users.id
WHERE tweets.id = :tweet_id ;
EOF;

        return $this->fetch($sql, [
            ':tweet_id' => $tweet_id
        ]);

    }

    public function getUserTweet($user_id)
    {
        $sql = 'SELECT * FROM tweets where user_id = :user_id ORDER BY created_at DESC;';
        return $this->fetchAll($sql, [
            ':user_id' => $user_id
        ]);
    }
    public function getTweetWithUser() {

    }

    public function getReplies($tweet_id)
    {
        $sql = 'SELECT * FROM tweets where reply_to_id = :tweet_id ;';

        return $this->fetchAll($sql, [
            ':tweet_id' => $tweet_id,
        ]);
    }
}