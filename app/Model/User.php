<?php

namespace App\Model;

use App\System\Model;

class User extends Model
{

    protected function _setTableName()
    {
        $this->_tableName = 'users';
    }

}