<?php

namespace App\Model;

use App\System\Classes\Model;

class Favorite extends Model
{

    protected function _setTableName()
    {
        $this->_tableName = 'favorites';
    }

    public function getFavoriteTweets($user_id, $logedin_id)
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
ORDER BY f.created_at DESC;
EOF;
        return $this->fetchAll($sql, [
            ':user_id' => $user_id,
            ':logedin_id' => $logedin_id
        ]);
    }


    public function checkIfFavoriteTweet($user_id, $tweet_id)
    {
        $sql = "SELECT count(*) FROM {$this->_tableName} WHERE user_id = :user_id AND tweet_id = :tweet_id;";
        //execute()->rowCount()が期待通り動作しなかったため、fetchを使用。
        $result = $this->fetch($sql, [
            ':user_id' => $user_id ,
            ':tweet_id' => $tweet_id
        ]);
        return $result['count(*)'];
    }

    public function unsetUsersFav($user_id, $tweet_id)
    {
        $sql = "DELETE FROM {$this->_tableName} WHERE user_id = :user_id AND tweet_id = :tweet_id";
        return $this->smartExecute($sql, [
            ':user_id' => $user_id ,
            ':tweet_id' => $tweet_id
        ]);
    }

    public function countFavs($tweet_id)
    {
        return $this->smartCount('tweet_id', $tweet_id);
    }
}