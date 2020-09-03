<?php

namespace App\Model;

use App\System\Classes\Model;

class Favorite extends Model
{

    protected function _setTableName()
    {
        $this->_tableName = 'favorites';
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