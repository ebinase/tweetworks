<?php

namespace App\Model;

use App\System\Classes\Model;

class Favorite extends Model
{

    protected function _setTableName()
    {
        $this->_tableName = 'favorites';
    }

    public function getFavoriteTweets($user_id)
    {
        $sql = <<< EOF
SELECT DISTINCT
    tweets.id, tweets.user_id, tweets.text, tweets.reply_to_id, tweets.created_at,
    users.name, users.unique_name
FROM favorites
         INNER JOIN tweets
                    ON favorites.tweet_id = tweets.id
         INNER JOIN users
                    ON tweets.user_id = users.id
WHERE favorites.user_id = :user_id
ORDER BY tweets.created_at DESC;
EOF;
        return $this->fetchAll($sql, [
            ':user_id' => $user_id
        ]);
    }

}