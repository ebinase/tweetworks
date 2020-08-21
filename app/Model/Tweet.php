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
    //Timeline
    //==============================================================================
    public function getAllTweetExceptReply()
    {
        $sql = <<< EOF
SELECT tweets.id, tweets.user_id, tweets.text, tweets.reply_to_id, tweets.created_at, users.name, users.unique_name
FROM tweets
INNER JOIN users
    ON tweets.user_id = users.id
WHERE tweets.reply_to_id IS NULL
ORDER BY tweets.created_at DESC;
EOF;

        return $this->fetchAll($sql);
    }

    public function getTimeline($user_id)
    {
        //フォローテーブルをもとにフォローしてるユーザーの返信以外のツイートをユーザー情報ごと取得
        //FIXME:DISTINCTで無理やり期待する結果にしているため、正しく理解してから修正
        $sql = <<< EOF
SELECT DISTINCT 
    tweets.id, tweets.user_id, tweets.text, tweets.reply_to_id, tweets.created_at,
    users.name, users.unique_name
FROM follows
         INNER JOIN tweets
                    ON follows.user_id_followed = tweets.user_id
                    OR tweets.user_id = 8
         INNER JOIN users
                    ON tweets.user_id = users.id
WHERE follows.user_id = 8
    AND tweets.reply_to_id IS NULL
ORDER BY tweets.created_at DESC;
EOF;
        return $this->fetchAll($sql, [
            ':user_id' => $user_id
        ]);
    }

    //==============================================================================
    //ツイート詳細と返信
    //==============================================================================

    public function getDetailTweet($tweet_id)
    {
        $sql = <<< EOF
SELECT tweets.id, tweets.user_id, tweets.text, tweets.reply_to_id, tweets.created_at, users.name, users.unique_name
FROM tweets
INNER JOIN users
    ON tweets.user_id = users.id
WHERE tweets.id = :tweet_id
ORDER BY created_at DESC;
EOF;

        return $this->fetch($sql, [
            ':tweet_id' => $tweet_id
        ]);

    }

    public function getReplies($tweet_id)
    {
        //todo: 返信への返信にも対応
        $sql =  <<< EOF
SELECT tweets.id, tweets.user_id, tweets.text, tweets.reply_to_id, tweets.created_at, users.name, users.unique_name
FROM tweets
INNER JOIN users
    ON tweets.user_id = users.id
WHERE tweets.reply_to_id = :tweet_id
ORDER BY created_at ASC;
EOF;

        return $this->fetchAll($sql, [
            ':tweet_id' => $tweet_id,
        ]);
    }

    //==============================================================================
    //ユーザープロフィール
    //==============================================================================
    public function getUserTweet($user_id)
    {
        $sql = 'SELECT * FROM tweets where user_id = :user_id ORDER BY created_at DESC;';
        return $this->fetchAll($sql, [
            ':user_id' => $user_id
        ]);
    }
}