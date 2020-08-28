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
SELECT DISTINCT
    #ツイートの表示に必要な情報
    t.id, t.user_id, t.text, t.reply_to_id, t.created_at,
    u.name, u.unique_name,
    (SELECT count(*) FROM favorites WHERE tweet_id = t.id) AS favs,
    (SELECT count(*) FROM tweets WHERE reply_to_id = t.id) AS replies
FROM tweets t
INNER JOIN users u
    ON t.user_id = u.id
WHERE t.reply_to_id IS NULL
ORDER BY t.created_at DESC;
EOF;

        return $this->fetchAll($sql);
    }

    public function getTimeline($user_id)
    {
        //フォローテーブルをもとにフォローしてるユーザーの返信以外のツイートをユーザー情報ごと取得
        //FIXME:DISTINCTで無理やり期待する結果にしているため、正しく理解してから修正
        $sql = <<< EOF
SELECT DISTINCT
    #ツイートの表示に必要な情報
    t.id, t.user_id, t.text, t.reply_to_id, t.created_at,
    u.name, u.unique_name,
    #お気に入りボタンなどに必要な情報
    (SELECT count(*) FROM favorites WHERE tweet_id = t.id) AS favs, #ツイートのお気に入りの数
    (SELECT count(*) FROM favorites WHERE user_id = :user_id AND tweet_id = t.id) AS my_fav, #自身のお気に入りか(1or0)
    (SELECT count(*) FROM tweets WHERE reply_to_id = t.id) AS replies #リプライの数
FROM follows
         #フォローしているユーザーのツイートを結合
         INNER JOIN tweets t
                    #フォローしているユーザーのツイートを取得
                    ON follows.user_id_followed = t.user_id
                    #タイムラインに自分自身のツイートも表示するため、自身のツイートも取得
                    OR t.user_id = :user_id
         INNER JOIN users u
                    ON t.user_id = u.id
#フォローしているユーザーだけに絞り込み
WHERE follows.user_id = :user_id
        #タイムラインにリプライを表示しない
        AND t.reply_to_id IS NULL
ORDER BY t.created_at DESC;
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
    //特定のユーザーのツイートだけ(返信を含まない)ツイートを取得
    public function getUserTweets($user_id)
    {
        $sql = 'SELECT * FROM tweets  ORDER BY created_at DESC;';
        $sql = <<< EOF
SELECT tweets.id, tweets.user_id, tweets.text, tweets.reply_to_id, tweets.created_at,
       users.name, users.unique_name
FROM tweets
INNER JOIN users
    ON tweets.user_id = users.id
WHERE tweets.user_id = :user_id
    AND tweets.reply_to_id IS NULL
ORDER BY tweets.created_at DESC;
EOF;
        return $this->fetchAll($sql, [
            ':user_id' => $user_id,
        ]);
    }

    //特定のユーザーの返信だけを取得
    public function getUserReplies($user_id)
    {
        $sql = 'SELECT * FROM tweets  ORDER BY created_at DESC;';
        $sql = <<< EOF
SELECT tweets.id, tweets.user_id, tweets.text, tweets.reply_to_id, tweets.created_at,
       users.name, users.unique_name
FROM tweets
INNER JOIN users
    ON tweets.user_id = users.id
WHERE tweets.user_id = :user_id
    AND tweets.reply_to_id IS NOT NULL 
ORDER BY tweets.created_at DESC;
EOF;
        return $this->fetchAll($sql, [
            ':user_id' => $user_id,
        ]);
    }
}