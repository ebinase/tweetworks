<?php

namespace App\Model;

use App\System\Model;

class User extends Model
{

    protected function _setTableName()
    {
        $this->_tableName = 'users';
    }

    public function fetchByUniqueName($unique_name) {
        $sql = "SELECT * FROM {$this->_tableName} WHERE unique_name = :unique_name";
        return $this->fetch($sql, [
            ':unique_name' => $unique_name,
        ]);
    }
}