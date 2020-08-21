<?php

namespace App\Model;

use App\System\Classes\Model;

class Follow extends Model
{

    protected function _setTableName()
    {
        $this->_tableName = 'follows';
    }

    public function countFollows($user_id)
    {
        return $this->smartCount('user_id' ,$user_id);
    }

    public function countFollowers($user_id)
    {
        return $this->smartCount('user_id_followed' ,$user_id);
    }

    public function getFollowsIndex($user_id)
    {
        $sql = <<< EOF
SELECT follows.user_id_followed, users.id, users.name, users.unique_name
FROM follows
INNER JOIN users
    ON follows.user_id_followed = users.id
WHERE follows.user_id = :user_id
ORDER BY follows.created_at DESC;
EOF;

        return $this->fetchAll($sql, [':user_id' => $user_id]);
    }

    public function getFollowersIndex($user_id)
    {
        $sql = <<< EOF
SELECT follows.user_id, users.id, users.name, users.unique_name
FROM follows
INNER JOIN users
    ON follows.user_id = users.id
WHERE follows.user_id_followed = :user_id
ORDER BY follows.created_at DESC;
EOF;

        return $this->fetchAll($sql, [':user_id' => $user_id]);
    }
}