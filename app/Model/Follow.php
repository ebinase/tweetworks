<?php

namespace App\Model;

use App\System\Model;

class Follow extends Model
{

    protected function _setTableName()
    {
        $this->_tableName = 'follows';
    }

    public function fetchByFollowUserId($followed_id) {
        $sql = "SELECT * FROM {$this->_tableName} WHERE followed_id = :followed_id";
        return $this->fetch($sql, [
            ':followed_id' => $followed_id,
        ]);
    }

}