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
    public function getTimeline($user_id, $start, $tweetsPerPage)
    {

        //フォローテーブルをもとにフォローしてるユーザーの返信以外のツイートをユーザー情報ごと取得
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
ORDER BY t.created_at DESC
LIMIT :start, :offset;
EOF;

        //smartExecuteではlimit句のプレースホルダに文字列型('')で代入されてしまうため、丁寧にbindValue

        return $this->fetchAll($sql, [
            ':user_id' => $user_id,
            ':start' => (int) $start,
            ':offset' => (int) $tweetsPerPage
        ], true);
    }

    public function getAllTweetExceptReply($user_id, $start, $tweetsPerPage)
    {
            //ユーザーがログインしていたらお気に入りも取得
            $sql = <<< EOF
SELECT DISTINCT
    #ツイートの表示に必要な情報
    t.id, t.user_id, t.text, t.reply_to_id, t.created_at,
    u.name, u.unique_name,
    (SELECT count(*) FROM favorites WHERE tweet_id = t.id) AS favs,
    (SELECT count(*) FROM favorites WHERE user_id = :user_id AND tweet_id = t.id) AS my_fav, #自身のお気に入りか(1or0) 
    (SELECT count(*) FROM tweets WHERE reply_to_id = t.id) AS replies
FROM tweets t
INNER JOIN users u
    ON t.user_id = u.id
WHERE t.reply_to_id IS NULL
ORDER BY t.created_at DESC
LIMIT :start, :offset;
EOF;

            return $this->fetchAll($sql, [
                ':user_id' => $user_id,
                ':start' => (int) $start,
                ':offset' => (int) $tweetsPerPage
            ], true);
    }



    //==============================================================================
    //ツイート詳細と返信
    //==============================================================================

    public function getDetailTweet($tweet_id, $user_id)
    {
        $sql = <<< EOF
SELECT DISTINCT
    #ツイートの表示に必要な情報
    t.id, t.user_id, t.text, t.reply_to_id, t.created_at,
    u.name, u.unique_name,
    (SELECT count(*) FROM favorites WHERE tweet_id = t.id) AS favs,
    (SELECT count(*) FROM favorites WHERE user_id = :user_id AND tweet_id = t.id) AS my_fav, #自身のお気に入りか(1or0) 
    (SELECT count(*) FROM tweets WHERE reply_to_id = t.id) AS replies
FROM tweets t
INNER JOIN users u
    ON t.user_id = u.id
WHERE t.id = :tweet_id
ORDER BY t.created_at DESC;
EOF;

        return $this->fetch($sql, [
            ':tweet_id' => $tweet_id,
            ':user_id' => $user_id
        ]);

    }

    public function getReplies($tweet_id, $user_id)
    {
        //todo: 返信への返信にも対応
        $sql =  <<< EOF
SELECT DISTINCT
    #ツイートの表示に必要な情報
    t.id, t.user_id, t.text, t.reply_to_id, t.created_at,
    u.name, u.unique_name,
    (SELECT count(*) FROM favorites WHERE tweet_id = t.id) AS favs,
    (SELECT count(*) FROM favorites WHERE user_id = :user_id AND tweet_id = t.id) AS my_fav, #自身のお気に入りか(1or0) 
    (SELECT count(*) FROM tweets WHERE reply_to_id = t.id) AS replies
FROM tweets t
INNER JOIN users u
    ON t.user_id = u.id
WHERE t.reply_to_id = :tweet_id
ORDER BY t.created_at ASC;
EOF;

        return $this->fetchAll($sql, [
            ':tweet_id' => $tweet_id,
            ':user_id' => $user_id
        ]);
    }

    //==============================================================================
    //ユーザープロフィール
    //==============================================================================
    //特定のユーザーのツイートだけ(返信を含まない)ツイートを取得
    public function getUserTweets($user_id, $logedin_id, $start, $tweetsPerPage)
    {
        $sql = <<< EOF
SELECT DISTINCT
    #ツイートの表示に必要な情報
    t.id, t.user_id, t.text, t.reply_to_id, t.created_at,
    u.name, u.unique_name,
    (SELECT count(*) FROM favorites WHERE tweet_id = t.id) AS favs,
    (SELECT count(*) FROM favorites WHERE user_id = :logedin_id AND tweet_id = t.id) AS my_fav, #自身のお気に入りか(1or0) 
    (SELECT count(*) FROM tweets WHERE reply_to_id = t.id) AS replies
FROM tweets t
INNER JOIN users u
    ON t.user_id = u.id
WHERE t.user_id = :user_id
      AND t.reply_to_id IS NULL
ORDER BY t.created_at DESC
LIMIT :start, :offset;
EOF;
        return $this->fetchAll($sql, [
            ':user_id' => $user_id,
            ':logedin_id' => $logedin_id,
            ':start' => (int) $start,
            ':offset' => (int) $tweetsPerPage
        ], true
        );
    }

    //特定のユーザーの返信だけを取得
    public function getUserReplies($user_id, $logedin_id, $start, $tweetsPerPage)
    {
        $sql = <<< EOF
SELECT DISTINCT
    #ツイートの表示に必要な情報
    t.id, t.user_id, t.text, t.reply_to_id, t.created_at,
    u.name, u.unique_name,
    (SELECT count(*) FROM favorites WHERE tweet_id = t.id) AS favs,
    (SELECT count(*) FROM favorites WHERE user_id = :logedin_id AND tweet_id = t.id) AS my_fav, #自身のお気に入りか(1or0) 
    (SELECT count(*) FROM tweets WHERE reply_to_id = t.id) AS replies
FROM tweets t
INNER JOIN users u
    ON t.user_id = u.id
WHERE t.user_id = :user_id
      AND t.reply_to_id IS NOT NULL
ORDER BY t.created_at DESC
LIMIT :start, :offset;
EOF;
        return $this->fetchAll($sql, [
            ':user_id' => $user_id,
            ':logedin_id' => $logedin_id,
            ':start' => (int) $start,
            ':offset' => (int) $tweetsPerPage
        ], true
        );
    }

    public function getFavoriteTweets($user_id, $logedin_id, $start, $tweetsPerPage)
    {
        $sql = <<< EOF
SELECT
    #ツイートの表示に必要な情報
    t.id, t.user_id, t.text, t.reply_to_id, t.created_at,
    u.name, u.unique_name,
    #お気に入りボタンなどに必要な情報
    (SELECT count(*) FROM favorites WHERE tweet_id = f.tweet_id) AS favs, #ツイートのお気に入りの数
    (SELECT count(*) FROM favorites WHERE user_id = :logedin_id AND tweet_id = f.tweet_id) AS my_fav, #ログイン中ユーザーのお気に入りか(1or0)
    (SELECT count(*) FROM tweets WHERE reply_to_id = f.tweet_id) AS replies #リプライの数
FROM favorites f
         INNER JOIN tweets t
                    ON f.tweet_id = t.id
         INNER JOIN users u
                    ON t.user_id = u.id
WHERE f.user_id = :user_id
ORDER BY f.created_at DESC
LIMIT :start, :offset;
EOF;
        return $this->fetchAll($sql, [
            ':user_id' => $user_id,
            ':logedin_id' => $logedin_id,
            ':start' => (int) $start,
            ':offset' => (int) $tweetsPerPage
        ], true
        );
    }

    //==============================================================================
    //ペジネーション用
    //==============================================================================
    public function countTimelineTweets($user_id)
    {
        $sql = <<<EOF
SELECT count(*)
FROM follows
    INNER JOIN tweets t
        ON follows.user_id_followed = t.user_id
        OR t.user_id = :user_id
WHERE follows.user_id = :user_id
    AND t.reply_to_id IS NULL;
EOF;

        $result = $this->fetch($sql, [':user_id' => $user_id]);
        return $result['count(*)'];
    }

    public function countAllTweets()
    {
        $sql = <<<EOF
SELECT count(*)
FROM tweets
WHERE tweets.reply_to_id IS NULL;
EOF;

        $result = $this->fetch($sql);
        return $result['count(*)'];
    }

    //ユーザーページでツイートを表示するとき
    public function countProfileTweets($user_id)
    {
        $sql = <<<EOF
SELECT count(*)
FROM tweets
WHERE tweets.reply_to_id IS NULL
        AND tweets.user_id = :user_id;
EOF;

        $result = $this->fetch($sql,[
            ':user_id' => $user_id,
        ]);
        return $result['count(*)'];
    }

    public function countProfileReplies($user_id)
    {
        $sql = <<<EOF
SELECT count(*)
FROM tweets
WHERE tweets.reply_to_id IS NOT NULL
        AND tweets.user_id = :user_id;
EOF;

        $result = $this->fetch($sql,[
            ':user_id' => $user_id,
        ]);
        return $result['count(*)'];
    }

    public function countProfileFavorites($user_id)
    {
        $sql = <<<EOF
SELECT count(*)
FROM favorites
WHERE favorites.user_id = :user_id;
EOF;
        $result = $this->fetch($sql,[
            ':user_id' => $user_id,
        ]);
        return $result['count(*)'];
    }
}